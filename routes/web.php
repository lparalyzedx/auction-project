<?php

use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;


Route::get('/', function () {
    return view('welcome');
});



Route::get('/email/verify', function () {

    if (auth()->user()->hasVerifiedEmail()) {
        return redirect()->route('dashboard');
    }

    return view('auth.verify-email');

})->middleware('auth')->name('verification.notice');




Route::middleware(['auth'])->group(function () {

   
    Route::middleware(['verified.account'])->group(function () {

       
        Route::get('/dashboard', function () {
            return view('dashboard');
        })->name('dashboard');

        
        Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
        Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
        Route::put('/profile/email', [ProfileController::class, 'updateEmail'])->name('profile.email');
        Route::put('/profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password');

       
        Route::middleware('role:admin')
            ->prefix('admin')
            ->name('admin.')
            ->group(function () {

                Route::get('/dashboard', [DashboardController::class, 'index'])
                    ->name('dashboard');

                Route::resource('users', UserController::class)
                    ->except(['create', 'store']);

                Route::post('users/{user}/verify', [UserController::class, 'verify'])
                    ->name('users.verify');

                Route::post('users/{user}/unverify', [UserController::class, 'unverify'])
                    ->name('users.unverify');
            });
    });
});


require __DIR__ . '/auth.php';