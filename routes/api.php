<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProductController; 
use App\Http\Controllers\CartController; 
use App\Http\Controllers\CartItemController; 
use App\Http\Controllers\OrderController; 
use App\Http\Controllers\OrderItemController; 
use App\Http\Controllers\PaymentController; 
use App\Http\Controllers\ProfileController; 
use App\Http\Controllers\ReviewController; 
use App\Http\Controllers\UserController; 
use App\Http\Controllers\CategoryController; 
use App\Http\Controllers\ProductImageController; 


Route::apiResource('products', ProductController::class);
Route::apiResource('carts', CartController::class);
Route::apiResource('cart-items', CartItemController::class);
Route::apiResource('orders', OrderController::class);
Route::apiResource('order-items', OrderItemController::class);
Route::apiResource('payments', PaymentController::class);
Route::apiResource('profiles', ProfileController::class);
Route::apiResource('reviews', ReviewController::class);
Route::apiResource('users', UserController::class);
Route::apiResource('categories', CategoryController::class);
Route::apiResource('product-images', ProductImageController::class);