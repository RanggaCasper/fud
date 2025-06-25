<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Services\RestaurantService;
use App\Http\Controllers\Controller;
use App\Models\Restaurant\Restaurant;
use Illuminate\Support\Facades\Blade;

class RestaurantController extends Controller
{
    public function index()
    {
        return view('admin.restaurants');
    }

    public function get(): JsonResponse
    {
        try {
            $data = Restaurant::get();
            return DataTables::of($data)  
                ->addColumn('no', function ($row) {  
                    static $counter = 0;  
                    return ++$counter;
                })
                ->addColumn('action', function ($row) {  
                    return Blade::render('
                        <div class="flex gap-2">
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

    public function destroy(Request $request, $id): JsonResponse
    {
        try {
            $restaurant = Restaurant::findOrFail($id);
            $restaurant->delete();

            return ResponseFormatter::success('Data deleted successfully');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function fetch(Request $request, RestaurantService $restaurantService): JsonResponse
    {
        $request->validate([
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
        ]);

        try {
            $data = $restaurantService->fetchRestaurant((float) $request->lat, (float) $request->lon);

            return ResponseFormatter::success("Successfully added {$data['newly_added']} new restaurant(s)!");
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
