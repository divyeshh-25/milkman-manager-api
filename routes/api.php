<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\API\AuthController;
use App\Http\Controllers\API\MilkTypeController;
use App\Http\Controllers\API\CustomerController;

Route::prefix('auth')->group(function () {
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/login', [AuthController::class, 'login'])->name('login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('/logout', [AuthController::class, 'logout']);
        Route::get('/me', [AuthController::class, 'me']);
    });
});


Route::prefix('v1')->middleware('auth:sanctum')->group(function(){
    Route::apiResource('milk-type',MilkTypeController::class);
    Route::apiResource('customer',CustomerController::class)->parameters(['customer'=>'user']);
});
