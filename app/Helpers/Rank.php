<?php

namespace App\Helpers;

use App\Models\Restaurant\Restaurant;
use App\Models\SAWCriteria;
use App\Services\SAWService;
use Illuminate\Support\Collection;

class Rank
{
        public static function getRankedRestaurants(?string $region = null, ?float $latitude = null, ?float $longitude = null): Collection
        {
            $latitude = $latitude ?? session('latitude');
            $longitude = $longitude ?? session('longitude');
            
            $criteriaData = SAWCriteria::all();

            $criteria = $criteriaData->pluck('name')->toArray();
            $weights = $criteriaData->pluck('weight', 'name')->toArray();
            $criteriaTypes = $criteriaData->pluck('type', 'name')->toArray();

            foreach ($criteria as $key) {
                if (!array_key_exists($key, $weights) || !array_key_exists($key, $criteriaTypes)) {
                    throw new \InvalidArgumentException("Missing weight or criteria type for: {$key}");
                }
            }

            $restaurants = Restaurant::with(['offerings', 'operatingHours', 'ad'])
                ->withCount('reviews')
                ->withAvg('reviews', 'rating')
                ->get();

            if ($region) {
                $region = strtolower($region);
                $restaurants = $restaurants->filter(function ($restaurant) use ($region) {
                    return str_contains(strtolower($restaurant->address), $region);
                });
            }

            $processed = $restaurants->map(function ($restaurant) use ($latitude, $longitude) {
                if ($latitude && $longitude) {
                    $restaurant->distance = self::haversineDistance(
                        $latitude,
                        $longitude,
                        $restaurant->latitude,
                        $restaurant->longitude
                    );
                } else {
                    $restaurant->distance = null;
                }

                $googleRating = $restaurant->rating ?? 0;
                $googleReviews = $restaurant->reviews ?? 0;
                $fudzReviews = $restaurant->reviews_count;
                $fudzRating = $restaurant->reviews_avg_rating ?? 0;

                $totalReviews = $googleReviews + $fudzReviews;
                $combinedRating = $totalReviews > 0
                    ? round((($googleRating * $googleReviews) + ($fudzRating * $fudzReviews)) / $totalReviews, 2)
                    : 0;

                $restaurant->rating = $combinedRating;
                $restaurant->reviews = $totalReviews;   
                $restaurant->promotion = $restaurant->ad?->is_active ?? false;

                return $restaurant;
            });

            return (new SAWService())->calculate($processed, $weights, $criteriaTypes);
        }

    private static function haversineDistance($lat1, $lon1, $lat2, $lon2)
    {
        $earthRadius = 6371;
        $dLat = deg2rad($lat2 - $lat1);
        $dLon = deg2rad($lon2 - $lon1);

        $a = sin($dLat / 2) ** 2 +
            cos(deg2rad($lat1)) * cos(deg2rad($lat2)) *
            sin($dLon / 2) ** 2;

        return round($earthRadius * (2 * atan2(sqrt($a), sqrt(1 - $a))), 2);
    }
}
