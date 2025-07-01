<?php

namespace App\Http\Controllers;

use Illuminate\Support\Str;
use App\Services\SAWService;
use Illuminate\Http\Request;
use App\Models\Restaurant\Review;
use App\Helpers\ResponseFormatter;
use App\Services\PlaceDataService;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Http;
use App\Models\Restaurant\Restaurant;
use Illuminate\Support\Facades\Blade;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index()
    {
        $comment = Review::with('restaurant')
            ->latest('id')
            ->take(6)
            ->get();

        return view('home', [
            'restaurants' => $this->getRankedRestaurants()->take(6),
            'comments' => $comment
        ]);
    }

    public function list(Request $request, $region = null)
    {
        $region = $region ? urldecode(str_replace('-', ' ', $region)) : null;
        $allRestaurants = $this->getRankedRestaurants($region);

        // Apply filters
        if ($request->filled('sort_by')) {
            $sortBy = $request->input('sort_by');
            if ($sortBy == 'rating_desc') {
                $allRestaurants = $allRestaurants->sortByDesc('rating');
            } elseif ($sortBy == 'rating_asc') {
                $allRestaurants = $allRestaurants->sortBy('rating');
            } elseif ($sortBy == 'distance_asc') {
                $allRestaurants = $allRestaurants->sortBy('distance');
            } elseif ($sortBy == 'distance_desc') {
                $allRestaurants = $allRestaurants->sortByDesc('distance');
            } else {
                $allRestaurants = $allRestaurants->sortByDesc('popularity');
            }
        }

        if ($request->filled('offerings')) {
            $selectedOfferings = $request->input('offerings');
            $allRestaurants = $allRestaurants->filter(function ($restaurant) use ($selectedOfferings) {
                $restaurantOfferingNames = collect($restaurant['offerings'])->pluck('name')->all();
                return !empty(array_intersect($restaurantOfferingNames, $selectedOfferings));
            });
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');

            $allRestaurants = $allRestaurants->filter(function ($restaurant) use ($status) {
                return $status === 'open'
                    ? !$restaurant->isClosed()
                    : $restaurant->isClosed();
            });
        }

        $perPage = 6;
        $currentPage = $request->input('page', 1);

        if (!($allRestaurants instanceof Collection)) {
            $allRestaurants = collect($allRestaurants);
        }

        $pagedRestaurants = $allRestaurants->slice(($currentPage - 1) * $perPage, $perPage)->values();

        $paginator = new LengthAwarePaginator(
            $pagedRestaurants,
            $allRestaurants->count(),
            $perPage,
            $currentPage,
            ['path' => url()->current()]
        );

        if ($request->ajax()) {
            return view('partials.restaurant-items', ['restaurants' => $paginator])->render();
        }

        return view('list', [
            'restaurants' => $paginator,
        ]);
    }

    public function reviews(Request $request)
    {
        $comment = Review::with(['user', 'attachments'])->orderBy('created_at', 'desc')->paginate(6);

        if ($request->ajax()) {
            return view('partials.review-list', ['comments' => $comment])->render();
        }

        return view('reviews', [
            'comments' => $comment
        ]);
    }

    public function fetchImage($place_id, PlaceDataService $placeService)
    {
        $result = $placeService->fetchImages($place_id);
        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }

    public function fetchReservation($place_id, PlaceDataService $placeService)
    {
        $result = $placeService->fetchReservationData($place_id);
        return response()->json($result, $result['success'] ? 200 : ($result['status'] ?? 500));
    }

    public function storeReservation(Request $request)
    {
        $request->validate([
            'date' => ['required', 'date', 'after_or_equal:tomorrow'],
            'time' => ['required'],
            'adults' => ['required', 'integer', 'min:1'],
            'children' => ['required', 'integer', 'min:0'],
            'rid' => ['required', 'string', 'max:255'],
        ]);

        $params = [
            "date" => $request->date,
            "time" => $request->time,
            "adults" => $request->adults,
            "children" => $request->children,
            "rid" => $request->rid,
        ];

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0'
            ])->get('https://book.chope.co/booking/check', $params);

            $redirectedUrl = $response->effectiveUri() ?? null;

            return ResponseFormatter::redirected('Redirected.', $redirectedUrl);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan: ' . $e->getMessage()
            ], 500);
        }
    }

    private function getRankedRestaurants($region = null)
    {
        $restaurants = Restaurant::with(['offerings', 'operatingHours'])
            ->withCount('reviews')
            ->withAvg('reviews', 'rating')
            ->get();

        $userLat = session('latitude');
        $userLng = session('longitude');

        if (!$userLat || !$userLng) {
            return $restaurants->filter(function ($restaurant) use ($region) {
                return str_contains(strtolower($restaurant->address), $region);
            });
        }

        // Optional filter by region (contoh: denpasar)
        if ($region) {
            $region = strtolower($region);
            $restaurants = $restaurants->filter(function ($restaurant) use ($region) {
                return str_contains(strtolower($restaurant->address), $region);
            });
        }

        // Proses rating + SAW
        $restaurantData = $restaurants->map(function ($restaurant) use ($userLat, $userLng) {
            $processed = $this->processRestaurantData($restaurant, $userLat, $userLng);

            $googleRating = $processed['rating'] ?? 0;
            $googleReviews = $processed['reviews'] ?? 0;

            $fudReviews = $restaurant->reviews_count;
            $fudRating = $restaurant->reviews_avg_rating ?? 0;

            $totalReviews = $googleReviews + $fudReviews;
            $combinedRating = $totalReviews > 0
                ? round((($googleRating * $googleReviews) + ($fudRating * $fudReviews)) / $totalReviews, 2)
                : 0;

            $processed['rating'] = $combinedRating;
            $processed['reviews'] = $totalReviews;

            return $processed;
        });

        $weights = [
            'rating'    => 0.250,
            'reviews'   => 0.125,
            'distance'  => 0.625,
        ];

        $criteriaTypes = [
            'rating'    => 'benefit',
            'reviews'   => 'benefit',
            'distance'  => 'cost',
        ];

        $sawService = new SAWService();
        $ranked = $sawService->calculate($restaurantData, $weights, $criteriaTypes);

        return $ranked;
    }

    private function processRestaurantData($restaurant, $userLat, $userLng)
    {
        $distance = $this->haversineDistance($userLat, $userLng, $restaurant->latitude, $restaurant->longitude);
        $restaurant->distance = round($distance, 2);
        $restaurant->is_halal = $restaurant->is_halal ? 1 : 0;
        $restaurant->is_closed = $restaurant->getIsClosedCached();

        return $restaurant;
    }

    public function search(Request $request)
    {
        $query = trim($request->input('search'));
        $regionSuggestion = collect();
        $filtered = collect();

        if (!empty($query)) {
            $q = strtolower($query);

            $regionSuggestion = \App\Models\Restaurant\Restaurant::pluck('address')
                ->flatMap(fn($address) => collect(explode(',', strtolower($address))))
                ->map(fn($part) => trim($part))
                ->filter(function ($part) {
                    if (Str::contains($part, ['jl', 'no']) || preg_match('/\d/', $part)) return false;
                    $words = explode(' ', $part);
                    if (count($words) > 2) return false;
                    foreach ($words as $word) {
                        if (strlen($word) < 4) return false;
                    }
                    return true;
                })
                ->filter(fn($part) => Str::contains($part, $q))
                ->countBy()
                ->filter(fn($count) => $count >= 3)
                ->keys()
                ->map(fn($region) => Str::title($region))
                ->values();

            $rankedRestaurants = $this->getRankedRestaurants();

            $filtered = $rankedRestaurants->map(function ($restaurant) use ($q) {
                $name = strtolower($restaurant->name ?? '');
                $desc = strtolower($restaurant->description ?? '');
                $addr = strtolower($restaurant->address ?? '');

                similar_text($q, $name, $nameScore);
                similar_text($q, $desc, $descScore);
                similar_text($q, $addr, $addrScore);

                $boost = 0;
                if (str_contains($name, $q) || str_contains($q, $name)) {
                    $boost += 0.4;
                } elseif (Str::of($q)->explode(' ')->contains(fn($word) => str_contains($name, $word))) {
                    $boost += 0.2;
                }

                $restaurant->search_score = ($nameScore * 0.5 + $descScore * 0.3 + $addrScore * 0.2) / 100 + $boost;
                return $restaurant;
            })
                ->sortByDesc('search_score')
                ->filter(fn($r) => $r->search_score >= 0.3)
                ->take(10);
        }

        if ($request->ajax()) {
            return view('partials.search-items', [
                'restaurants' => $filtered,
                'regionSuggestion' => $regionSuggestion,
            ])->render();
        }

        return view('search', [
            'restaurants' => $filtered,
            'regionSuggestion' => $regionSuggestion,
            'query' => $query,
        ]);
    }

    private function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371; // km
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) * sin($dLat / 2) +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) * sin($dLon / 2);

        $c = 2 * atan2(sqrt($a), sqrt(1 - $a));
        return $earthRadius * $c;
    }
}
