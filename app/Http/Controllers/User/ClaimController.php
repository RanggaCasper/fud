<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClaimController extends Controller
{
    public function index()
    {
        return view('user.claim');
    }

    public function store(Request $request)
    {
        $request->validate([
            'restaurant_name' => 'required|string|max:255',
            'restaurant_address' => 'required|string|max:255',
            'restaurant_phone' => 'nullable|string|max:15',
        ]);

        // Logic to handle the claim submission
        // This could involve saving the claim to the database, notifying admins, etc.

        return redirect()->back()->with('success', 'Claim submitted successfully!');
    }
}
