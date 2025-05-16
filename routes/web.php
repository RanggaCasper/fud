<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/list', [\App\Http\Controllers\HomeController::class, 'list'])->name('list');

Route::post('/location', [\App\Http\Controllers\LocationController::class, 'store'])->name('location.store');

Route::get('/detail', function () {
    return view('detail');
});

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->name('dashboard.index');


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

Route::prefix('settings')->as('settings.')->group(function () {
    Route::get('/', [\App\Http\Controllers\SettingController::class, 'index'])->name('index');
    Route::put('/profile', [\App\Http\Controllers\SettingController::class, 'updateProfile'])->name('update.profile');
    Route::put('/password', [\App\Http\Controllers\SettingController::class, 'updatePassword'])->name('update.password');
    Route::delete('/delete/account', [\App\Http\Controllers\SettingController::class, 'deleteAccount'])->name('delete.account');
});

Route::prefix('admin')->as('admin.')->group(function () {
    Route::prefix('user')->as('user.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\User\UserController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\User\UserController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\User\UserController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\User\UserController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\User\UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\User\UserController::class, 'destroy'])->name('destroy');
    });
});

Route::post('/logout', [\App\Http\Controllers\Auth\LogoutController::class, 'store'])->name('logout');

// SerpApiService example
Route::get('/serpapi', [\App\Http\Controllers\Api\SerpApiController::class, 'search'])->name('serapi.search');