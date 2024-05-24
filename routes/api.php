<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
<<<<<<< HEAD
use App\Http\Controllers\Api\ProductController;
use App\Http\Controllers\Api\CategoryController;
use App\Http\Controllers\Api\AuthController;
=======
use App\Http\Controllers\api\ProductController;
use App\Http\Controllers\api\CategoryController;
use App\Http\Controllers\api\PromotionController;
use App\Http\Controllers\api\WishlistController;
use App\Http\Controllers\TranslationController;
use App\Http\Controllers\AuthController;

>>>>>>> 20977322278d11649a35f825d42c09af5d7d329e

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
    'middleware' => ['api','CheckPassword'],
    'prefix' => 'auth'
], function ($router) {
    Route::post('/login', [AuthController::class, 'login']);
    Route::post('/register', [AuthController::class, 'register']);
    Route::post('/logout', [AuthController::class, 'logout']);
    Route::post('/refresh', [AuthController::class, 'refresh']);
    Route::get('/user-profile', [AuthController::class, 'userProfile']);    
});

// 'CheckPassword'
Route::get('/products', [ProductController::class, 'index']);
Route::post('/products', [ProductController::class, 'store']);
Route::get('/products/{id}', [ProductController::class, 'show']);
Route::patch('/products/{id}', [ProductController::class, 'update']);
Route::delete('/products/{id}', [ProductController::class, 'destroy']);

Route::post('/products/search', [ProductController::class, 'search']);

Route::get('/category', [CategoryController::class, 'index']);
Route::post('/category', [CategoryController::class, 'store']);
Route::get('/category/{id}', [CategoryController::class, 'show']);
Route::put('/category/{id}', [CategoryController::class, 'update']);
Route::delete('/category/{id}', [CategoryController::class, 'destroy']);
<<<<<<< HEAD
=======

Route::get('/promotion',[PromotionController::class,'index']);
Route::post('/promotion',[PromotionController::class,'store']);
Route::get('/promotion/{id}', [PromotionController::class, 'show']);
Route::put('/promotion/{id}', [PromotionController::class, 'update']);
Route::delete('/promotion/{id}', [PromotionController::class, 'destroy']);

Route::post('/wishlist', [WishlistController::class, 'store']);
Route::delete('/wishlist', [WishlistController::class, 'destroy']);
Route::get('/wishlist', [WishlistController::class, 'index']);

Route::post('/translate', [TranslationController::class, 'translate']);
>>>>>>> 20977322278d11649a35f825d42c09af5d7d329e
