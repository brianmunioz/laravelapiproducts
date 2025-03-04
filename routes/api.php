<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ImagesController;
use App\Http\Controllers\ProductController;
use App\Http\Middleware\IsAdmin;
use App\Http\Middleware\IsUserAuth;
use Illuminate\Support\Facades\Route;

//rutas publicas

Route::post('login', [AuthController::class, 'login']);

Route::middleware([IsUserAuth::class])->group(function () {
    Route::controller(AuthController::class)->group(function () {
        Route::post('logout', 'logout');
        Route::get('me', 'getUser');
    });
    Route::get('products', [ProductController::class, 'getProducts']);

    Route::middleware([IsAdmin::class])->group(function () {
        Route::controller(ProductController::class)->group(function () {
            Route::post('products', 'addProduct');
            Route::get('products/{id}', 'getProductById');
            Route::patch('products/{id}', 'updateProductById');
            Route::delete('products/{id}', 'deleteProductById');
        });
        Route::post('register', [AuthController::class, 'register']);
        Route::post('images/upload', [ImagesController::class, 'uploadImage']);
        Route::delete('images/delete', [ImagesController::class, 'deleteImages']);
    });

    Route::get('images/productid', [ImagesController::class, 'findImagesByProductId']);
});