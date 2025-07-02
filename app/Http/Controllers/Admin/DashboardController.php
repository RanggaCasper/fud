<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function index()
    {
        return view('admin.dashboard', [
            'userCount' => \App\Models\User::whereHas('role', function ($query) {
                $query->where('name', '!=', 'admin');
            })->count(),
            'restaurantCount' => \App\Models\Restaurant\Restaurant::count(),
            'reviewCount' => \App\Models\Restaurant\Review::count(),
            'highestRatedRestaurants' => \App\Models\Restaurant\Restaurant::withAvg('reviews', 'rating')
                ->orderByDesc('rating')
                ->limit(5)
                ->get(),
            'mostReviewedRestaurants' => \App\Models\Restaurant\Restaurant::orderByRaw('CAST(reviews AS UNSIGNED) DESC')
                ->limit(5)
                ->get(),
        ]);
    }

    public function gscData(Request $request)
    {
        $gsc = app(\App\Services\GSCService::class);
        $days = $request->get('days', 7);

        return ResponseFormatter::success('Data retrieved successfully', [
            'queries' => $gsc->getTopQueries($days),
            'pages' => $gsc->getTopPages($days),
            'countries' => $gsc->getTopCountries($days),
            'devices' => $gsc->getTopDevices($days),
            'appearances' => $gsc->getSearchAppearances($days),
        ]);
    }
}
