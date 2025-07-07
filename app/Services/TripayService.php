<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class TripayService {
    private $apiUrl;
    private $apiKey;
    private $secretKey;
    private $merchantCode;

    public function __construct()
    {
        $this->apiKey       = env('TRIPAY_API_KEY');
        $this->secretKey    = env('TRIPAY_SECRET_KEY');
        $this->merchantCode = env('TRIPAY_MERCHANT_CODE');

        $mode = env('TRIPAY_MODE', 'production');
        $this->apiUrl = $mode === 'development'
            ? 'https://tripay.co.id/api-sandbox'
            : 'https://tripay.co.id/api';
    }

    public function createOrder($trx_id, $name, $price)
    {
        $merchantRef = $trx_id;

        $customer = [
            'username' => "Rangga Casper",
            'phone'    => "083189944777"
        ];

        $data = [
            'method'         => 'QRIS',
            'merchant_ref'   => $merchantRef,
            'amount'         => $price,
            'customer_name'  => $customer['username'],
            'customer_email' => 'hyfanutama@gmail.com',
            'customer_phone' => $customer['phone'],
            'order_items'    => [
                [
                    'sku'      => 'Ads',
                    'name'     => $name,
                    'price'    => $price,
                    'quantity' => 1
                ]
            ],
            'return_url'   => url(),
            'expired_time' => (time() + (24 * 60 * 60)),
            'signature'    => hash_hmac('sha256', $this->merchantCode . $merchantRef . $price, $this->secretKey)
        ];

        return $this->sendRequest('/transaction/create', $data, true);
    }

    public function getTransaction($reference)
    {
        $payload = ['reference' => $reference];
        $response = $this->sendRequest('/transaction/detail', $payload);
        return $response['data'] ?? $response;
    }

    private function sendRequest($endpoint, $data = [], $isPost = false)
    {
        $url = $this->apiUrl . $endpoint;

        $headers = [
            'Authorization' => 'Bearer ' . $this->apiKey
        ];

        try {
            if ($isPost) {
                $response = Http::withHeaders($headers)
                    ->asForm()
                    ->post($url, $data);
            } else {
                $response = Http::withHeaders($headers)
                    ->get($url, $data);
            }

            return $response->json();
        } catch (\Exception $e) {
            return ['error' => true, 'message' => $e->getMessage()];
        }
    }
}
