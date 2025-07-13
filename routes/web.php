<?php

use Illuminate\Support\Facades\Route;

Route::get('/', [\App\Http\Controllers\HomeController::class, 'index'])->name('home');
Route::get('/restaurants', [\App\Http\Controllers\HomeController::class, 'list'])->name('list');
Route::get('/restaurants/{region?}', [\App\Http\Controllers\HomeController::class, 'list'])->name('list');

Route::get('/search', \App\Http\Controllers\SearchController::class)->name('search');
Route::get('/reviews', \App\Http\Controllers\ReviewController::class)->name('reviews');

Route::prefix('reservation')->as('reservation.')->controller(\App\Http\Controllers\ReservationController::class)->group(function () {
    Route::get('/image/{place_id}', 'getImage')->name('image');
    Route::get('/{place_id}', 'getReservation')->name('fetch');
    Route::post('/', 'store')->name('store');
});

Route::get('page/{slug}', [\App\Http\Controllers\PageController::class, 'index'])->name('page.index');

Route::post('/location', [\App\Http\Controllers\LocationController::class, 'store'])->name('location.store');

Route::get('/restaurant/{slug}', [\App\Http\Controllers\RestaurantController::class, 'index'])->name('restaurant.index');
Route::get('/restaurant/{slug}/claim', [\App\Http\Controllers\RestaurantController::class, 'claim'])->middleware('auth')->name('restaurant.claim');
Route::post('/restaurant/{slug}/claim', [\App\Http\Controllers\RestaurantController::class, 'store'])->middleware('auth')->name('restaurant.claim.store');

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

    Route::prefix('forgot')->as('forgot.')->middleware('guest')->group(function () {
        Route::post('/get-token', [\App\Http\Controllers\Auth\ForgotController::class, 'getToken'])->name('getToken');
        Route::post('/reset-password', [\App\Http\Controllers\Auth\ForgotController::class, 'store'])->name('store');
    });
});

Route::prefix('settings')->as('settings.')->middleware('auth')->group(function () {
    Route::get('/', [\App\Http\Controllers\SettingController::class, 'index'])->name('index');
    Route::put('/profile', [\App\Http\Controllers\SettingController::class, 'updateProfile'])->name('update.profile');
    Route::put('/password', [\App\Http\Controllers\SettingController::class, 'updatePassword'])->name('update.password');
    Route::delete('/delete/account', [\App\Http\Controllers\SettingController::class, 'deleteAccount'])->name('delete.account');
});

Route::prefix('admin')->as('admin.')->middleware('checkRole:admin')->group(function () {
    Route::get('/', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])->name('dashboard.index');
    Route::get('/gsc', [\App\Http\Controllers\Admin\DashboardController::class, 'gscData'])->name('dashboard.gsc');

    Route::prefix('users')->as('user.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\UserController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\UserController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\UserController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\UserController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('restaurants')->as('restaurant.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\RestaurantController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\RestaurantController::class, 'get'])->name('get');
        Route::post('/fetch', [\App\Http\Controllers\Admin\RestaurantController::class, 'fetch'])->name('fetch');
        Route::get('/{id}', [\App\Http\Controllers\Admin\RestaurantController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\RestaurantController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\RestaurantController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\RestaurantController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('owners')->as('owner.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\OwnerController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\OwnerController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\OwnerController::class, 'getById'])->name('getById');
        Route::put('/{id}', [\App\Http\Controllers\Admin\OwnerController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\OwnerController::class, 'destroy'])->name('destroy');
    });
    
    Route::prefix('reported-reviews')->as('reported-reviews.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\ReportedReviewController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\ReportedReviewController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\ReportedReviewController::class, 'getById'])->name('getById');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\ReportedReviewController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('points')->as('point.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PointController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\PointController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\PointController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\PointController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\PointController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\PointController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('pages')->as('page.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\PageController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\PageController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\PageController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\PageController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\PageController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\PageController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('criteria')->as('criteria.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Admin\SAWController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\SAWController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\SAWController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\SAWController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\SAWController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\SAWController::class, 'destroy'])->name('destroy');

        Route::get('/simulate/get', \App\Http\Controllers\Admin\SimulateController::class)->name('simulate.get');
    });

    Route::prefix('ads')->as('ad.')->group(function () {
        Route::prefix('types')->as('type.')->group(function () {
            Route::get('/', [\App\Http\Controllers\Admin\AdTypeController::class, 'index'])->name('index');
            Route::get('/get', [\App\Http\Controllers\Admin\AdTypeController::class, 'get'])->name('get');
            Route::get('/{id}', [\App\Http\Controllers\Admin\AdTypeController::class, 'getById'])->name('getById');
            Route::post('/', [\App\Http\Controllers\Admin\AdTypeController::class, 'store'])->name('store');
            Route::put('/{id}', [\App\Http\Controllers\Admin\AdTypeController::class, 'update'])->name('update');
            Route::delete('/{id}', [\App\Http\Controllers\Admin\AdTypeController::class, 'destroy'])->name('destroy');
        });

        Route::get('/', [\App\Http\Controllers\Admin\AdController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\Admin\AdController::class, 'get'])->name('get');
        Route::get('/{id}', [\App\Http\Controllers\Admin\AdController::class, 'getById'])->name('getById');
        Route::post('/', [\App\Http\Controllers\Admin\AdController::class, 'store'])->name('store');
        Route::put('/{id}', [\App\Http\Controllers\Admin\AdController::class, 'update'])->name('update');
        Route::delete('/{id}', [\App\Http\Controllers\Admin\AdController::class, 'destroy'])->name('destroy');
    });
});

