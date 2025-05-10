<?php
namespace App\Http\Controllers\Auth;

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

        $user = User::where('email', $socialUser->getEmail())->first();

        if (!$user) {
            $user = User::create([
                'email' => $socialUser->getEmail(),
                'name' => $socialUser->getName(),
                'avatar' => $socialUser->getAvatar(),
                'username' => $this->generateUsername($socialUser),
            ]);
        }

        SocialAccount::firstOrCreate(
            ['user_id' => $user->id, 'social_provider' => $provider, 'social_id' => $socialUser->getId()]
        );

        Auth::login($user);

        return redirect()->route('home');
    }

    private function generateUsername($socialUser)
    {
        $fullName = $socialUser->getName();
        $nameParts = explode(' ', $fullName);
        $username = strtolower(implode('', $nameParts));

        while (User::where('username', $username)->exists()) {
            $username = strtolower(implode('', $nameParts)) . Str::random(4);
        }

        return $username;
    }
}
