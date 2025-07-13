<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use App\Helpers\Point;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class RegisterController extends Controller
{
    public function store(Request $request)
    {
        if (config('app.env') == 'production') {
            $request->validate([  
                'g-recaptcha-response' => 'required|captcha'  
            ], [  
                'g-recaptcha-response.required' => 'The reCAPTCHA field is required.',  
                'g-recaptcha-response.captcha' => 'The reCAPTCHA verification failed. Please try again.'  
            ]); 
        }
        
        $request->validate([
            'username' => 'required|string|max:255|unique:users',
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'phone' => 'nullable|string|min:10|max:13',
            'password' => 'required|string|min:8|confirmed',
            'terms' => 'accepted',
        ]);

        try {
            $data = User::create([
                'username' => $request->username,
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
                'password' => bcrypt($request->password),
                'role_id' => Role::where('name', 'user')->first()->id,
            ]);

            Auth::login($data);

            Point::give(User::find(Auth::id()), 'register');
            
            $request->session()->regenerate();
            
            return ResponseFormatter::redirected('Registration successful! You are now logged in.', route("home"));
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
