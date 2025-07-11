<?php

namespace App\Http\Controllers\Owner;

use App\Models\AdsType;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\RestaurantAd;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Validation\Rule;
use App\Services\TokopayService;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use RahulHaque\Filepond\Facades\Filepond;
use Symfony\Component\HttpFoundation\Response;

class AdController extends Controller
{
    public function index()
    {
        return view('owner.ads');
    }

    public function get(): JsonResponse
    {
        try {
            $restaurantId = Auth::user()->owned->restaurant->id;

            // Update expired ads (sama seperti sebelumnya)
            RestaurantAd::where('restaurant_id', $restaurantId)
                ->where('approval_status', 'pending')
                ->whereHas('transaction', function ($query) {
                    $query->where('status', 'pending')
                        ->where('expired_at', '<', Carbon::now());
                })
                ->with('transaction')
                ->get()
                ->each(function ($ad) {
                    if ($ad->transaction) {
                        $ad->transaction->update(['status' => 'canceled']);
                    }
                    $ad->update([
                        'approval_status' => 'rejected',
                        'note' => 'Transaction expired',
                    ]);
                });

            $ads = RestaurantAd::where('restaurant_id', $restaurantId)
                ->with(['adsType', 'restaurant', 'transaction'])
                ->latest()
                ->get();

            $html = view('partials.ads-list', compact('ads'))->render();

            return ResponseFormatter::success('Data retrieved successfully', [
                'html' => $html,
            ]);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'ad_type'    => 'required|exists:ads_types,id',
            'run_length' => 'required|integer|min:1',
            'image' => [
                Rule::requiredIf(function () use ($request) {
                    $adType = \App\Models\AdsType::find($request->ad_type);
                    return $adType && $adType->type === 'carousel';
                }),
                Rule::filepond([
                    'image',
                    'max:5000', // 5 MB
                ]),
            ],
        ]);

        try {
            $adsType = AdsType::findOrFail($request->ad_type);
            $restaurantId = Auth::user()->owned->restaurant->id;
            $runLength = (int) $request->run_length;

            $totalCost = $adsType->base_price * $runLength;

            $existingAd = RestaurantAd::where('ads_type_id', $adsType->id)
                ->where('restaurant_id', $restaurantId)
                ->where('is_active', true)
                ->where('end_date', '>=', Carbon::now())
                ->first();

            if ($existingAd) {
                return ResponseFormatter::error('You already have an active ad of this type', code: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            $pendingTransaction = Transaction::whereHas('restaurantAd', function ($q) use ($adsType, $restaurantId) {
                $q->where('ads_type_id', $adsType->id)
                    ->where('restaurant_id', $restaurantId);
            })
                ->whereNull('paid_at')
                ->where('created_at', '>=', Carbon::now()->subHour())
                ->first();

            if ($pendingTransaction) {
                return ResponseFormatter::error('You have a pending unpaid ad of this type. Please complete the payment first.', code: Response::HTTP_UNPROCESSABLE_ENTITY);
            }

            if ($request->has('image')) {
                $path = Filepond::field($request->image)->moveTo('images/ads/' . Str::uuid());
                $request->merge(['image' => $path['location']]);
            }

            $isCarousel = $adsType->type === 'carousel';
            $approvalStatus = $isCarousel ? 'pending' : 'approved';

            $ad = RestaurantAd::create([
                'ads_type_id'     => $adsType->id,
                'restaurant_id'   => $restaurantId,
                'image'           => $request->image ?? null,
                'total_cost'      => $totalCost,
                'run_length'      => $runLength,
                'approval_status' => $approvalStatus,
            ]);

            $transaction = Transaction::create([
                'restaurant_ad_id' => $ad->id,
                'transaction_id'   => 'F-' . Str::random(8),
                'price'            => $totalCost,
                'order_details'    => json_encode([
                    'item'   => $ad->adsType->name,
                    'amount' => $runLength,
                    'price'  => $totalCost,
                ]),
            ]);

            if ($approvalStatus === 'approved') {
                $tokopay = new TokopayService();

                $tokopayResponse = $tokopay->createOrder($totalCost, $transaction->transaction_id);

                $tokopayData = $tokopayResponse['data'] ?? [];

                $transaction->update([
                    'price'      => $totalCost,
                    'fee'        => $tokopayResponse['data']['total_bayar'] - $tokopayResponse['data']['total_diterima'],
                    'total'      => $tokopayResponse['data']['total_bayar'],
                    'order_details' => json_encode([
                        'item'   => $ad->adsType->name,
                        'amount' => $runLength,
                        'price'  => $totalCost,
                    ]),
                    'qr_link'    => $tokopayData['qr_link'] ?? null,
                    'reference'  => $tokopayData['trx_id'] ?? null,
                    'expired_at' => now()->addDays(1),
                ]);

                return ResponseFormatter::redirected('Ad created successfully', route('owner.transaction.index', [
                    'trx_id' => $transaction->transaction_id
                ]));
            }

            return ResponseFormatter::created('Ad created successfully, waiting for approval');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function cancel($reference)
    {
        try {
            $data = RestaurantAd::with('transaction')->find($reference);

            if (!$data) {
                return ResponseFormatter::error('Data not found.', 404);
            }

            if (!$data->transaction || $data->transaction->status !== 'pending') {
                return ResponseFormatter::error('Only pending transactions can be canceled.', 422);
            }

            $data->update([
                'approval_status' => 'rejected',
                'note' => 'Transaction canceled by owner',
            ]);

            return ResponseFormatter::success('', 'Transaction canceled successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
