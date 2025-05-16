<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseFormatter;
use Illuminate\Http\Request;

class LocationController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'latitude' => 'required|numeric',
            'longitude' => 'required|numeric',
            'timezone' => 'required|string|max:255',
        ]);

        try {
            $timezone = ucwords(str_replace('/', '/', $request->timezone));

            session(['latitude' => $request->latitude, 'longitude' => $request->longitude, 'timezone' => $timezone]);
    
            return ResponseFormatter::success('Location saved successfully', [
                'latitude' => $request->latitude,
                'longitude' => $request->longitude,
                'timezone' => $timezone,
            ]);
        } catch (\Exception $e) {
            return ResponseFormatter::error('Invalid location data', 400);
        }
    }
}
