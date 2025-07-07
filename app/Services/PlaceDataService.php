<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use App\Models\Restaurant\Restaurant;

class PlaceDataService
{
    protected string $baseUrl = 'http://flask.fudz.my.id';

    public function fetchImages(string $placeId): array
    {
        try {
            $restaurant = Restaurant::where('place_id', $placeId)->with('photos')->first();

            if (!$restaurant) {
                return [
                    'success' => false,
                    'message' => 'Restaurant not found.'
                ];
            }

            $hasPhotos = $restaurant->photos && $restaurant->photos->count() > 0;
            $lastUpdated = optional($restaurant->photos->sortByDesc('updated_at')->first())->updated_at;
            $shouldRefresh = !$hasPhotos || ($lastUpdated && $lastUpdated->lt(now()->startOfDay()));

            if ($shouldRefresh) {
                $response = Http::timeout(10)->get("{$this->baseUrl}/get-images", [
                    'place_id' => $placeId
                ]);

                if ($response->successful()) {
                    $data = $response->json();

                    if ($data['status']) {
                        $restaurant->rating = $data['data']['rating'] ?? $restaurant->rating;
                        $restaurant->reviews = $data['data']['review_count'] ?? $restaurant->reviews;
                        $restaurant->save();

                        $existingSources = $restaurant->photos->pluck('source')->toArray();

                        $duplicates = $restaurant->photos
                            ->groupBy('source')
                            ->filter(fn($group) => $group->count() > 1);

                        foreach ($duplicates as $group) {
                            $group->slice(1)->each->delete();
                        }

                        foreach ($data['data']['images'] ?? [] as $imgUrl) {
                            if (!in_array($imgUrl, $existingSources)) {
                                $restaurant->photos()->create([
                                    'source' => $imgUrl,
                                    'updated_at' => now(),
                                ]);
                            } else {
                                $restaurant->photos()->where('source', $imgUrl)->update([
                                    'updated_at' => now()
                                ]);
                            }
                        }

                        return [
                            'success' => true,
                            'images' => $restaurant->photos()->pluck('source')->toArray(),
                            'count' => $restaurant->photos()->count(),
                            'reservation_link' => $data['data']['reservation_link'] ?? null,
                            'rating' => $data['data']['rating'] ?? null,
                            'review_count' => $data['data']['review_count'] ?? null,
                            'duration' => $data['duration'],
                        ];
                    }

                    return [
                        'success' => false,
                        'message' => $data['message'],
                    ];
                }

                return [
                    'success' => false,
                    'message' => 'Failed to fetch from Flask API',
                    'status' => $response->status()
                ];
            } else {
                $restaurant->photos->each(function ($photo) {
                    $photo->touch();
                });

                return [
                    'success' => true,
                    'images' => $restaurant->photos->pluck('source')->toArray(),
                    'count' => $restaurant->photos->count(),
                    'reservation_link' => $restaurant->reservation_link,
                    'rating' => $restaurant->rating,
                    'review_count' => $restaurant->reviews,
                    'duration' => null,
                ];
            }
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }

    public function fetchReservationData(string $placeId): array
    {
        try {
            $restaurant = Restaurant::where('place_id', $placeId)->first();

            if (!$restaurant) {
                return [
                    'success' => false,
                    'message' => 'Restaurant not found.'
                ];
            }

            $reservationLink = $restaurant->reservation_link;

            if (empty($reservationLink)) {
                $imageResult = $this->fetchImages($placeId);

                if (!($imageResult['success'] ?? false)) {
                    return [
                        'success' => false,
                        'message' => $imageResult['message'] ?? 'Unknown error saat fetchImages'
                    ];
                }

                $reservationLink = $imageResult['reservation_link'] ?? null;

                if (empty($reservationLink)) {
                    return [
                        'success' => false,
                        'message' => 'Not found.'
                    ];
                }

                $restaurant->update(['reservation_link' => $reservationLink]);
            }

            $chopeResponse = Http::timeout(10)->get("{$this->baseUrl}/chope-reservation", [
                'url' => $reservationLink
            ]);

            if ($chopeResponse->successful()) {
                $reservationData = $chopeResponse->json();

                return [
                    'success' => true,
                    'source' => $reservationLink,
                    'data' => $reservationData['data'] ?? [],
                    'duration' => $reservationData['duration'] ?? null
                ];
            }

            return [
                'success' => false,
                'message' => 'Gagal scraping halaman reservasi Chope.',
                'error' => $chopeResponse->body(),
                'status' => $chopeResponse->status()
            ];
        } catch (\Exception $e) {
            return [
                'success' => false,
                'message' => 'Error: ' . $e->getMessage()
            ];
        }
    }
}
