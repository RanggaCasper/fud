<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('home');
})->name('home');

Route::get('/list', function () {
    return view('list');
})->name('list');

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::prefix('auth')->group(function () {
    Route::get('login/{provider}', [\App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToProvider'])->name('social.login');
    Route::get('login/{provider}/callback', [\App\Http\Controllers\Auth\SocialLoginController::class, 'handleProviderCallback']);
});

Route::post('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'store'])->name('logout');