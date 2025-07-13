<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

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
            'input' => 'required',
            'password' => 'required|min:8',
        ]);

        try {
            $input = $request->input('input');
            $user = null;

            if (filter_var($input, FILTER_VALIDATE_EMAIL)) {
                $user = User::where('email', $input)->first();
            } elseif (is_numeric($input)) {
                $user = User::where('phone', $input)->first();
            } else {
                $user = User::where('username', $input)->first();
            }

            if ($user && Hash::check($request->password, $user->password)) {
                Auth::login($user);
                $request->session()->regenerate();
                flash()->success('Wellcome back, <strong>' . $user->name . '</strong>! 👋');
                return ResponseFormatter::redirected('Login successful!', route("home"));
            }

            return ResponseFormatter::error('Credentials not match our records.', code: Response::HTTP_UNAUTHORIZED);
            
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);  
        }
    }
}
