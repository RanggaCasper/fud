<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Helpers\ResponseFormatter;
use Illuminate\Support\Facades\Auth;


class SettingController extends Controller
{
    protected $user;

    public function __construct()
    {
        $this->user = User::find(Auth::user()->id);
    }

    public function index()
    {
        return view('settings.index');
    }

    public function updateProfile(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|string|email|max:255|unique:users,email,' . $this->user->id,
            'phone' => 'nullable|string|max:15',
        ]);

        try {
            $this->user->update([
                'name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]);
            return ResponseFormatter::success('Profile updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error('Failed to update profile.', 500);
        }
    }

    public function updatePassword(Request $request)
    {
        $rules = [
            'password' => 'required|string|min:8|confirmed',
        ];

        if ($this->user->password) {
            $rules['current_password'] = 'required|string';
        }

        $request->validate($rules);

        if ($this->user->password && !password_verify($request->current_password, $this->user->password)) {
            return ResponseFormatter::error('Current password is incorrect.', Response::HTTP_UNAUTHORIZED);
        }

        try {
            $this->user->update([
                'password' => bcrypt($request->password),
            ]);

            return ResponseFormatter::success('Password updated successfully.');
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }

    public function deleteAccount(Request $request)
    {
        $request->validate([
            'password' => 'required|string|min:8|confirmed',
        ]);

        if (!password_verify($request->password, $this->user->password)) {
            return ResponseFormatter::error('Password is incorrect.', Response::HTTP_UNAUTHORIZED);
        }

        try {
            $this->user->delete();
            Auth::logout();

            return ResponseFormatter::redirected('Account deleted successfully.', route('auth.login.index'));
        } catch (\Exception $e) {
            return ResponseFormatter::error($e);
        }
    }
}
