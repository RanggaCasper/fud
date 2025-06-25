<?php

namespace App\Http\Controllers\Owner;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function index()
    {
        return view('owner.dashboard', 
        [
            'userCount' => \App\Models\User::count(),
            'restaurantCount' => \App\Models\Restaurant\Restaurant::count(),
        ]);
    }
}
