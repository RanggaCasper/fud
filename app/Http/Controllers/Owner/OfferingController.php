<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class OfferingController extends Controller
{
    public function index()
    {
        return view('owner.offering');
    }

    public function update(Request $request)
    {
        $request->validate([
            'offerings' => 'required|array',
            'offerings.*' => 'string|max:50'
        ]);

        try {
            $restaurant = Auth::user()->owned->restaurant;

            $restaurant->offerings()->delete();

            foreach ($request->input('offerings') as $name) {
                $restaurant->offerings()->create([
                    'name' => $name
                ]);
            }

            return ResponseFormatter::success('Offerings updated successfully.', $restaurant->offerings);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
