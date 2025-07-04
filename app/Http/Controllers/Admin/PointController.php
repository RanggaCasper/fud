<?php

namespace App\Http\Controllers\Admin;

use App\Models\PointLevel;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Blade;

class PointController extends Controller
{
    public function index()
    {
        return view('admin.point');
    }

    public function get(): JsonResponse
    {
        try {
            $data = PointLevel::get();
            return DataTables::of($data)
                ->addColumn('no', function ($row) {
                    static $counter = 0;
                    return ++$counter;
                })
                ->addColumn('action', function ($row) {  
                    return Blade::render('
                        <div class="flex gap-2">
                            <x-button type="button" data-modal-target="updateModal" data-update-id="{{ $id }}" size="sm">Update</x-button>
                            <x-button type="button" color="danger" data-delete-id="{{ $id }}" size="sm">Delete</x-button>
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
            $data = PointLevel::findOrFail($id);
            return ResponseFormatter::success('Data retrived successfully.', $data);
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'target_points' => 'required|integer',
        ]);
        
        try {
            PointLevel::create([
                'name' => $request->name,
                'target_points' => $request->target_points,
            ]);

            return ResponseFormatter::created('Point created successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function update(Request $request, $id): JsonResponse
    {
        $request->validate([
            'name' => 'sometimes|required|string|max:255',
            'target_points' => 'sometimes|required|integer',
        ]);

        try {
            PointLevel::where('id', $id)->update($request->only(['name', 'target_points']));

            return ResponseFormatter::success('Point updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function destroy($id)
    {
        try {
            $point = PointLevel::findOrFail($id);
            $point->delete();

            return ResponseFormatter::success('Data deleted successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
