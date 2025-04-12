<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CategoryController;
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
        Route::prefix('product')->group(function () {
            Route::get('list', [ProductController::class, 'index']);
        });
    });
});

Route::prefix('product')->middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::post('create', [ProductController::class, 'create']);
});

Route::prefix('category')->middleware(['auth:sanctum', 'role:Admin'])->group(function () {
    Route::post('create', [CategoryController::class, 'create']);
    Route::get('list', [CategoryController::class, 'index']);
    Route::put('update/{category}', [CategoryController::class, 'update']);
    Route::delete('delete/{category}', [CategoryController::class, 'destroy']);
});
