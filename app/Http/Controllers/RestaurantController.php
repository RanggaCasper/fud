<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Restaurant\Restaurant;

class RestaurantController extends Controller
{
    public function index(Request $request, $slug)
    {
        $restaurant = Restaurant::with('offerings', 'payments', 'diningOptions', 'accessibilities' ,'operatingHours', 'reviews')->where('slug', $slug)->firstOrFail();
        return view('detail', compact('restaurant'));
    }
}
