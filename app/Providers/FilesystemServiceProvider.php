<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Filesystem\FilesystemManager;

class FilesystemServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton('files', function () {
            return new \Illuminate\Filesystem\Filesystem;
        });

        $this->app->singleton('filesystem', function ($app) {
            return new FilesystemManager($app);
        });
    }
}
