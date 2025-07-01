<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class GeminiService
{
    protected string $apiKey;
    protected string $model;

    public function __construct()
    {
        $this->apiKey = env('GEMINI_API_KEY');
        $this->model = 'gemini-2.0-flash';
    }

    public function generateContent(string $prompt): array
    {
        $url = "https://generativelanguage.googleapis.com/v1beta/models/{$this->model}:generateContent?key={$this->apiKey}";

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post($url, [
            'contents' => [
                [
                    'parts' => [
                        ['text' => $prompt]
                    ]
                ]
            ]
        ]);

        if ($response->successful()) {
            $rawText = $response->json('candidates.0.content.parts.0.text');

            try {
                return [
                    'success' => true,
                    'data' => json_decode($rawText, true),
                    'raw' => $rawText,
                ];
            } catch (\Exception $e) {
                return [
                    'success' => false,
                    'error' => 'Gagal mem-parsing JSON.',
                    'raw' => $rawText,
                ];
            }
        }

        return [
            'success' => false,
            'error' => $response->body(),
        ];
    }
}
