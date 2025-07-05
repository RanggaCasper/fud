<?php

namespace App\Http\Controllers\Admin;

use App\Helpers\Rank;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;

class SimulateController extends Controller
{
    public function __invoke(Request $request): JsonResponse
    {
            
        $request->validate([
            'lat' => 'required|numeric',
            'long' => 'required|numeric',
        ]);

        try {
            $ranked = Rank::getRankedRestaurants(
                null,
                $request->lat,
                $request->long
            );

            $data = $ranked->values()->map(function ($item, $index) {
                return [
                    'no' => $index + 1,
                    'name' => $item->name,
                    'address' => $item->address,
                    'rating' => $item->rating,
                    'reviews' => $item->reviews,
                    'distance' => $item->distance,
                    'score' => $item->score,
                ];
            });

            return DataTables::of($data)
                ->rawColumns(['action'])
                ->make(true);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

}
