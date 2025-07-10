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
            $data = RestaurantAd::where('restaurant_id', Auth::user()->owned->restaurant->id)
                ->with(['adsType', 'restaurant', 'transaction'])
                ->get();

            // Update expired ads
            RestaurantAd::where('restaurant_id', Auth::user()->owned->restaurant->id)
                ->whereHas('transaction', function ($query) {
                    $query->whereNotNull('expired_at')
                        ->where('expired_at', '<', Carbon::now());
                })
                ->with('transaction')
                ->get()
                ->each(function ($ad) {
                    try {
                        // Update transaction
                        if ($ad->transaction) {
                            $ad->transaction->update([
                                'status' => 'canceled',
                            ]);
                        }

                        // Update ad
                        $ad->update([
                            'approval_status' => 'rejected',
                            'note' => 'Transaction canceled by system',
                        ]);
                    } catch (\Throwable $e) {
                    }
                });

            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('transaction_id', function ($row) {
                    return Blade::render(<<<'BLADE'
                            <a href="{{ route('owner.transaction.index', ['trx_id' => $row->transaction->transaction_id]) }}" class="text-primary font-semibold hover:underline">
                                {{ $row->transaction->transaction_id }}
                            </a>
                        BLADE, [
                        'row' => $row,
                    ]);
                })
                ->addColumn('approval_status', function ($row) {
                    $status = $row->approval_status;

                    $color = match ($status) {
                        'pending' => 'warning',
                        'approved' => 'success',
                        default => 'danger',
                    };

                    return Blade::render(<<<'BLADE'
                            <x-badge :color="$color" class="capitalize">
                                {{ ucfirst($status) }}
                            </x-badge>
                        BLADE, [
                        'status' => $status,
                        'color' => $color,
                    ]);
                })
                ->addColumn('end_date', function ($row) {
                    return $row->end_date ? $row->end_date->format('Y-m-d H:i:s') : 'N/A';
                })
                ->addColumn('paid_at', function ($row) {
                    return $row->transaction->paid_at ? $row->transaction->paid_at->format('Y-m-d H:i:s') : 'N/A';
                })
                ->addColumn('created_at', function ($row) {
                    return $row->transaction->created_at ? $row->transaction->created_at->format('Y-m-d H:i:s') : 'N/A';
                })
                ->rawColumns(['transaction_id', 'approval_status'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function store(Request $request): JsonResponse
    {
        $request->validate([
            'ad_type'    => 'required|exists:ads_types,id',
            'run_length' => 'required|integer|min:1',
            'image' => Rule::filepond([
                Rule::requiredIf(function () use ($request) {
                    $adType = \App\Models\AdsType::find($request->ad_type);
                    return $adType && str_contains(strtolower($adType->type), 'carousel');
                }),
                'image',
            ]),
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
}
