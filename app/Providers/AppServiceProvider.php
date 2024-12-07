<?php

namespace App\Providers;

use App\Models\Cart;
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
            if (auth()->check()) {
                $cartCount = Cart::where('user_id', auth()->id())
                                ->withCount('items')
                                ->first()
                                ->items_count ?? 0;
            } else {
                $cartCount = 0;
            }
            $view->with('cartCount', $cartCount);
        });
    }
}
