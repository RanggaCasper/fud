<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
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

        $keep = [
            'latitude'         => session('latitude'),
            'longitude'        => session('longitude'),
            'timezone'         => session('timezone'),
            'recently_viewed'  => session('recently_viewed'),
        ];

        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        foreach ($keep as $key => $value) {
            session([$key => $value]);
        }

        flash()->success('Goodbye, <strong>' . $name . '</strong>! 👋');

        return redirect()->route('home');
    }
}
