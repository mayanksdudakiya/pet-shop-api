<?php

namespace App\Providers;

use App\Services\ApiResponse;
use App\Services\BaseAuth;
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

        $this->app->bind('base.auth', function () {
            return new BaseAuth();
        });

        if ($this->app->isLocal()) {
            $this->app->register(\Barryvdh\LaravelIdeHelper\IdeHelperServiceProvider::class);
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
