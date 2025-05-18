<?php

namespace App\Http\Controllers\Api;

use App\Models\Restaurant;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class SerpApiController extends Controller
{
    public function search(Request $request)
    {
        $query = 'restaurant';
        $latitude = '-8.7998524';
        $longitude = '115.2079624';
        $zoom = '11';

        $serpApiService = new \App\Services\SerpApiService();

        $start = 0;
        $processedResultsCount = 0;
        $loopCount = 0; // counter loop
        $maxLoops = 5;

        $results = $serpApiService->searchPlaces($query, $latitude, $longitude, $zoom, $start);

        while ($results && $loopCount < $maxLoops) {
            foreach ($results['local_results'] as $restaurantData) {
                $operatingHours = $restaurantData['operating_hours'] ?? [];

                $isHalal = false;
                foreach ($restaurantData['extensions'] ?? [] as $extension) {
                    if (isset($extension['offerings']) && is_array($extension['offerings'])) {
                        $isHalal = in_array('Halal food', $extension['offerings']);
                        break;
                    }
                }

                $thumbnailUrl = strstr($restaurantData['thumbnail'], '=w', true) ?: $restaurantData['thumbnail'];

                $restaurant = Restaurant::firstOrCreate(
                    [
                        'name' => $restaurantData['title'],
                        'address' => $restaurantData['address'],
                    ],
                    [
                        'phone' => $restaurantData['phone'] ?? null,
                        'website' => $restaurantData['website'] ?? null,
                        'thumbnail' => $thumbnailUrl,
                        'latitude' => $restaurantData['gps_coordinates']['latitude'],
                        'longitude' => $restaurantData['gps_coordinates']['longitude'],
                        'rating' => $restaurantData['rating'],
                        'reviews' => $restaurantData['reviews'],
                        'price_range' => $restaurantData['price'] ?? null,
                        'is_halal' => $isHalal,
                    ]
                );

                foreach ($operatingHours as $day => $hours) {
                    $restaurant->operatingHours()->firstOrCreate(
                        ['day' => ucfirst($day)],
                        ['operating_hours' => $hours]
                    );
                }

                $processedResultsCount++;
            }

            $loopCount++; // tambahkan loop counter

            // Pagination: jika sudah proses kelipatan 20, ambil batch selanjutnya
            if ($processedResultsCount % 20 === 0 && $loopCount < $maxLoops) {
                $start += 20;
                $results = $serpApiService->searchPlaces($query, $latitude, $longitude, $zoom, $start);
            } else {
                break; // keluar jika bukan kelipatan 20 atau sudah maksimum loop
            }
        }

        return ResponseFormatter::success('All data retrieved and stored successfully.');
    }
}
