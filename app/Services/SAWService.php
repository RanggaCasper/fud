<?php

namespace App\Services;

class SAWService
{
    public function calculate($restaurants, array $weights, array $criteriaTypes)
    {
        $processed = [];

        // Konversi data ke array sederhana
        foreach ($restaurants as $restaurant) {
            $processed[] = [
                'model' => $restaurant, // Simpan model asli
                'rating' => (float) $restaurant->rating,
                'reviews' => (int) $restaurant->reviews,
                'distance' => (float) $restaurant->distance,
                'is_halal' => $restaurant->is_halal ? 1 : 0,
                'is_closed' => $restaurant->is_closed ? 1 : 0,
            ];
        }

        // Normalisasi
        $normalized = [];
        foreach ($processed as $index => $data) {
            foreach ($weights as $key => $weight) {
                if ($criteriaTypes[$key] === 'benefit') {
                    $max = max(array_column($processed, $key));
                    $normalized[$index][$key] = $max > 0 ? $data[$key] / $max : 0;
                } elseif ($criteriaTypes[$key] === 'cost') {
                    $min = min(array_column($processed, $key));
                    $normalized[$index][$key] = $data[$key] > 0 ? $min / $data[$key] : 0;
                }
            }
            $normalized[$index]['model'] = $data['model'];
        }

        // Hitung skor akhir dan masukkan ke dalam model
        $results = [];
        foreach ($normalized as $data) {
            $score = 0;
            foreach ($weights as $key => $weight) {
                $score += $data[$key] * $weight;
            }

            // Tambahkan skor ke model
            $model = $data['model'];
            $model->score = round($score, 4);

            $results[] = $model;
        }

        // Urutkan dari skor tertinggi ke terendah
        $sorted = collect($results)->sortByDesc('score')->values();

        return $sorted;
    }
}
