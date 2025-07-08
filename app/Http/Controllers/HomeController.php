<?php

namespace App\Http\Controllers;

use App\Helpers\Rank;
use Illuminate\Http\Request;
use App\Models\Restaurant\Review;
use Illuminate\Support\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class HomeController extends Controller
{
    public function index()
    {
        return view('home', [
            'restaurants' => Rank::getRankedRestaurants()->take(6),
            'comments' => Review::with(['restaurant', 'attachments'])
                ->whereHas('attachments')
                ->latest('id')
                ->take(6)
                ->get(),
        ]);
    }

    public function list(Request $request, $region = null)
    {
        $region = $region ? urldecode(str_replace('-', ' ', $region)) : null;

        $rankedRestaurants = Rank::getRankedRestaurants($region);

        $restaurants = $rankedRestaurants instanceof Collection ? $rankedRestaurants : collect($rankedRestaurants);

        if ($request->filled('offerings')) {
            $offerings = $request->input('offerings');
            $restaurants = $restaurants->filter(
                fn($r) =>
                !empty(array_intersect(
                    collect($r['offerings'])->pluck('name')->all(),
                    $offerings
                ))
            );
        }

        if ($request->filled('status') && $request->input('status') !== 'all') {
            $status = $request->input('status');
            $restaurants = $restaurants->filter(
                fn($r) =>
                $status === 'open' ? !$r->isClosed() : $r->isClosed()
            );
        }

        $sortBy = $request->input('sort_by');
        $restaurants = match ($sortBy) {
            'rating_asc'     => $restaurants->sortBy('rating'),
            'rating_desc'    => $restaurants->sortByDesc('rating'),
            'distance_asc'   => $restaurants->sortBy('distance'),
            'distance_desc'  => $restaurants->sortByDesc('distance'),
            default          => $restaurants->sortByDesc('popularity'),
        };

        $perPage = 6;
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $pagedData = $restaurants->slice(($currentPage - 1) * $perPage, $perPage)->values();
        $paginator = new LengthAwarePaginator(
            $pagedData,
            $restaurants->count(),
            $perPage,
            $currentPage,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        if ($request->ajax()) {
            return view('partials.restaurant-items', ['restaurants' => $paginator])->render();
        }

        return view('list', ['restaurants' => $paginator]);
    }
}
