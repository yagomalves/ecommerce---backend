<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController, CartController, CartItemController, OrderController,
    OrderItemController, PaymentController, ProfileController, ReviewController,
    UserController, CategoryController, ProductImageController, AuthController
};


// Autenticação pública
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);


// Rotas públicas
Route::apiResource('products', ProductController::class)->only(['index', 'show']);
Route::apiResource('categories', CategoryController::class)->only(['index', 'show']);
Route::apiResource('product-images', ProductImageController::class)->only(['index', 'show']);
Route::apiResource('reviews', ReviewController::class)->only(['index', 'show']);


// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('product-images', ProductImageController::class)->except(['index', 'show']);

    Route::apiResource('carts', CartController::class);
    Route::apiResource('cart-items', CartItemController::class);
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order-items', OrderItemController::class);
    Route::apiResource('payments', PaymentController::class);

    Route::apiResource('users', UserController::class);
    Route::apiResource('profiles', ProfileController::class);
    Route::apiResource('reviews', ReviewController::class)->except(['index', 'show']);
});


