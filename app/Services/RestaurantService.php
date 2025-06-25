<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Models\Restaurant\Restaurant;
use Illuminate\Database\QueryException;

class RestaurantService
{
    protected $serpApiService;

    public function __construct(SerpApiService $serpApiService)
    {
        $this->serpApiService = $serpApiService;
    }

    public function fetchRestaurant($latitude, $longitude)
    {
        $results = $this->serpApiService->searchPlaces('restaurant', $latitude, $longitude, 0);

        return isset($results['local_results'])
            ? $this->processResults($results['local_results'])
            : ['total_processed' => 0, 'newly_added' => 0];
    }

    private function processResults(array $localResults)
    {
        $processed = 0;
        $newlyAdded = 0;

        foreach ($localResults as $data) {
            try {
                $restaurant = $this->createOrUpdateRestaurant($data);

                if ($restaurant->wasRecentlyCreated) {
                    $newlyAdded++;
                }

                $this->saveExtras($restaurant, $data);
                $processed++;
            } catch (QueryException $e) {
                continue;
            }
        }

        return ['total_processed' => $processed, 'newly_added' => $newlyAdded];
    }

    private function createOrUpdateRestaurant(array $data)
    {
        $placeId = $data['place_id'] ?? null;
        $baseSlug = Str::slug($data['title']);
        $slug = $this->generateUniqueSlug($baseSlug);

        return Restaurant::firstOrCreate(
            ['place_id' => $placeId],
            [
                'name' => $data['title'],
                'data_cid' => $data['data_cid'] ?? null,
                'description' => $data['description'] ?? null,
                'slug' => $slug,
                'address' => $data['address'],
                'phone' => $data['phone'] ?? null,
                'website' => $data['website'] ?? null,
                'thumbnail' => isset($data['thumbnail'])
                    ? (strstr($data['thumbnail'], '=w', true) ?: $data['thumbnail'])
                    : 'https://icon-library.com/images/no-picture-available-icon/no-picture-available-icon-1.jpg',
                'latitude' => $data['gps_coordinates']['latitude'],
                'longitude' => $data['gps_coordinates']['longitude'],
                'rating' => $data['rating'] ?? 0,
                'reviews' => $data['reviews'] ?? 0,
                'price_range' => $data['price'] ?? null,
            ]
        );
    }

    private function generateUniqueSlug($baseSlug)
    {
        $slug = $baseSlug;
        $counter = 1;

        while (Restaurant::where('slug', $slug)->exists()) {
            $slug = $baseSlug . '-' . $counter++;
        }

        return $slug;
    }

    private function saveExtras(Restaurant $restaurant, array $data)
    {
        $extensions = collect($data['extensions'] ?? []);
        $this->saveKeyedData($restaurant, $data['operating_hours'] ?? [], 'operatingHours', 'day', 'operating_hours');
        $this->saveListData($restaurant, $this->extractExtensionData($extensions, 'offerings'), 'offerings');
        $this->saveListData($restaurant, $this->extractExtensionData($extensions, 'dining_options'), 'diningOptions');
        $this->saveListData($restaurant, $this->extractExtensionData($extensions, 'payments'), 'payments');
        $this->saveListData($restaurant, $this->extractExtensionData($extensions, 'accessibility'), 'accessibilities');
    }

    private function extractExtensionData($extensions, $key)
    {
        foreach ($extensions as $extension) {
            if (isset($extension[$key])) {
                return $extension[$key]; // langsung return begitu ditemukan
            }
        }
        return [];
    }

    private function saveKeyedData(Restaurant $restaurant, array $items, $relation, $keyColumn, $valueColumn)
    {
        foreach ($items as $key => $value) {
            $restaurant->{$relation}()->firstOrCreate(
                [$keyColumn => ucfirst($key)],
                [$valueColumn => $value]
            );
        }
    }

    private function saveListData(Restaurant $restaurant, array $items, $relation)
    {
        foreach ($items as $item) {
            $restaurant->{$relation}()->firstOrCreate(['name' => $item]);
        }
    }
}
