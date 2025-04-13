<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\UserController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;



Route::prefix('user')->group(function () {
    Route::post('register', [AuthController::class, 'register']);
    Route::post('login', [AuthController::class, 'login']);

    Route::middleware('auth:sanctum')->group(function () {
        Route::get('profile', [UserController::class, 'profile']);
        Route::post('logout', [AuthController::class, 'logout']);
    });
});

Route::prefix('product')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('list', [ProductController::class, 'index']);
        Route::get('detail/{product}', [ProductController::class, 'show']);
    });
    Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
        Route::post('create', [ProductController::class, 'create']);
        Route::put('update/{product}', [ProductController::class, 'update']);
        Route::delete('delete/{product}', [ProductController::class, 'destroy']);
        Route::put('stock/{product}', [ProductController::class, 'updateStock']);
    });
});

Route::prefix('category')->middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::post('create', [CategoryController::class, 'create']);
    Route::get('list', [CategoryController::class, 'index']);
    Route::put('update/{category}', [CategoryController::class, 'update']);
    Route::delete('delete/{category}', [CategoryController::class, 'destroy']);
});

Route::prefix('order')->group(function () {
    Route::middleware(['auth:sanctum'])->group(function () {
        Route::get('list', [OrderController::class, 'index']);
        Route::get('detail/{order}', [OrderController::class, 'show']);
    });
    Route::middleware(['auth:sanctum', 'role:Admin'])->group(function () {
        Route::put('update/{order}', [OrderController::class, 'update']);
    });
    Route::middleware(['auth:sanctum', 'role:Customer'])->group(function () {
        Route::post('create', [OrderController::class, 'create']);
        Route::post('cancel/{order}', [OrderController::class, 'cancel']);
    });
});
