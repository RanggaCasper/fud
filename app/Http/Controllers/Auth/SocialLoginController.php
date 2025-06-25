<?php

namespace App\Http\Controllers\Auth;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Str;
use App\Models\SocialAccount;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class SocialLoginController extends Controller
{
    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback($provider)
    {
        $socialUser = Socialite::driver($provider)->user();

        if (Auth::check()) {
            $user = Auth::user();

            $alreadyConnected = SocialAccount::where('user_id', $user->id)
                ->where('social_provider', $provider)
                ->first();

            if ($alreadyConnected) {
                flash()->error(ucfirst($provider) . ' account already connected.');
                return redirect()->route('settings.index');
            }

            $existingAccount = SocialAccount::where('social_provider', $provider)
                ->where('social_id', $socialUser->getId())
                ->first();

            if ($existingAccount) {
                flash()->error(ucfirst($provider) . ' account is already linked to another user.');
                return redirect()->route('settings.index');
            }

            SocialAccount::create([
                'user_id' => $user->id,
                'social_provider' => $provider,
                'social_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);

            flash()->success(ucfirst($provider) . ' account connected successfully!');
            return redirect()->route('settings.index');
        } else {
            $socialLogin = SocialAccount::where('social_provider', $provider)
                ->where('social_id', $socialUser->getId())
                ->first();

            if ($socialLogin) {
                $user = User::find($socialLogin->user_id);

                Auth::login($user);
                flash()->success('Welcome back, <strong>' . $user->name . '</strong>! 👋');
                return redirect()->route('home');
            } else {
                $user = User::create([
                    'name' => $socialUser->getName(),
                    'avatar' => $socialUser->getAvatar(),
                    'username' => $this->generateUsername($socialUser),
                    'role_id' => Role::where('name', 'user')->first()->id,
                ]);

                SocialAccount::create([
                    'user_id' => $user->id,
                    'social_provider' => $provider,
                    'social_id' => $socialUser->getId(),
                    'avatar' => $socialUser->getAvatar(),
                ]);

                Auth::login($user);
                flash()->success('Account created and logged in with ' . ucfirst($provider));
                return redirect()->route('home');
            }
        }

        flash()->error(ucfirst($provider) . ' account already connected.');
        return redirect()->route('settings.index');
    }

    public function deleteSocialAccount($provider)
    {
        if (Auth::check()) {
            $user = Auth::user();

            if (!$user->password) {
                flash()->error('Set a password before disconnecting ' . ucfirst($provider) . '.');
                return redirect()->route('settings.index');
            }

            $socialAccount = SocialAccount::where('user_id', $user->id)
                ->where('social_provider', $provider)
                ->first();

            if (!$socialAccount) {
                flash()->error(ucfirst($provider) . ' is not connected.');
                return redirect()->route('settings.index');
            }

            $socialAccount->delete();

            flash()->success(ucfirst($provider) . ' disconnected.');
            return redirect()->route('settings.index');
        }

        flash()->error('Please log in first.');
        return redirect()->route('auth.login.index');
    }

    private function generateUsername($socialUser)
    {
        $fullName = $socialUser->getName();
        $nameParts = explode(' ', $fullName);
        $username = strtolower(implode('', $nameParts));

        while (User::where('username', $username)->exists()) {
            $username = strtolower(implode('', $nameParts)) . '-' . rand(1000, 9999);
        }

        return $username;
    }
}
