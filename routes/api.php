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

// =============================================
// ROTAS PÚBLICAS
// =============================================

// Categorias
Route::get('/categories', [CategoryController::class, 'index']);
Route::get('/categories/{category}', [CategoryController::class, 'show']); // ÚNICA ROTA - aceita ID ou slug
Route::get('/categories/{id}/products', [CategoryController::class, 'getCategoryProducts']); // ÚNICA ROTA

// Produtos
Route::get('/products', [ProductController::class, 'index']);
Route::get('/products/{slug}', [ProductController::class, 'showBySlug']);

// Imagens
Route::get('/product-images', [ProductImageController::class, 'index']);
Route::get('/product-images/{productImage}', [ProductImageController::class, 'show']);

// Reviews
Route::get('/products/{product}/reviews', [ProductController::class, 'getProductReviews']);

// Perfis
Route::get('/profile/current', [ProfileController::class, 'getCurrentUserProfile']);
Route::get('/profiles/user/{userId}', [ProfileController::class, 'getProfileByUserId']);

// =============================================
// ROTAS PROTEGIDAS
// =============================================
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
    
    Route::apiResource('products', ProductController::class)->except(['index', 'show']);
    Route::apiResource('categories', CategoryController::class)->except(['index', 'show']);
    Route::apiResource('product-images', ProductImageController::class)->except(['index', 'show']);
    Route::post('/products/{product}/images', [ProductImageController::class, 'storeImages']);
    Route::apiResource('reviews', ReviewController::class)->except(['index', 'show']);

    Route::apiResource('cart', CartController::class);
    Route::apiResource('cart-items', CartItemController::class);
    
    Route::apiResource('orders', OrderController::class);
    Route::apiResource('order-items', OrderItemController::class);
    Route::apiResource('payments', PaymentController::class);
    Route::apiResource('users', UserController::class);
    Route::apiResource('profiles', ProfileController::class);
});