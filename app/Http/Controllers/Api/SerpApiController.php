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
        $latitude = '-8.7980879';
        $longitude = '115.2231997';
        $zoom = '11';

        $serpApiService = new \App\Services\SerpApiService();

        $start = 0; // Start parameter for pagination
        $processedResultsCount = 0; // Counter to track the number of results processed

        // Initial API call
        $results = $serpApiService->searchPlaces($query, $latitude, $longitude, $zoom, $start);

        while ($results) {
            foreach ($results['local_results'] as $restaurantData) {
                $operatingHours = $restaurantData['operating_hours'] ?? [];

                $isHalal = false;
                if (isset($restaurantData['offerings']) && is_array($restaurantData['offerings'])) {
                    $isHalal = in_array('Halal food', $restaurantData['offerings']);
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

                // After processing 20 results, increase the start index for pagination
                if ($processedResultsCount % 20 === 0) {
                    $start += 20; // Increase the start index by 20 for the next batch
                    $results = $serpApiService->searchPlaces($query, $latitude, $longitude, $zoom, $start);
                }
            }

            // Exit loop if there are no more results to process
            if ($processedResultsCount % 20 !== 0) {
                break;
            }
        }

        return ResponseFormatter::success('All data retrieved and stored successfully.');
    }
}
