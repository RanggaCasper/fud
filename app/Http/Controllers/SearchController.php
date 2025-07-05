<?php

namespace App\Http\Controllers;

use App\Helpers\Rank;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function __invoke(Request $request)
    {
        $query = trim($request->input('search'));
        $regionSuggestion = collect();
        $filteredRestaurants = collect();

        if ($query !== '') {
            $queryLower = strtolower($query);

            $regionSuggestion = $this->getRegionSuggestions($queryLower);

            $rankedRestaurants = Rank::getRankedRestaurants();

            $filteredRestaurants = $rankedRestaurants->map(function ($restaurant) use ($queryLower) {
                $fields = [
                    'name' => strtolower($restaurant->name ?? ''),
                    'description' => strtolower($restaurant->description ?? ''),
                    'address' => strtolower($restaurant->address ?? '')
                ];

                $scores = collect($fields)->map(fn($value) => $this->cosineSimilarity($queryLower, $value));

                $boost = str_contains($fields['name'], $queryLower) || str_contains($queryLower, $fields['name']) ? 0.4 : 0;
                if ($boost === 0 && collect(explode(' ', $queryLower))->contains(fn($word) => str_contains($fields['name'], $word))) {
                    $boost = 0.2;
                }

                $restaurant->search_score = ($scores['name'] * 0.5 + $scores['description'] * 0.3 + $scores['address'] * 0.2) + $boost;

                return $restaurant;
            })
                ->filter(fn($r) => $r->search_score >= 0.01)
                ->sortByDesc('search_score')
                ->take(10)
                ->values();
        }

        $viewData = [
            'restaurants' => $filteredRestaurants,
            'regionSuggestion' => $regionSuggestion,
            'query' => $query,
        ];

        return $request->ajax()
            ? view('partials.search-items', $viewData)->render()
            : view('search', $viewData);
    }

    private function getRegionSuggestions(string $query): \Illuminate\Support\Collection
    {
        return \App\Models\Restaurant\Restaurant::pluck('address')
            ->flatMap(fn($address) => collect(explode(',', strtolower($address))))
            ->map(fn($part) => trim($part))
            ->filter(function ($part) {
                if (Str::contains($part, ['jl', 'no']) || preg_match('/\d/', $part)) return false;
                $words = explode(' ', $part);
                if (count($words) > 2) return false;
                foreach ($words as $word) {
                    if (strlen($word) < 4) return false;
                }
                return true;
            })
            ->filter(fn($part) => Str::contains($part, $query))
            ->countBy()
            ->filter(fn($count) => $count >= 3)
            ->keys()
            ->map(fn($region) => Str::title($region))
            ->values();
    }

    private function cosineSimilarity(string $a, string $b): float
    {
        if (strlen($a) === 0 || strlen($b) === 0) return 0.0;

        $aWords = array_count_values(str_word_count($a, 1));
        $bWords = array_count_values(str_word_count($b, 1));

        $dotProduct = 0;
        foreach ($aWords as $word => $countA) {
            if (isset($bWords[$word])) {
                $dotProduct += $countA * $bWords[$word];
            }
        }

        $magnitudeA = sqrt(array_sum(array_map(fn($x) => $x * $x, $aWords)));
        $magnitudeB = sqrt(array_sum(array_map(fn($x) => $x * $x, $bWords)));

        return $magnitudeA && $magnitudeB ? $dotProduct / ($magnitudeA * $magnitudeB) : 0.0;
    }
}
