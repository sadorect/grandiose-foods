<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ComposerServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('composer', function ($app) {
            return new \Illuminate\Support\Composer($app['files'], $app->basePath());
        });
    }
}
