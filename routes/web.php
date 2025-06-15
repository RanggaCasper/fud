<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/list', [\App\Http\Controllers\HomeController::class, 'list'])->name('list');
Route::get('/reviews', [\App\Http\Controllers\HomeController::class, 'reviews'])->name('reviews');

Route::post('/location', [\App\Http\Controllers\LocationController::class, 'store'])->name('location.store');

Route::get('/my-favorite', function () {
    $ranked = \App\Models\Restaurant\Restaurant::all();
    return view('panel.my-favorite', compact('ranked'));
})->name('my-favorite.index');

Route::get('/business', function () {
    return view('panel.business');
})->name('business.index');

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->name('dashboard.index');

Route::get('/restaurant/{slug}', [\App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurant.index');

Route::post('/reason/report', \App\Http\Controllers\ReasonController::class)->name('reason.report');

Route::get('/logout', \App\Http\Controllers\Auth\LogoutController::class)->name('logout');
Route::prefix('auth')->as('auth.')->middleware('guest')->group(function () {
    Route::prefix('login')->as('login.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->name('store');

        Route::get('{provider}', [\App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToProvider'])->name('social');
        Route::get('{provider}/callback', [\App\Http\Controllers\Auth\SocialLoginController::class, 'handleProviderCallback']);
    });

    Route::get('disconnect/{provider}', [\App\Http\Controllers\Auth\SocialLoginController::class, 'deleteSocialAccount'])->name('disconnect.social');

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

Route::prefix('admin')->as('admin.')->middleware('checkRole:admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::prefix('user')->as('user.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\UserController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('restaurant')->as('restaurant.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RestaurantController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\RestaurantController::class, 'get'])->name('get');
        Route::post('/fetch', [\App\Http\Controllers\Admin\RestaurantController::class, 'fetch'])->name('fetch');
        Route::get('/{id}', [\App\Http\Controllers\Admin\RestaurantController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\RestaurantController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\RestaurantController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\RestaurantController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('reported-reviews')->as('reported-reviews.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReportedReviewController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\ReportedReviewController::class, 'get'])->name('get');
        Route::post('/{id}/resolve', [\App\Http\Controllers\Admin\ReportedReviewController::class, 'resolve'])->name('resolve');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\ReportedReviewController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('user')->as('user.')->group(function () {

    Route::prefix('review')->as('review.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\ReviewController::class, 'index'])->name('index');
        Route::post('/{slug}', [\App\Http\Controllers\User\ReviewController::class, 'store'])->name('store');
    });
});
// SerpApiService example
Route::get('/serpapi', [\App\Http\Controllers\Api\SerpApiController::class, 'search'])->name('serapi.search');