Route::prefix('owner')->as('owner.')->middleware('checkOwned')->group(function () {
    Route::get('/', [\App\Http\Controllers\Owner\DashboardController::class, 'index'])->name('dashboard.index');

    Route::controller(\App\Http\Controllers\Owner\SeoController::class)->group(function () {
        Route::get('/seo', 'index')->name('seo.index');
        Route::put('/seo', 'update')->name('seo.update');
        Route::post('/seo/generate', 'generate')->name('seo.generate');
    });

    Route::controller(\App\Http\Controllers\Owner\ManageController::class)->group(function () {
        Route::get('/manage', 'index')->name('manage.index');
        Route::put('/manage', 'update')->name('manage.update');
    });

    Route::controller(\App\Http\Controllers\Owner\OperatingHoursController::class)->group(function () {
        Route::get('/operating-hours', 'index')->name('operatingHours.index');
        Route::put('/operating-hours', 'update')->name('operatingHours.update');
    });

    Route::controller(\App\Http\Controllers\Owner\OfferingController::class)->group(function () {
        Route::get('/offering', 'index')->name('offering.index');
        Route::put('/offering', 'update')->name('offering.update');
    });

    Route::controller(\App\Http\Controllers\Owner\FeatureController::class)->group(function () {
        Route::get('/features', 'index')->name('features.index');
        Route::put('/features/{type}', 'update')->name('features.update');
    });

    Route::controller(\App\Http\Controllers\Owner\AdController::class)->group(function () {
        Route::get('/ads', 'index')->name('ads.index');
        Route::get('/ads/chart/{id}', 'chart')->name('ads.chart');
        Route::get('/ads/get', 'get')->name('ads.get');
        Route::post('/ads', 'store')->name('ads.store');
        Route::post('/cancel/{reference}', 'cancel')->name('ads.cancel');
    });

    Route::prefix('transaction')->as('transaction.')->group(function () {
        Route::get('/{trx_id}', [\App\Http\Controllers\Owner\TransactionController::class, 'index'])->name('index');
        Route::get('/get/{reference}', [\App\Http\Controllers\Owner\TransactionController::class, 'get'])->name('get');
    });
});

Route::prefix('user')->as('user.')->middleware('auth')->group(function () {
    Route::prefix('review')->as('review.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\ReviewController::class, 'index'])->name('index');
        Route::get('get/{id}', [\App\Http\Controllers\User\ReviewController::class, 'getById'])->name('getById');
        Route::post('reporting', [\App\Http\Controllers\User\ReviewController::class, 'report'])->name('report');
        Route::delete('delete/{id}', [\App\Http\Controllers\User\ReviewController::class, 'destroy'])->name('destroy');
        Route::patch('update/{id}', [\App\Http\Controllers\User\ReviewController::class, 'update'])->name('update');
        Route::put('like/{id}', [\App\Http\Controllers\User\ReviewController::class, 'like'])->name('like');
        Route::post('{slug}', [\App\Http\Controllers\User\ReviewController::class, 'store'])->name('store');
    });

    Route::prefix('favorite')->as('favorite.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\FavoriteController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\User\FavoriteController::class, 'store'])->name('store');
        Route::delete('/', [\App\Http\Controllers\User\FavoriteController::class, 'destroy'])->name('destroy');
    });

    Route::prefix('point')->as('point.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\PointController::class, 'index'])->name('index');
        Route::get('/get', [\App\Http\Controllers\User\PointController::class, 'get'])->name('get');
    });

    Route::prefix('claim')->as('claim.')->group(function () {
        Route::get('/', [\App\Http\Controllers\User\ClaimController::class, 'index'])->name('index');
        Route::post('/', [\App\Http\Controllers\User\ClaimController::class, 'store'])->name('store');
    });
});

