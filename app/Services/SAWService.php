<?php

namespace App\Services;

class SAWService
{
    public function calculate($items, array $weights, array $criteriaTypes)
    {
        $processed = [];

        foreach ($items as $item) {
            $entry = ['model' => $item];
            foreach ($weights as $key => $weight) {
                $entry[$key] = isset($item->$key) ? (float) $item->$key : 0;
            }
            $processed[] = $entry;
        }

        $normalized = [];
        foreach ($processed as $index => $data) {
            $normEntry = ['model' => $data['model']];
            foreach ($weights as $key => $weight) {
                $values = array_column($processed, $key);
                $val = $data[$key];

                if ($criteriaTypes[$key] === 'benefit') {
                    $max = max($values);
                    $normEntry[$key] = $max > 0 ? $val / $max : 0;
                } elseif ($criteriaTypes[$key] === 'cost') {
                    $min = min($values);
                    $normEntry[$key] = $val > 0 ? $min / $val : 0;
                }
            }
            $normalized[] = $normEntry;
        }

        $results = [];
        foreach ($normalized as $entry) {
            $score = 0;
            foreach ($weights as $key => $weight) {
                $score += $entry[$key] * $weight;
            }

            $model = $entry['model'];
            $model->score = round($score, 4);
            $results[] = $model;
        }

        return collect($results)->sortByDesc('score')->values();
    }
}
