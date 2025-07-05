<?php

namespace App\Http\Controllers\Admin;

use App\Models\SAWCriteria;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

class SAWController extends Controller
{
    public function index()
    {
        return view('admin.criteria');
    }

    public function get(): JsonResponse
    {
        try {
            $data = SAWCriteria::get();
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
            $data = SAWCriteria::findOrFail($id);
            return ResponseFormatter::success('Data retrived successfully.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'weight' => 'required|numeric|min:0|max:1',
            'type' => 'required|string|in:benefit,cost',
        ]);

        try {
            $saw = SAWCriteria::findOrFail($id);

            $otherWeightsTotal = SAWCriteria::where('id', '!=', $id)->sum('weight');

            if (($otherWeightsTotal + $request->weight) > 1) {
                return ResponseFormatter::error(
                    'Total weight of all criteria must not exceed 1.',
                    code: 422
                );
            }

            $saw->update([
                'name' => $request->name,
                'weight' => $request->weight,
                'type' => $request->type,
            ]);

            return ResponseFormatter::success('SAW Criteria updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
