<?php

use App\Http\Controllers\Api\Owner\AuthController;
use App\Http\Controllers\Api\Owner\RestaurantController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

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

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

Route::prefix('owner')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('owner.register');
    Route::post('login', [AuthController::class, 'login'])->name('owner.login');

    Route::middleware('auth:sanctum')->group(function () {
        Route::post('restaurant/add', [RestaurantController::class, 'addRestaurant'])->name('restaurant.store');
        Route::post('logout', [AuthController::class, 'logout'])->name('owner.logout');
    });
});
