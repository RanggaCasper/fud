<?php

namespace App\Http\Controllers;

use App\Models\Restaurant;
use App\Services\SAWService;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $restaurants = Restaurant::all();

        $userLat = session('latitude');
        $userLng = session('longitude');

        if (!$userLat || !$userLng) {
            return view('home', ['ranked' => $restaurants]);
        }

        $restaurantData = $restaurants->map(function ($restaurant) use ($userLat, $userLng) {
            $distance = $this->haversineDistance(
                $userLat,
                $userLng,
                $restaurant->latitude,
                $restaurant->longitude
            );

            $restaurant->distance = round($distance, 2); 
            $restaurant->is_halal = $restaurant->is_halal ? 1 : 0;
            $restaurant->is_closed = $restaurant->isClosed() ? 1 : 0;

            return $restaurant;
        });
        
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

        $sawService = new SAWService();
        $ranked = $sawService->calculate($restaurantData, $weights, $criteriaTypes);

        return view('home', compact('ranked'));
    }

    public function list()
    {
        $restaurants = Restaurant::all();

        $userLat = session('latitude');
        $userLng = session('longitude');

        if (!$userLat || !$userLng) {
            return view('list', ['ranked' => $restaurants]);
        }

        $restaurantData = $restaurants->map(function ($restaurant) use ($userLat, $userLng) {
            $distance = $this->haversineDistance(
                $userLat,
                $userLng,
                $restaurant->latitude,
                $restaurant->longitude
            );

            $restaurant->distance = round($distance, 2); 
            $restaurant->is_halal = $restaurant->is_halal ? 1 : 0;
            $restaurant->is_closed = $restaurant->isClosed() ? 1 : 0;

            return $restaurant;
        });
        
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

        $sawService = new SAWService();
        $ranked = $sawService->calculate($restaurantData, $weights, $criteriaTypes);

        return view('list', compact('ranked'));
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
