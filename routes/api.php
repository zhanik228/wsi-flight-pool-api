<?php

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

Route::middleware('json.response')->group(function () {
    Route::post('register', [\App\Http\Controllers\auth\AuthController::class, 'register']);
    Route::post('login', [\App\Http\Controllers\auth\AuthController::class, 'login']);


    Route::get('airport', [\App\Http\Controllers\AirportsController::class, 'list']);
    Route::get('flight', [\App\Http\Controllers\flights\FlightController::class, 'search']);
    Route::get('booking/{code}', [\App\Http\Controllers\booking\BookingController::class, 'getBooking']);
    Route::get('booking/{code}/seat', [\App\Http\Controllers\booking\BookingController::class, 'occupiedSeats']);
});
