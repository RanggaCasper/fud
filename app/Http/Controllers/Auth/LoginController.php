<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LoginController extends Controller
{
    public function index()
    {
        return view('auth.login');
    }

    public function store(Request $request)
    {
        $credentials = $request->validate([
            'username' => 'required',
            'password' => 'required|min:8',
        ]);

        try {
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                return ResponseFormatter::redirected('Login successful!', route("home"));
            }
            return ResponseFormatter::error('Credentials not match our records.', code: Response::HTTP_UNAUTHORIZED);
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);  
        }
    }
}
