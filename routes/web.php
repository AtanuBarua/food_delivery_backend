<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Web\Owner\AuthController;
use App\Http\Controllers\Api\Owner\RestaurantController;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('owner')->group(function () {
    Route::post('register', [AuthController::class, 'register'])->name('owner.register');
    Route::post('login', [AuthController::class, 'login'])->name('owner.login');

    Route::middleware('auth')->group(function () {
        Route::post('restaurant/add', [RestaurantController::class, 'addRestaurant'])->name('restaurant.store');
        Route::get('restaurants', [RestaurantController::class, 'getRestaurants'])->name('restaurant.fetch');
        Route::get('restaurant/{id}', [RestaurantController::class, 'restaurantDetails'])->name('restaurant.details');
        Route::post('logout', [AuthController::class, 'logout'])->name('owner.logout');
    });
});
