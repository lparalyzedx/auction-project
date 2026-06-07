<?php

namespace App\Providers;

use App\Models\Auction;
use App\Policies\AuctionPolicy;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Registered;
use Illuminate\Auth\Listeners\SendEmailVerificationNotification;
use Illuminate\Support\Facades\Event;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
         require_once app_path('helpers.php');
         Gate::policy(Auction::class, AuctionPolicy::class);
         Event::listen(Registered::class, SendEmailVerificationNotification::class);
    }
}
