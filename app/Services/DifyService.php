<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DifyService
{
    protected string $apiKey;
    protected string $baseUrl;

    public function __construct()
    {
        $this->apiKey  = env('DIFY_API_KEY');
        $this->baseUrl = 'https://api.dify.ai/v1';
    }

    public function send(string $query, string $userId = 'guest', array $files = [], string $conversationId = ''): array
    {
        $payload = [
            'inputs'          => new \stdClass(),
            'query'           => $query,
            'response_mode'   => 'blocking',
            'conversation_id' => $conversationId,
            'user'            => $userId,
        ];

        if (!empty($files)) {
            $payload['files'] = $files;
        }

        $response = Http::withHeaders([
            'Authorization' => 'Bearer ' . $this->apiKey,
            'Content-Type'  => 'application/json',
        ])->post("{$this->baseUrl}/chat-messages", $payload);

        return [
            'status' => $response->status(),
            'data'   => $response->json()
        ];
    }
}
