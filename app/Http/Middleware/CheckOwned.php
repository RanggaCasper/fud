<?php

namespace App\Http\Middleware;

use App\Models\Restaurant\Claim;
use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckOwned
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            return redirect()->route('auth.login.index');
        }

        if (!Auth::user()->owned) {
            flash('You do not own any restaurant. Please claim a restaurant first.', 'error');
            return redirect()->route('home');
        }

        return $next($request);
    }
}
