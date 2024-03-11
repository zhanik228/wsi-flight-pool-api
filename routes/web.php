<?php

use Illuminate\Support\Facades\Route;

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

Route::middleware('json.response')->group(function() {
    Route::middleware('auth:sanctum')->group(function() {
        Route::get('user/booking', [\App\Http\Controllers\booking\BookingController::class, 'userBookings']);
        Route::get('user', [\App\Http\Controllers\auth\AuthController::class, 'user']);
    });
});
