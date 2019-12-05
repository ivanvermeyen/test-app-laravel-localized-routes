<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        \Route::macro('currentUrl', function ($locale = null, $parameters = null, $absolute = true) {
            return route(\Route::currentRouteName(), $parameters ?: \Route::current()->parameters(), $absolute, $locale);
        });
    }
}
