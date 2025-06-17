<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class AuthMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return ResponseFormatter::redirected('Unauthorized', route('auth.login.index'), Response::HTTP_UNAUTHORIZED);
            }

            return redirect()->route('auth.login.index')->with('error', 'You must be logged in to access this page.');
        }

        return $next($request);
    }
}
