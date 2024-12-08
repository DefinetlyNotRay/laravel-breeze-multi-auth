<?php

namespace App\Providers;

use Illuminate\Support\Facades\Event;
use App\Listeners\LogLogin;
use Illuminate\Support\ServiceProvider;
use Illuminate\Auth\Events\Authenticated;

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
        // Event::listen(Authenticated::class, LogLogin::class);
    }
}