<?php

namespace App\Http\Controllers\Callback;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Symfony\Component\HttpFoundation\Response;

class TripayCallbackController extends Controller
{
    public function __invoke(Request $request)
    {
        $callbackSignature = $request->server('HTTP_X_CALLBACK_SIGNATURE');
        $json = $request->getContent();
        $signature = hash_hmac('sha256', $json, env('TRIPAY_SECRET_KEY'));

        if ($signature !== (string) $callbackSignature) {
            return ResponseFormatter::error('Invalid signature', Response::HTTP_BAD_REQUEST);
        }

        if ('payment_status' !== (string) $request->server('HTTP_X_CALLBACK_EVENT')) {
            return ResponseFormatter::error('Unrecognized callback event, no action was taken', Response::HTTP_BAD_REQUEST);
        }

        $data = json_decode($json);

        if (JSON_ERROR_NONE !== json_last_error()) {
            return ResponseFormatter::error('Invalid JSON format', Response::HTTP_BAD_REQUEST);
        }

        $invoiceId = $data->merchant_ref;
        $tripayReference = $data->reference;
        $status = strtoupper((string) $data->status);

        if ($data->is_closed_payment === 1) {
            $invoice = Transaction::with('restaurantAd')->where('transaction_id', $invoiceId)
                ->where('reference', $tripayReference)
                ->first();

            switch ($status) {
                case 'PAID':
                    $invoice->update(['paid_at' => now()]);

                    if ($invoice->restaurantAd) {
                        if (!$invoice->restaurantAd->start_date || !$invoice->restaurantAd->end_date) {
                            $startDate = now();
                            $endDate = $startDate->copy()->addDays($invoice->restaurantAd->run_length);

                            $invoice->restaurantAd->update([
                                'is_active' => true,
                                'start_date' => $startDate,
                                'end_date' => $endDate,
                            ]);
                        }
                    }
                    break;

                default:
                    return ResponseFormatter::error('Unrecognized payment status', Response::HTTP_BAD_REQUEST);
            }

            return ResponseFormatter::success('Payment status updated successfully');
        }
    }
}
