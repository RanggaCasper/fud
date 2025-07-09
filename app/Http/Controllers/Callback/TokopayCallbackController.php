<?php

namespace App\Http\Controllers\Callback;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Response;

class TokopayCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        $json = $request->getContent();
        $data = json_decode($json);
        if (isset($data['status'], $data['reff_id'], $data['signature'])) {
            $status = $data['status'];
            if ($status === "Success") {
                //hanya proses yg status transaksi sudah di bayar, sukses = dibayar
                $ref_id = $data['reff_id'];
                /*
                     * Validasi Signature
                     */
                $signature_from_tokopay = $data['signature'];
                $signature_validasi = md5(env('TOKOPAY_MERCHANT_ID') . ":" . env('TOKOPAY_SECRET_KEY') . ":" . $ref_id);
                if ($signature_from_tokopay === $signature_validasi) {
                    $transaction = Transaction::with('restaurantAd')
                        ->where('transaction_id', $ref_id)
                        ->first();

                    $transaction->update([
                        'status' => 'paid',
                        'paid_at' => now()
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
                    return Response::json(['status' => true]);
                } else {
                    return Response::json(['error' => "Invalid Signature"]);
                }
            } else {
                $ref_id = $data['reff_id'];
                /*
                     * Validasi Signature
                     */
                $signature_from_tokopay = $data['signature'];
                $signature_validasi = md5(env('TOKOPAY_MERCHANT_ID') . ":" . env('TOKOPAY_SECRET_KEY') . ":" . $ref_id);
                if ($signature_from_tokopay === $signature_validasi) {
                    // Jika status bukan sukses, update status transaksi
                    $transaction = Transaction::with('restaurantAd')
                        ->where('transaction_id', $ref_id)
                        ->first();
    
                    $transaction->update([
                        'status' => 'canceled',
                        'expired_at' => now(),
                        'paid_at' => null,
                    ]);

                    if ($transaction->restaurantAd) {
                        $transaction->restaurantAd->update([
                            'approval_status' => 'rejected',
                            'note' => 'Transaction canceled by System',
                        ]);
                    }

                    return Response::json(['status' => true]);
                } else {
                    return Response::json(['error' => "Invalid Signature"]);
                }
            }
        } else {
            return Response::json(['error' => "Data json tidak sesuai"]);
        }
    }
}
