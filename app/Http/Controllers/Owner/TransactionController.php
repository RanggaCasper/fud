<?php

namespace App\Http\Controllers\Owner;

use App\Models\Transaction;
use Illuminate\Http\Request;
use App\Services\TripayService;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class TransactionController extends Controller
{
    public function index($trx_id)
    {
        if (Transaction::where('transaction_id', $trx_id)->doesntExist()) {
            flash()->error('Transaction not found');
            return redirect()->back();
        }

        $transaction = Transaction::with('restaurantAd')->where('transaction_id', $trx_id)->first();

        if($transaction->restaurantAd->approval_status === 'pending') {
            flash()->warning('This transaction is still pending approval');
            return redirect()->back();
        } else if($transaction->restaurantAd->approval_status === 'rejected') {
            flash()->error($transaction->restaurantAd->note);
            return redirect()->back();
        }

        return view('owner.transaction', compact('transaction'));
    }

    public function get($reference)
    {
        $tripayService = new TripayService();
        $response = $tripayService->getTransaction($reference);
        return ResponseFormatter::success('Transaction details retrieved successfully', $response);
    }
}
