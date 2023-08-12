<?php

namespace App\Providers;

use App\Services\ApiResponse;
use App\Services\JwtAuth;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton('api_response', function () {
            return new ApiResponse();
        });

        $this->app->bind('jwt.auth', function () {
            return new JwtAuth();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
