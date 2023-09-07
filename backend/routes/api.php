<?php

use App\Http\Controllers\CartController;
use App\Http\Controllers\ProductController;
use Illuminate\Http\Request;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;

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


Route::middleware(['api', StartSession::class])->group(function () {

    // User routes
    Route::post('/register', [UserController::class, 'register']);
    Route::post('/login', [UserController::class, 'login']);
    Route::post('/logout', [UserController::class, 'logout']);
    Route::post('/change-password', [UserController::class, 'changePassword']);
    Route::post('/get-token', [UserController::class, 'getToken']);
    Route::post('/reset-password', [UserController::class, 'resetPassword']);
    Route::post('verify-2fa-token', [UserController::class, 'verify2FAToken']);


    Route::get('/products', [ProductController::class, 'index']);

    // Cart routes
    Route::post('/add-to-cart', [CartController::class, 'addToCart']);
    Route::get('/shopping-cart',[CartController::class, 'getCartItems']);
    Route::post('/update-cart', [CartController::class, 'updateCartItems']);
});





