<?php

namespace App\Http\Controllers\Owner;

use App\Models\AdsType;
use App\Models\Transaction;
use Illuminate\Support\Str;
use App\Models\RestaurantAd;
use Illuminate\Http\Request;
use App\Services\TripayService;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Blade;
use RahulHaque\Filepond\Facades\Filepond;

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
                ->orderBy('created_at', 'desc')
                ->get();
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
        ]);

        try {
            $adsType = AdsType::findOrFail($request->ad_type);
            $restaurantId = Auth::user()->owned->restaurant->id;
            $runLength = (int) $request->run_length;

            $totalCost = $adsType->base_price * $runLength;

            $path = null;
            if ($request->has('image') && is_array($request->image)) {
                $path = Filepond::field($request->image)->moveTo('images/ads/images/' . Str::uuid());
            }

            $isCarousel = $adsType->type === 'carousel';
            $approvalStatus = $isCarousel ? 'pending' : 'approved';

            $ad = RestaurantAd::create([
                'ads_type_id'     => $adsType->id,
                'restaurant_id'   => $restaurantId,
                'image'           => $path,
                'total_cost'      => $totalCost,
                'run_length'     => $runLength,
                'approval_status' => $approvalStatus,
            ]);

            $transaction = Transaction::create([
                'restaurant_ad_id' => $ad->id,
                'transaction_id'   => 'F-' . Str::random(8),
            ]);

            $tripay = new TripayService();

            $tripayResponse = $tripay->createOrder($transaction->transaction_id, $ad->adsType->name, $totalCost);

            $transaction->update([
                'reference'   => $tripayResponse['data']['reference'],
            ]);

            return ResponseFormatter::redirected('Ad created successfully', route('owner.transaction.index', [
                'trx_id' => $transaction->transaction_id
            ]));
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
