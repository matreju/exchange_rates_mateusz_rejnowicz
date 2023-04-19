<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\CurrencyRateController;
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

Route::post('/login', [AuthController::class, 'login']);
Route::post('/register', [AuthController::class, 'register']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/currency-rates', [CurrencyRateController::class, 'store']);
    Route::get('/currency-rates', [CurrencyRateController::class, 'index']);
    Route::get('/currency-rates/{currency}/{date}', [CurrencyRateController::class, 'show']);
});