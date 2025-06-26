<?php

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;
use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/restaurants', [\App\Http\Controllers\HomeController::class, 'list'])->name('list');
Route::get('/reviews', [\App\Http\Controllers\HomeController::class, 'reviews'])->name('reviews');
Route::get('/search', [\App\Http\Controllers\HomeController::class, 'search'])->name('search');
Route::get('/fetch-image/{place_id}', [\App\Http\Controllers\HomeController::class, 'fetchImage'])->name('fetch.image');
Route::get('/fetch-reservation/{place_id}', [\App\Http\Controllers\HomeController::class, 'fetchReservation'])->name('fetch.reservation');
Route::post('/reservation', [\App\Http\Controllers\HomeController::class, 'storeReservation'])->name('reservation.store');

Route::post('/location', [\App\Http\Controllers\LocationController::class, 'store'])->name('location.store');

Route::get('/business', function () {
    return view('panel.business');
})->name('business.index');

Route::get('/dashboard', function () {
    return view('user.dashboard');
})->name('dashboard.index');

Route::get('/restaurant/{slug}', [\App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurant.index');
Route::get('/restaurant/{slug}/claim', [\App\Http\Controllers\RestaurantController::class, 'claim'])->name('restaurant.claim');
Route::post('/restaurant/{slug}/claim', [\App\Http\Controllers\RestaurantController::class, 'store'])->name('restaurant.claim.store');

Route::post('/reason/report', \App\Http\Controllers\ReasonController::class)->name('reason.report');

Route::get('/logout', \App\Http\Controllers\Auth\LogoutController::class)->name('logout');

Route::prefix('auth')->as('auth.')->group(function () {
    Route::prefix('login')->as('login.')->group(function () {
        Route::middleware('guest')->group(function () {
            Route::get('/', [\App\Http\Controllers\Auth\LoginController::class, 'index'])->middleware('guest')->name('index');
            Route::post('/', [\App\Http\Controllers\Auth\LoginController::class, 'store'])->middleware('guest')->name('store');
        });

        Route::get('{provider}', [\App\Http\Controllers\Auth\SocialLoginController::class, 'redirectToProvider'])->name('social');
        Route::get('{provider}/callback', [\App\Http\Controllers\Auth\SocialLoginController::class, 'handleProviderCallback']);
    });

    Route::get('disconnect/{provider}', [\App\Http\Controllers\Auth\SocialLoginController::class, 'deleteSocialAccount'])->name('disconnect.social');

    Route::prefix('register')->as('register.')->middleware('guest')->group(function () {
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

Route::prefix('owner')->as('owner.')->middleware('checkOwned')->group(function () {
    Route::get('/', [\App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/manage', [\App\Http\Controllers\Owner\ManageController::class, 'index'])->name('manage.index');
});

Route::prefix('user')->as('user.')->middleware('auth')->group(function () {
    Route::prefix('review')->as('review.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\ReviewController::class, 'index'])->name('index');
        Route::post('/{slug}', [\App\Http\Controllers\User\ReviewController::class, 'store'])->name('store');
    });
    Route::prefix('favorite')->as('favorite.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\FavoriteController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\User\FavoriteController::class, 'store'])->name('store');
        Route::delete('/', [\App\Http\Controllers\User\FavoriteController::class, 'destroy'])->name('destroy');
    });
});

Route::middleware([])->get('/sitemap.xml', function () {
    $sitemap = Sitemap::create()
        ->add(Url::create('/'))
        ->add(Url::create(route('reviews')))
        ->add(Url::create(route('list')));

    \App\Models\Restaurant\Restaurant::orderByDesc('updated_at')
        ->get()
        ->each(function ($restaurant) use ($sitemap) {
            $sitemap->add(
                Url::create(route('restaurant.index', ['slug' => $restaurant->slug]))
                    ->setLastModificationDate($restaurant->updated_at)
            );
        });

    return \Illuminate\Http\Response::make($sitemap->render(), 200)
        ->header('Content-Type', 'application/xml');
});
