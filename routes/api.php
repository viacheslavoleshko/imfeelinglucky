<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Middleware\EnsureTokenIsValid;
use App\Http\Controllers\Api\v1\AuthController;
use App\Http\Controllers\Api\v1\TokenController;
use App\Http\Controllers\Api\v1\ResultController;

Route::group([
    'prefix' => 'v1',
    'namespace' => 'App\Http\Controllers\Api\v1'
], function () {
    Route::group([
        'prefix' => 'auth',
    ], function () {
        Route::group(['middleware' => 'guest'], function () {
            Route::post('register', [AuthController::class, 'register'])->name('auth.register');
            Route::post('login', [AuthController::class, 'login'])->name('auth.login');
        });
    
        Route::group(['middleware' => 'auth:api'], function () {
            Route::post('logout', [AuthController::class, 'logout'])->name('auth.logout');
        });
    });

    Route::group([
        'prefix' => 'lottery',
        'middleware' => ['auth:api', EnsureTokenIsValid::class],
    ], function () {
        Route::get('{token}/ticket', [ResultController::class, 'index'])
            ->middleware(['throttle:60,1'])
            ->name('lottery.ticket');
        
        Route::get('{token}/history', [ResultController::class, 'history'])->name('lottery.history');
    });

    Route::group([
        'prefix' => 'token',
        'middleware' => ['auth:api', EnsureTokenIsValid::class],
    ], function () {
        Route::get('{token}/regenerate', [TokenController::class, 'regenerate'])->name('token.regenerate');
        Route::get('{token}/revoke', [TokenController::class, 'revoke'])->name('token.revoke');
    });
});