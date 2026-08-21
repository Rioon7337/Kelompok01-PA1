<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Fix untuk Shared Hosting (cPanel/sejenisnya) agar public_path() selalu mengarah ke folder web root yang benar
        if (!app()->runningInConsole() && isset($_SERVER['SCRIPT_FILENAME'])) {
            $this->app->bind('path.public', function() {
                return dirname($_SERVER['SCRIPT_FILENAME']);
            });
        }
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
