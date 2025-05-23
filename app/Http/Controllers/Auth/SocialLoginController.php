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
                return redirect()->route('settings.index')->with('swalError', ucfirst($provider) . ' account already connected.');
            }

            $existingAccount = SocialAccount::where('social_provider', $provider)
                                            ->where('social_id', $socialUser->getId())
                                            ->first();

            if ($existingAccount) {
                return redirect()->route('settings.index')->with('swalError', ucfirst($provider) . ' account is already linked to another user.');
            }

            SocialAccount::create([
                'user_id' => $user->id,
                'social_provider' => $provider,
                'social_id' => $socialUser->getId(),
                'avatar' => $socialUser->getAvatar(),
            ]);

            return redirect()->route('settings.index')->with('swalSuccess', ucfirst($provider) . ' account connected successfully!');
        } else {
            $socialLogin = SocialAccount::where('social_provider', $provider)
                            ->where('social_id', $socialUser->getId())
                            ->first();

            if ($socialLogin) {
                $user = User::find($socialLogin->user_id);

                Auth::login($user);

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

                return redirect()->route('home');
            }
        }

        return redirect()->route('settings.index')->with('swalError', ucfirst($provider) . ' account already connected.');
    }

    public function deleteSocialAccount($provider)
    {
        if (Auth::check()) {
            $user = Auth::user();

            $socialAccount = SocialAccount::where('user_id', $user->id)
                                        ->where('social_provider', $provider)
                                        ->first();

            if (!$socialAccount) {
                return redirect()->route('settings.index')->with('error', ucfirst($provider) . ' account is not connected.');
            }

            $socialAccount->delete();

            return redirect()->route('settings.index')->with('success', ucfirst($provider) . ' account disconnected successfully!');
        }

        return redirect()->route('auth.login.index')->with('error', 'You need to log in first.');
    }

    private function generateUsername($socialUser)
    {
        $fullName = $socialUser->getName();
        $nameParts = explode(' ', $fullName);
        $username = strtolower(implode('', $nameParts));

        while (User::where('username', $username)->exists()) {
            $username = strtolower(implode('', $nameParts)) .'-'. rand(1000, 9999);
        }

        return $username;
    }
}
