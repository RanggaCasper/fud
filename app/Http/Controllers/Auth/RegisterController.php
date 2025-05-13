<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
        ]);

        try {
            $data = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'password' => bcrypt($request->password),
                'role_id' => Role::where('name', 'user')->first()->id,
            ]);

            Auth::login($data);
            $request->session()->regenerate();
            
            return ResponseFormatter::redirected('Registration successful! You are now logged in.', route("dashboard.index"));
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
