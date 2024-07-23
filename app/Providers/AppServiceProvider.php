<?php

namespace App\Providers;

use App\Models\User;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Session;
use Inertia\Inertia;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        Inertia::share([
            'flash' => function() {
                return [
                    'error' => Session::get('error'),
                    'message' => Session::get('message'),
                    'success' => Session::get('success'),
                ];
            }
        ]);
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        view()->composer(['front.partials._footer', 'layouts.guest'], function($view) {
            $view->with('user', User::first());
        });

        if (env('APP_ENV') === 'production') {
            URL::forceScheme('https');
        }
    }
}
