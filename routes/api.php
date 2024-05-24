<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PromotionController;
use App\Http\Controllers\api\WishlistController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\api\CartController;
use App\Http\Controllers\api\CartItemController;
use App\Http\Controllers\api\OrderItemController;
use App\Http\Controllers\api\OrderController;


/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

// Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
//     return $request->user();
// });

Route::group([
    'middleware' => 'api',
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);
});



Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::patch('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category', [CategoryController::class, 'store']);
Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::put('/category/{id}', [CategoryController::class, 'update']);
Route::delete('/category/{id}', [CategoryController::class, 'destroy']);

Route::get('/promotion',[PromotionController::class,'index']);
Route::post('/promotion',[PromotionController::class,'store']);
Route::get('/promotion/{id}', [PromotionController::class, 'show']);
Route::put('/promotion/{id}', [PromotionController::class, 'update']);
Route::delete('/promotion/{id}', [PromotionController::class, 'destroy']);

Route::post('/wishlist', [WishlistController::class, 'store']);
Route::delete('/wishlist', [WishlistController::class, 'destroy']);
Route::get('/wishlist', [WishlistController::class, 'index']);

Route::post('/translate', [TranslationController::class, 'translate']);



Route::get('/order', [OrderController::class, 'index']);
Route::post('/order', [OrderController::class, 'store']);
Route::get('/order/{id}', [OrderController::class, 'show']);
Route::put('/order/{id}', [OrderController::class, 'update']);
Route::delete('/order/{id}', [OrderController::class, 'destroy']);

Route::get('/order-items', [OrderItemController::class, 'index']);
Route::post('/order-items', [OrderItemController::class, 'store']);
Route::get('/order-items/{id}', [OrderItemController::class, 'show']);
Route::put('/order-items/{id}', [OrderItemController::class, 'update']);
Route::delete('/order-items/{id}', [OrderItemController::class, 'destroy']);


Route::get('/cart', [CartController::class, 'index']);
Route::post('/cart', [CartController::class, 'store']);
Route::get('/cart/{id}', [CartController::class, 'show']);
Route::put('/cart/{id}', [CartController::class, 'update']);
Route::delete('/cart/{id}', [CartController::class, 'destroy']);

Route::get('/cart-items', [CartItemController::class, 'index']);
Route::post('/cart-items', [CartItemController::class, 'store']);
Route::get('/cart-items/{id}', [CartItemController::class, 'show']);
Route::put('/cart-items/{id}', [CartItemController::class, 'update']);

Route::delete('/cart-items/{id}', [CartItemController::class, 'destroy']);


