<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\AdsType;
use Illuminate\Support\Facades\Blade;

class AdTypeController extends Controller
{
    public function index()
    {
        return view('admin.ad_type');
    }

    public function get(): JsonResponse
    {
        try {
            $data = AdsType::get();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('action', function ($row) {  
                    return Blade::render('
                        <div class="flex gap-2">
                            <x-button type="button" data-modal-target="updateModal" data-update-id="{{ $id }}" size="sm">Update</x-button>
                        </div>
                    ', ['id' => $row->id]);
                })  
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getById($id): JsonResponse
    {
        try {
            $data = AdsType::findOrFail($id);
            return ResponseFormatter::success('Data retrived successfully.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'base_price' => 'required|numeric|min:0',
        ]);

        try {
            $data = AdsType::findOrFail($id);

            $data->update([
                'base_price' => $request->base_price,
            ]);

            return ResponseFormatter::success('Data updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
