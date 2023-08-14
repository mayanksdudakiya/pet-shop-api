<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\V1\AdminAuthController;
use App\Http\Controllers\V1\UserAuthController;
use App\Http\Middleware\VerifyJwtToken;
use App\Http\Middleware\VerifyUserType;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::name('api.admin.')
    ->prefix('v1/admin')
    ->middleware(['throttle:10,1'])
    ->group(function () {
        Route::post('login', [AdminAuthController::class, 'login'])
            ->name('login')
            ->middleware('guest');

        Route::middleware([
            VerifyJwtToken::class,
            VerifyUserType::class . ':admin',
        ])->group(function () {
            Route::post('logout', [AdminAuthController::class, 'logout'])
                ->name('logout');
            // Rest admin related protected routes should goes here
        });
    });

Route::name('api.user.')
    ->prefix('v1/user')
    ->middleware(['throttle:10,1'])
    ->group(function () {
        Route::post('login', [UserAuthController::class, 'login'])
            ->name('login')
            ->middleware('guest');

        Route::middleware([
            VerifyJwtToken::class,
            VerifyUserType::class . ':user',
        ])->group(function () {
            Route::post('logout', [UserAuthController::class, 'logout'])
                ->name('logout');
            // Rest admin related protected routes should goes here
        });
    });

Route::name('api.')
    ->prefix('v1')
    ->middleware(['throttle:10,1'])
    ->group(function () {
        Route::get('products', [ProductController::class, 'index'])
            ->name('products');
    });
