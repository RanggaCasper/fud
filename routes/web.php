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

Route::get('/settings', function () {
    return view('user.settings');
})->name('settings');

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->name('list');


Route::prefix('auth')->as('auth.')->group(function () {

    Route::prefix('login')->as('login.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('store');

        Route::get('{provider}', [\App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToProvider'])->name('social');
        Route::get('{provider}/callback', [\App\Http\Controllers\Auth\SocialLoginController::class, 'handleProviderCallback']);
    });

    Route::get('disconnect/{provider}', [\App\Http\Controllers\Auth\SocialLoginController::class, 'deleteSocialAccount'])
        ->name('disconnect.social');


    Route::prefix('register')->as('register.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Auth\RegisterController::class, 'store'])->name('store');
    });
});

Route::post('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'store'])->name('logout');