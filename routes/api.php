<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\GameController;
use App\Http\Controllers\ReviewController;

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

Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);
Route::middleware('auth:sanctum')->group(function () {
    Route::post('/logout', [AuthController::class, 'logout']);
});

Route::middleware('auth:sanctum')->group(function () {
    Route::get('/games', [GameController::class, 'index']); // List games with filters
    Route::post('/games', [GameController::class, 'store']); // Create a game
    Route::get('/games/{id}', [GameController::class, 'show']); // Get a single game
    Route::put('/games/{id}', [GameController::class, 'update']); // Update a game
    Route::delete('/games/{id}', [GameController::class, 'destroy']); // Delete a game (Admin only)
});

Route::middleware('auth:sanctum')->group(function () {
    Route::post('/games/{gameId}/reviews', [ReviewController::class, 'store']);
    Route::get('/games/{gameId}/reviews', [ReviewController::class, 'index']);
    Route::put('/games/{gameId}/reviews/{id}', [ReviewController::class, 'update']);
    Route::delete('/games/{gameId}/reviews/{id}', [ReviewController::class, 'destroy']);
});