Route::post('/chatbot', [\App\Http\Controllers\ChatbotController::class, 'store'])->name('chatbot.store');
Route::post('/chatbot/history', [\App\Http\Controllers\ChatbotController::class, 'history'])->name('chatbot.history');

Route::get('/sitemap.xml', function () {
    return response(
        \Spatie\Sitemap\SitemapIndex::create()
            ->add(url('/sitemap-pages.xml'))
            ->add(url('/sitemap-restaurants.xml'))
            ->add(url('/sitemap-regions.xml'))
            ->render(),
        200
    )->header('Content-Type', 'application/xml');
});

Route::get('/sitemap-restaurants.xml', function () {
    $today = \Carbon\Carbon::now();

    $sitemap = \Spatie\Sitemap\Sitemap::create();

    \App\Models\Restaurant\Restaurant::orderByDesc('created_at')->get()
        ->each(function ($restaurant) use ($sitemap, $today) {
            $sitemap->add(
                \Spatie\Sitemap\Tags\Url::create(route('restaurant.index', ['slug' => $restaurant->slug]))
                    ->setLastModificationDate($today)
                    ->setPriority(0.8)
                    ->setChangeFrequency('monthly')
            );
        });

    return response($sitemap->render(), 200)
        ->header('Content-Type', 'application/xml');
});

Route::get('/sitemap-regions.xml', function () {
    $today = now();
    $sitemap = \Spatie\Sitemap\Sitemap::create();

    $regions = \App\Models\Restaurant\Restaurant::pluck('address')
        ->flatMap(function ($address) {
            return collect(explode(',', strtolower($address)));
        })
        ->map(fn($part) => trim($part))
        ->filter(function ($part) {
            if (\Illuminate\Support\Str::contains($part, ['jl', 'no']) || preg_match('/\d/', $part)) return false;

            $words = explode(' ', $part);
            if (count($words) > 2) return false;

            foreach ($words as $word) {
                if (strlen($word) < 4) return false;
            }

            return true;
        })
        ->countBy()
        ->filter(fn($count) => $count >= 3)
        ->keys()
        ->map(fn($region) => \Illuminate\Support\Str::title($region))
        ->unique();

    foreach ($regions as $region) {
        $slug = \Illuminate\Support\Str::slug($region);

        $sitemap->add(
            \Spatie\Sitemap\Tags\Url::create(route('list', ['region' => $slug]))
                ->setLastModificationDate($today)
                ->setChangeFrequency('weekly')
                ->setPriority(0.6)
        );
    }

    return response($sitemap->render(), 200)
        ->header('Content-Type', 'application/xml');
});

Route::get('/sitemap-pages.xml', function () {
    $today = \Carbon\Carbon::now();

    $sitemap = \Spatie\Sitemap\Sitemap::create()
        ->add(
            \Spatie\Sitemap\Tags\Url::create('/')
                ->setLastModificationDate($today)
                ->setPriority(1.0)
                ->setChangeFrequency('daily')
        )
        ->add(
            \Spatie\Sitemap\Tags\Url::create(route('reviews'))
                ->setLastModificationDate($today)
                ->setPriority(0.8)
                ->setChangeFrequency('daily')
        )
        ->add(
            \Spatie\Sitemap\Tags\Url::create(route('list'))
                ->setLastModificationDate($today)
                ->setPriority(0.8)
                ->setChangeFrequency('daily')
        );

    return response($sitemap->render(), 200)
        ->header('Content-Type', 'application/xml');
});

Route::post('/deploy', function (\Illuminate\Http\Request $request) {
    $signature = $request->header('X-Hub-Signature-256');
    $secret = env('GITHUB_WEBHOOK_SECRET');

    $expectedHash = 'sha256=' . hash_hmac('sha256', $request->getContent(), $secret);

    if (!hash_equals($expectedHash, $signature)) {
        abort(\Symfony\Component\HttpFoundation\Response::HTTP_UNAUTHORIZED, 'Unauthorized');
    }

    $commands = [
        'echo $PWD',
        'whoami',
        'git reset --hard HEAD',
        'git pull origin main',
        'git status',
        'composer install --no-dev',
        'php artisan migrate --force',
        'php artisan config:cache',
        'npm ci',
        'npm run build',
    ];

    $results = [];

    foreach ($commands as $command) {
        $results[] = [
            'command' => $command,
            'output' => trim(shell_exec($command)),
        ];
    }

    return response()->json([
        'status' => 'success',
        'commands' => $results,
    ]);
})->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/tripay/callback', \App\Http\Controllers\Callback\TripayCallbackController::class)
    ->name('tripay.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);

Route::post('/tokopay/callback', \App\Http\Controllers\Callback\TokopayCallbackController::class)
    ->name('tokopay.callback')
    ->withoutMiddleware([\Illuminate\Foundation\Http\Middleware\VerifyCsrfToken::class]);
