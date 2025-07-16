<?php

namespace App\Http\Controllers\Callback;

use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class TokopayCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json, true);
        
        Log::info('Tokopay Callback Data: ' . $json);

        if (isset($data['status'], $data['reff_id'], $data['signature'])) {
            $status = $data['status'];
            $ref_id = $data['reff_id'];
            $signature_from_tokopay = $data['signature'];

            $signature_validasi = md5(env('TOKOPAY_MERCHANT_ID') . ":" . env('TOKOPAY_SECRET_KEY') . ":" . $ref_id);

            if ($signature_from_tokopay !== $signature_validasi) {
                return Response::json(['error' => "Invalid Signature"]);
            }

            $transaction = Transaction::with('restaurantAd')
                ->where('transaction_id', $ref_id)
                ->first();

            if (!$transaction) {
                return Response::json(['error' => 'Transaction not found']);
            }

            if ($status === "Success") {
                $transaction->update([
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                if ($transaction->restaurantAd) {
                    if (!$transaction->restaurantAd->start_date || !$transaction->restaurantAd->end_date) {
                        $startDate = now();
                        $endDate = $startDate->copy()->addDays($transaction->restaurantAd->run_length);

                        $transaction->restaurantAd->update([
                            'is_active' => true,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                        ]);
                    }
                }
            } else {
                $transaction->update([
                    'status' => 'canceled',
                    'expired_at' => now(),
                    'paid_at' => null,
                ]);

                if ($transaction->restaurantAd) {
                    $transaction->restaurantAd->update([
                        'approval_status' => 'rejected',
                        'note' => 'Transaction canceled by system',
                    ]);
                }
            }

            return Response::json(['status' => true]);
        }

        return Response::json(['error' => "Data json tidak sesuai"]);
    }
}
