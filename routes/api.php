<?php

use App\Http\Controllers\V1\AuthenticationController;
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
    ->group(function () {
        Route::post('login', [AuthenticationController::class, 'login'])->name('login');
    });
