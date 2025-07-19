<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\SalesPredictionController;

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

// Sales Prediction Routes
Route::prefix('predictions')->group(function () {
    Route::get('/products/{product}', [SalesPredictionController::class, 'getPrediction']);
    Route::get('/products', [SalesPredictionController::class, 'getAllPredictions']);
}); 