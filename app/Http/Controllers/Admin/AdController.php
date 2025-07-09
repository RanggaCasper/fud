<?php

namespace App\Http\Controllers\Admin;

use App\Models\RestaurantAd;
use Illuminate\Http\Request;
use App\Services\TripayService;
use Illuminate\Validation\Rule;
use Yajra\DataTables\DataTables;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Services\TokopayService;
use Illuminate\Support\Facades\Blade;
use Symfony\Component\HttpFoundation\JsonResponse;

class AdController extends Controller
{
    public function index()
    {
        return view('admin.ads');
    }

    public function get(): JsonResponse
    {
        try {
            $data = RestaurantAd::with(['adsType', 'restaurant', 'transaction'])->orderByRaw("approval_status = 'pending' DESC")->latest()->get();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
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
                ->addColumn('action', function ($row) {
                    return Blade::render('
                    <div class="flex gap-2">
                        <x-button type="button" data-modal-target="updateModal" data-update-id="{{ $id }}" size="sm">Update</x-button>
                    </div>
                ', ['id' => $row['id']]);
                })
                ->rawColumns(['approval_status', 'action'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = RestaurantAd::with(['adsType', 'restaurant', 'transaction'])->findOrFail($id);
            return ResponseFormatter::success('Data retrived successfully.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'status' => 'required|in:pending,approved,rejected',
            'note' => 'required_if:status,rejected',
            'logo_url' => Rule::filepond([
                'nullable',
                'image',
                'max:2000'
            ]),
        ]);

        try {
            $ad = RestaurantAd::with('transaction')->findOrFail($id);
            $ad->approval_status = $request->status;

            if ($request->status === 'rejected') {
                $ad->note = $request->note;
            } elseif ($request->status === 'approved') {
                $ad->note = null;

                $tokopay = new TokopayService();

                $tokopayResponse = $tokopay->createOrder(
                    $ad->transaction->price,
                    $ad->transaction->transaction_id,
                );

                $ad->transaction->update([
                    'price'      => $ad->transaction->price,
                    'fee'        => $tokopayResponse['data']['total_bayar'] - $tokopayResponse['data']['total_diterima'],
                    'total'      => $tokopayResponse['data']['total_bayar'],
                    'qr_link'    => $tokopayResponse['data']['qr_link'] ?? null,
                    'reference'  => $tokopayResponse['data']['trx_id'],
                    'expired_at' => now()->addDays(1),
                ]);
            } else {
                $ad->note = null;
            }

            $ad->save();

            return ResponseFormatter::success('Data updated successfully.', $ad);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
