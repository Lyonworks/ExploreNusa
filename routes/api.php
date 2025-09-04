<?php
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\DestinationController;
use App\Http\Controllers\Api\ReviewController;
use App\Http\Controllers\Admin\DestinationController as AdminDestinationController;
use App\Http\Controllers\Admin\FacilityController as AdminFacilityController;

// ==== Auth (Admin & User) ====
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function(){
    Route::post('/logout', [AuthController::class, 'logout']);

    // ==== Admin area (token + role:admin) ====
    Route::middleware('role:admin')->prefix('admin')->group(function(){
        // Destinations
        Route::get('/destinations', [AdminDestinationController::class, 'index']);
        Route::post('/destinations', [AdminDestinationController::class, 'store']);
        Route::post('/destinations/{id}', [AdminDestinationController::class, 'update']);
        Route::get('/destinations/delete/{id}', [AdminDestinationController::class, 'destroy']); // per spec
        Route::delete('/destinations/{id}', [AdminDestinationController::class, 'destroy']);     // RESTful alternative

        // Facilities
        Route::get('/facilities', [AdminFacilityController::class, 'index']);
        Route::post('/facilities', [AdminFacilityController::class, 'store']);
        Route::post('/facilities/{id}', [AdminFacilityController::class, 'update']);
        Route::get('/facilities/delete/{id}', [AdminFacilityController::class, 'destroy']);
        Route::delete('/facilities/{id}', [AdminFacilityController::class, 'destroy']);
    });
});

// ==== Public Endpoints ====
Route::get('/destinations', [DestinationController::class, 'index']);
Route::get('/destinations/{id}', [DestinationController::class, 'show']);
Route::get('/destinations/search', [DestinationController::class, 'search']);

// Reviews: allow guest (no auth) and logged-in
Route::post('/reviews', [ReviewController::class, 'store']);
