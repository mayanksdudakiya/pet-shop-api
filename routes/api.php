<?php

use App\Http\Controllers\V1\AuthenticationController;
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
            Route::post('login', [AuthenticationController::class, 'login'])
                ->name('login')
                ->middleware('guest');

            Route::middleware([
                VerifyJwtToken::class,
                VerifyUserType::class . ':admin'
            ])->group(function() {
                Route::post('logout', [AuthenticationController::class, 'logout'])->name('logout');
                // Rest admin related protected should goes here
            });
    });
