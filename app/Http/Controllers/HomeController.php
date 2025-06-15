<?php

namespace App\Http\Controllers;

use App\Services\SAWService;
use App\Models\Restaurant\Review;
use Illuminate\Support\Collection;
use App\Models\Restaurant\Restaurant;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $comment = Review::get();
        return view('home', [
            'ranked' => $this->getRankedRestaurants(),
            'comments' => $comment
        ]);
    }

    public function list(Request $request)
    {
        $allRestaurants = $this->getRankedRestaurants();

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

        $perPage = 9;
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

    public function reviews()
    {
        $comment = Review::get();
        return view('reviews', [
            'comments' => $comment
        ]);
    }

    private function getRankedRestaurants()
    {
        $restaurants = Restaurant::with('offerings')->get();
        $userLat = session('latitude');
        $userLng = session('longitude');

        // If the user's location is not available, return the unranked list
        if (!$userLat || !$userLng) {
            return $restaurants;
        }

        // Process restaurant data with distances and other attributes
        $restaurantData = $restaurants->map(function ($restaurant) use ($userLat, $userLng) {
            return $this->processRestaurantData($restaurant, $userLat, $userLng);
        });

        // Weights for SAW algorithm
        $weights = [
            'rating'    => 0.235,
            'reviews'   => 0.118,
            'distance'  => 0.588,
            'is_halal'  => 0.029,
            'is_closed' => 0.029,
        ];

        $criteriaTypes = [
            'rating' => 'benefit',
            'reviews' => 'benefit',
            'distance' => 'cost',
            'is_halal' => 'benefit',
            'is_closed' => 'benefit',
        ];

        // Calculate rankings using SAWService
        $sawService = new SAWService();
        $ranked = $sawService->calculate($restaurantData, $weights, $criteriaTypes);

        // Return the ranked list to the specified view
        return $ranked;
    }

    private function processRestaurantData($restaurant, $userLat, $userLng)
    {
        $distance = $this->haversineDistance($userLat, $userLng, $restaurant->latitude, $restaurant->longitude);
        $restaurant->distance = round($distance, 2);
        $restaurant->is_halal = $restaurant->is_halal ? 1 : 0;
        $restaurant->is_closed = $restaurant->isClosed() ? 1 : 0;

        return $restaurant;
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
