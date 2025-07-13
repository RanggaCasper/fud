<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Mail\TokenEmail;
use App\Models\EmailToken;
use Illuminate\Http\Request;
use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Cache;
use Symfony\Component\HttpFoundation\Response;

class ForgotController extends Controller
{
    public function store(Request $request): JsonResponse
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
            'token' => 'required',
            'password' => 'required|min:8',
        ]);

        try {
            $emailToken = EmailToken::where('token', $request->token)
                                    ->where('type', 'reset')
                                    ->where('expired_at', '>', now())
                                    ->first();

            if (!$emailToken) {
                return ResponseFormatter::error(
                    'Token not valid or has expired.',
                    code: Response::HTTP_UNAUTHORIZED
                );
            }

            $user = User::where('email', $emailToken->email)->first();
            if (!$user) {
                return ResponseFormatter::error(
                    'User not found.',
                    code: Response::HTTP_NOT_FOUND
                );
            }

            $user->password = bcrypt($request->password);
            $user->save();

            $emailToken->delete();

            Auth::login($user);

            return ResponseFormatter::redirected(
                'Successfully reset password.', route('home')
            );
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }

    public function getToken(Request $request): JsonResponse
    {
        $request->validate([
            'email' => 'required|email|exists:users,email',
        ]);

        $cacheKey = 'email_token_delay_' . $request->email;
        if (Cache::has($cacheKey)) {
            $secondsRemaining = Cache::get($cacheKey) - now()->timestamp;

            return ResponseFormatter::error(
                'You can only request a token once every 60 seconds. Please wait ' . $secondsRemaining . ' seconds before trying again.',
                code: Response::HTTP_TOO_MANY_REQUESTS
            );
        }

        try {
            $data = EmailToken::updateOrCreate(
                ['email' => $request->email],
                [
                    'token' => (new EmailToken())->generateToken(),
                    'type' => 'reset',
                    'expired_at' => now()->addMinutes(180),
                ]
            );

            Mail::to($request->email)->send(new TokenEmail($data));

            Cache::put($cacheKey, now()->addSeconds(60)->timestamp, 60);

            return ResponseFormatter::created('Token has been sent to your email.');
        } catch (\Exception $e) {
            return ResponseFormatter::handleError($e);
        }
    }
}
