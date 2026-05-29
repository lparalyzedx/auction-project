<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\SettingsController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Front\PageController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\SellerProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Genel / Herkese Açık Rotalar
|--------------------------------------------------------------------------
*/

Route::get('/', fn () => view('welcome'))->name('index');

Route::controller(PageController::class)->group(function () {
    Route::get('/corporate', 'corporate')->name('corporate');
    Route::get('/contact', 'contact')->name('contact');
    Route::post('/contact', 'contactSend')->name('contact.send');
    Route::get('/privacy-policy', 'privacy_policy')->name('privacy');
});

Route::get('/u/{username}', [ProfileController::class, 'show'])
    ->where('username', '[a-z0-9._]+')
    ->name('profile.public');

/*
|--------------------------------------------------------------------------
| E-posta Doğrulama
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {

    Route::get('/email/verify', function () {
        return auth()->user()->hasVerifiedEmail()
            ? redirect()->route('dashboard')
            : view('auth.verify-email');
    })->name('verification.notice');

});

/*
|--------------------------------------------------------------------------
| Kimlik Doğrulanmış Rotalar
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified.account'])->group(function () {

    /*
    |----------------------------------------------------------------------
    | Dashboard
    |----------------------------------------------------------------------
    */

    Route::get('/dashboard', fn () => view('dashboard'))->name('dashboard');

    Route::get('/notifications', fn () => view('general.notifications'))->name('notifications');

    /*
    |----------------------------------------------------------------------
    | Profil — /profile
    |----------------------------------------------------------------------
    */

    Route::prefix('profile')->name('profile.')->group(function () {

        Route::get('/', [ProfileController::class, 'edit'])->name('edit');
        Route::put('/', [ProfileController::class, 'update'])->name('update');
        Route::put('email', [ProfileController::class, 'email'])->name('email');
        Route::put('password', [ProfileController::class, 'password'])->name('password');
        Route::put('privacy', [ProfileController::class, 'privacy'])->name('privacy');
        Route::put('social', [ProfileController::class, 'social'])->name('social');

    });

    /*
    |----------------------------------------------------------------------
    | Satıcı — /seller
    |----------------------------------------------------------------------
    */

    Route::prefix('seller')->middleware('role:seller')->name('seller.')->group(function () {

        // Profil yönetimi
        Route::prefix('profile')->name('profile.')->group(function () {

            Route::get('/', [SellerProfileController::class, 'edit'])->name('edit');
            Route::put('{section}', [SellerProfileController::class, 'update'])->name('update');
            Route::post('document', [SellerProfileController::class, 'uploadDocument'])->name('document.upload');

        });

    });

    /*
    |----------------------------------------------------------------------
    | Admin — /admin
    |----------------------------------------------------------------------
    */

    Route::middleware('role:admin')
        ->prefix('admin')
        ->name('admin.')
        ->group(function () {

            /*
            | Dashboard
            */
            Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard');

            /*
            | Kullanıcılar — /admin/users
            */
            Route::prefix('users')->name('users.')->group(function () {

                Route::get('/', [UserController::class, 'index'])->name('index');
                Route::get('{user}', [UserController::class, 'show'])->name('show');
                Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
                Route::put('{user}', [UserController::class, 'update'])->name('update');
                Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');

                Route::post('{user}/verify', [UserController::class, 'verify'])->name('verify');
                Route::post('{user}/unverify', [UserController::class, 'unverify'])->name('unverify');

            });

            /*
            | Kategoriler — /admin/categories
            */
            Route::prefix('categories')->name('categories.')->group(function () {

                Route::get('/', [CategoryController::class, 'index'])->name('index');
                Route::get('create', [CategoryController::class, 'create'])->name('create');
                Route::post('/', [CategoryController::class, 'store'])->name('store');
                Route::get('{category}', [CategoryController::class, 'show'])->name('show');
                Route::get('{category}/edit', [CategoryController::class, 'edit'])->name('edit');
                Route::put('{category}', [CategoryController::class, 'update'])->name('update');
                Route::delete('{category}', [CategoryController::class, 'destroy'])->name('destroy');

                Route::post('{category}/toggle', [CategoryController::class, 'toggle'])->name('toggle');
                Route::post('reorder', [CategoryController::class, 'reorder'])->name('reorder');

            });

            /*
            | Ayarlar — /admin/settings
            */
            Route::prefix('settings')->name('settings.')->group(function () {

                Route::get('/', [SettingsController::class, 'index'])->name('index');
                Route::put('/', [SettingsController::class, 'update'])->name('update');
                Route::post('test-mail', [SettingsController::class, 'testMail'])->name('test-mail');

                // Önbellek işlemleri
                Route::prefix('cache')->name('cache.')->group(function () {

                    Route::post('clear', [SettingsController::class, 'cacheClear'])->name('clear');
                    Route::post('config', [SettingsController::class, 'cacheConfig'])->name('config');
                    Route::post('route', [SettingsController::class, 'cacheRoute'])->name('route');
                    Route::post('view', [SettingsController::class, 'cacheView'])->name('view');

                });

                Route::post('storage/link', [SettingsController::class, 'storageLink'])->name('storage.link');
                Route::post('optimize', [SettingsController::class, 'optimize'])->name('optimize');

            });

        });

});

/*
|--------------------------------------------------------------------------
| Auth Rotaları (Breeze / Fortify / Jetstream)
|--------------------------------------------------------------------------
*/

require __DIR__.'/auth.php';
