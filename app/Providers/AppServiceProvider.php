<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;

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
        view()->composer(['front.partials._footer', 'layouts.guest'], function($view) {
            $view->with('user', User::first());
        });

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
