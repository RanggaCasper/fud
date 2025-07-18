<?php

namespace App\Http\Controllers\Owner;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\TripayService;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\RestaurantAd;

class TransactionController extends Controller
{
    public function index($trx_id)
    {
        if (Transaction::where('transaction_id', $trx_id)->doesntExist()) {
            flash()->error('Transaction not found');
            return redirect()->back();
        }

        $transaction = Transaction::with('restaurantAd')->where('transaction_id', $trx_id)->first();

        if ($transaction->restaurantAd->approval_status === 'pending') {
            flash()->warning('This transaction is still pending approval');
            return redirect()->back();
        } else if ($transaction->restaurantAd->approval_status === 'rejected') {
            flash()->error($transaction->restaurantAd->note);
            return redirect()->back();
        } else if (is_null($transaction->reference)) {
            flash()->error('This transaction is not yet processed');
            return redirect()->back();
        }

        return view('owner.transaction', compact('transaction'));
    }

    public function get($reference)
    {
        try {
            $transaction = Transaction::where('reference', $reference)->firstOrFail();
            return ResponseFormatter::success('Data retrieved successfully', $transaction);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
