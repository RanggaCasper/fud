<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class ManageController extends Controller
{
    public function index()
    {
        return view('owner.manage');
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'phone' => 'nullable|string|max:20',
            'website' => 'nullable|url|max:255',
            'description' => 'nullable|string|max:1000',
            'address' => 'nullable|string|max:255',
            'reservation_link' => [
                'nullable',
                'url',
                'max:255',
                'regex:/^https?:\/\/(www\.)?chope\.co/'
            ],
        ]);

        try {
            $restaurant = Auth::user()->owned->restaurant;

            $restaurant->update([
                'name' => $request->name,
                'phone' => $request->phone,
                'website' => $request->website,
                'description' => $request->description,
                'address' => $request->address,
                'reservation_link' => $request->reservation_link,
            ]);

            return ResponseFormatter::success('Restaurant details updated successfully.', $restaurant);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
