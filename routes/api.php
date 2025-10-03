<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\{
    ProductController,
    CartController,
    CartItemController,
    OrderController,
    OrderItemController,
    PaymentController,
    ProfileController,
    ReviewController,
    UserController,
    CategoryController,
    ProductImageController,
    AuthController
};

// Autenticação pública
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

// Rotas públicas
Route::get('/products', [ProductController::class, 'index']); // ✅ ROTA EXPLÍCITA
Route::get('/products/{slug}', [ProductController::class, 'showBySlug']); // ✅ ROTA DE SLUG
Route::apiResource('categories', CategoryController::class)->only(['index']);
Route::apiResource('product-images', ProductImageController::class)->only(['index', 'show']);

// 🔥 ROTAS COM SLUG
Route::get('/categories/{category:slug}', [CategoryController::class, 'showBySlug']);
Route::get('/categories/{category:slug}/products', [ProductController::class, 'getProductsByCategory']);

// 🎯 REVIEWS
Route::get('/products/{product}/reviews', [ProductController::class, 'getProductReviews']);

// Outras rotas públicas
Route::get('/profile/current', [ProfileController::class, 'getCurrentUserProfile']);
Route::get('/profiles/user/{userId}', [ProfileController::class, 'getProfileByUserId']);

// Rotas protegidas
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);

    // 🔥 MANTÉM ROTAS ORIGINAIS COM ID PARA ADMIN
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->except(['index']);
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