<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use InvalidArgumentException;

class SerpApiService
{
    protected $apiUrl = 'https://serpapi.com/search';

    public function searchPlaces($query, $latitude, $longitude, $start = 0)
    {
        if (empty($query) || empty($latitude) || empty($longitude)) {
            throw new InvalidArgumentException('Query, latitude, and longitude are required.');
        }

        $response = Http::get($this->apiUrl, [
            'engine' => 'google_maps',
            'q' => $query,
            'll' => "@$latitude,$longitude,20"."z",
            'api_key' => config('serpapi.api_key'),
            'start' => $start,
        ]);

        if ($response->failed()) {
            throw new \Exception('API request failed: ' . $response->body());
        }

        return $response->json();
    }
}
