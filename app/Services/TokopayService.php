<?php

namespace App\Services;

use Carbon\Carbon;
use App\Models\Provider;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\URL;

class TokopayService
{
    private string $apiUrl;
    private string $apiKey;
    private string $secretKey;

    public function __construct()
    {
        $this->apiKey    = env('TOKOPAY_MERCHANT_ID');
        $this->secretKey = env('TOKOPAY_SECRET_KEY');
        $this->apiUrl    = "https://api.tokopay.id";
    }

    public function generateSignature(string $refId): string
    {
        return md5("{$this->apiKey}:{$this->secretKey}:{$refId}");
    }

    public function getSignature(): string
    {
        return md5("{$this->apiKey}:{$this->secretKey}");
    }

    public function createOrder($nominal, $merchantRef)
    {
        $response = Http::get("{$this->apiUrl}/v1/order", [
            'merchant' => $this->apiKey,
            'secret' => $this->secretKey,
            'ref_id' => $merchantRef,
            'nominal' => $nominal,
            'metode' => "QRIS_CUSTOM"
        ]);

        return $response->json();
    }

    public function createAdvanceOrder(array $send)
    {
        $customer = [
            'username' => 'Pengguna',
            'phone' => '083189944777'
        ];

        if (Auth::check()) {
            $user = Auth::user();
            $customer = [
                'username' => $user->username,
                'phone' => $user->whatsapp
            ];
        }

        $data = [
            'merchant_id' => $this->apiKey,
            'kode_channel' => $send['kode_channel'],
            'reff_id' => $send['merchantRef'],
            'amount' => intval($send['amount']),
            'customer_name' => json_encode($customer['username']),
            'customer_email' => 'topup@casperproject.net',
            'customer_phone' => $customer['phone'],
            'redirect_url' => URL::to('/'),
            'expired_ts' => Carbon::now()->addHours(24)->timestamp,
            'signature' => $this->generateSignature($send['merchantRef']),
            'items' => [
                'product_code' => $send['sku'],
                'name' => $send['product_name'],
                'price' => intval($send['amount']),
                'product_url' => null,
                'image_url' => null,
            ]
        ];

        $response = Http::asForm()
            ->post("{$this->apiUrl}/v1/order", $data);

        return $response->json();
    }

    public function getProfile()
    {
        $data = [
            'merchant_id' => $this->apiKey,
            'signature' => $this->getSignature(),
        ];

        $response = Http::withHeaders([
            'Content-Type' => 'application/json',
        ])->post("{$this->apiUrl}/v1/merchant", $data);

        return $response->json();
    }
}
