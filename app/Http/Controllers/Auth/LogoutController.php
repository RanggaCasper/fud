<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class LogoutController extends Controller
{
    /**
     * Handle the logout request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $request)
    {
        $name = Auth::user()?->name;

        $location = [
            'latitude' => session('latitude'),
            'longitude' => session('longitude'),
            'timezone' => session('timezone'),
        ];

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        session($location);

        flash()->success('Goodbye, <strong>' . $name . '</strong>! 👋');
        return redirect()->route('home');
    }
}
