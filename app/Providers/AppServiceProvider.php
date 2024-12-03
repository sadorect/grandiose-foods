<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
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
    public function boot()
    {
        View::composer('*', function ($view) {
            $cartCount = count(session()->get('cart', []));
            $view->with('cartCount', $cartCount);
        });
    }
}
