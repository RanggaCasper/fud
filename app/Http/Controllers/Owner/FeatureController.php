<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class FeatureController extends Controller
{
    public function index()
    {
        return view('owner.features');
    }

    public function update(Request $request, $type)
    {
        try {
            $restaurant = Auth::user()->owned->restaurant;

            $relationMap = [
                'payments' => 'payments',
                'dining-option' => 'diningOptions',
                'accessibility' => 'accessibilities',
            ];

            $inputMap = [
                'payments' => 'payments',
                'dining-option' => 'dining_options',
                'accessibility' => 'accessibilities',
            ];

            if (!array_key_exists($type, $relationMap)) {
                return ResponseFormatter::error("Unsupported update type: $type", 400);
            }

            $relation = $relationMap[$type];
            $inputKey = $inputMap[$type];

            $items = $request->input($inputKey);

            if (!$items || !is_array($items)) {
                return ResponseFormatter::error("No $inputKey provided.", 422);
            }

            $restaurant->{$relation}()->delete();

            foreach ($items as $name) {
                $restaurant->{$relation}()->create([
                    'name' => $name
                ]);
            }

            return ResponseFormatter::success(ucwords(str_replace('-', ' ', $type)) . ' updated successfully.', $restaurant->{$relation});
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
