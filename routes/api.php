<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\ProductController;
use Illuminate\Support\Facades\Route;
use Laravel\Sanctum\Http\Middleware\CheckAbilities;
use Laravel\Sanctum\Http\Middleware\CheckForAnyAbility;

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::get('/products', [ProductController::class, 'index']);

Route::middleware(['auth:sanctum'])->group(function () {
    Route::get('/logout', [AuthController::class, 'logout']);
    Route::post('/product', [ProductController::class, 'store']);
    Route::delete('/product/{product}', [ProductController::class, 'destroy']);
    Route::patch('/product/{product}', [ProductController::class, 'update']);
    Route::get('/cart', [CartController::class, 'view']);
    Route::post('/cart/{product_id}', [CartController::class, 'addToCart']);
    Route::delete('/cart/{product_id}', [CartController::class, 'remove']);
});

