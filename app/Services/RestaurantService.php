<?php

namespace App\Services;

use Illuminate\Support\Str;
use App\Services\SerpApiService;
use App\Models\Restaurant\Restaurant;

class RestaurantService
{
    protected $serpApiService;

    public function __construct(SerpApiService $serpApiService)
    {
        $this->serpApiService = $serpApiService;
    }

    /**
     * Proses pencarian restoran dan simpan data ke database
     *
     * @param float $latitude Latitude lokasi pencarian
     * @param float $longitude Longitude lokasi pencarian
     * @return int Jumlah hasil yang diproses
     */
    public function fetchRestaurant($latitude, $longitude)
    {
        // Fetch results for the first batch
        $results = $this->serpApiService->searchPlaces('restaurant', $latitude, $longitude, 0);

        // Process and store the results
        $processedResultsCount = 0;
        if (isset($results['local_results'])) {
            $processedResultsCount = $this->processResults($results['local_results']);
        }

        return $processedResultsCount;
    }

    /**
     * Memproses hasil pencarian dan menyimpannya ke dalam database
     *
     * @param array $localResults Hasil pencarian restoran
     * @return int Jumlah restoran yang diproses
     */
    private function processResults($localResults)
    {
        $processedResultsCount = 0;

        foreach ($localResults as $restaurantData) {
            $offerings = $this->getOfferings($restaurantData);
            $operatingHours = $restaurantData['operating_hours'] ?? [];
            $thumbnailUrl = strstr($restaurantData['thumbnail'], '=w', true) ?: $restaurantData['thumbnail'];

            $restaurant = Restaurant::firstOrCreate(
                [
                    'name' => $restaurantData['title'],
                    'slug' => Str::slug($restaurantData['title']),
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
                ]
            );

            // Simpan jam operasional
            $this->saveOperatingHours($restaurant, $operatingHours);

            // Simpan penawaran (offerings)
            $this->saveOfferings($restaurant, $offerings);

            $processedResultsCount++;
        }

        return $processedResultsCount;
    }

    /**
     * Mengambil penawaran dari data restoran
     *
     * @param array $restaurantData Data restoran
     * @return array Daftar penawaran
     */
    private function getOfferings($restaurantData)
    {
        // Extract offerings dari extensions jika tersedia
        foreach ($restaurantData['extensions'] ?? [] as $extension) {
            if (isset($extension['offerings'])) {
                return $extension['offerings'];
            }
        }

        return [];
    }

    /**
     * Menyimpan jam operasional restoran
     *
     * @param Restaurant $restaurant Objek restoran
     * @param array $operatingHours Jam operasional restoran
     */
    private function saveOperatingHours(Restaurant $restaurant, $operatingHours)
    {
        foreach ($operatingHours as $day => $hours) {
            $restaurant->operatingHours()->firstOrCreate(
                ['day' => ucfirst($day)],
                ['operating_hours' => $hours]
            );
        }
    }

    /**
     * Menyimpan penawaran restoran ke dalam tabel pivot
     *
     * @param Restaurant $restaurant Objek restoran
     * @param array $offerings Penawaran restoran
     */
    private function saveOfferings(Restaurant $restaurant, $offerings)
    {
        foreach ($offerings as $offering) {
            $restaurant->offerings()->firstOrCreate(['name' => $offering]);
        }
    }
}
