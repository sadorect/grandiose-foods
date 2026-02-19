<?php

namespace App\Providers;

use App\Models\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Schema;
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
    public function boot(): void
    {
        $this->warnIfCriticalTablesMissing();

        View::composer('*', function ($view) {
            if (Auth::check()) {
                $cartCount = Cart::where('user_id', Auth::id())
                                ->withCount('items')
                                ->first()
                                ->items_count ?? 0;
            } else {
                $cartCount = 0;
            }
            $view->with('cartCount', $cartCount);
        });
    }

    private function warnIfCriticalTablesMissing(): void
    {
        if (app()->runningUnitTests()) {
            return;
        }

        $shouldLog = true;

        try {
            $shouldLog = Cache::add('health:missing_critical_tables_logged', true, now()->addMinutes(30));
        } catch (\Throwable) {
            $shouldLog = true;
        }

        if (! $shouldLog) {
            return;
        }

        try {
            $criticalTables = config('health.critical_tables', [
                'users',
                'products',
                'categories',
                'orders',
                'hero_slides',
            ]);
            $missingTables = [];

            foreach ($criticalTables as $table) {
                if (! Schema::hasTable($table)) {
                    $missingTables[] = $table;
                }
            }

            if ($missingTables !== []) {
                Log::warning('Startup health check: critical tables are missing.', [
                    'missing_tables' => $missingTables,
                    'connection' => config('database.default'),
                ]);
            }
        } catch (\Throwable $exception) {
            Log::warning('Startup health check failed while checking critical tables.', [
                'message' => $exception->getMessage(),
            ]);
        }
    }
}
