<?php

namespace App\Http\Controllers;

use App\Services\SAWService;
use App\Models\Restaurant\Review;
use App\Models\Restaurant\Restaurant;

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

    public function list()
    {
        return view('list', [
            'ranked' => $this->getRankedRestaurants()
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
        $restaurants = Restaurant::all();
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
