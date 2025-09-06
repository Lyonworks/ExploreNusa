<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DestinationController;
use App\Http\Controllers\FacilityController;
use App\Http\Controllers\ReviewController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\AuthController;
use App\Http\Middleware\EnsureRole;

// USER
Route::get('/', [HomeController::class, 'index']);
Route::get('/destinations', [DestinationController::class, 'list']);
Route::get('/destinations/{id}', [DestinationController::class, 'show']);
Route::get('/search', [HomeController::class, 'search']);

// AUTH USER
Route::get('/register', [AuthController::class, 'registerForm']);
Route::post('/register', [AuthController::class, 'register']);
Route::get('/login', [AuthController::class, 'loginForm']);
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout']);

// REVIEW
Route::post('/reviews', [ReviewController::class, 'store']);

// ADMIN
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware(['auth', EnsureRole::class . ':1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    Route::get('/admin/destinations', [DestinationController::class, 'index']);
    Route::get('/admin/destinations/create', [DestinationController::class, 'create']);
    Route::post('/admin/destinations', [DestinationController::class, 'store']);
    Route::get('/admin/destinations/{id}/edit', [DestinationController::class, 'edit']);
    Route::put('/admin/destinations/{id}', [DestinationController::class, 'update']);
    Route::delete('/admin/destinations/{id}', [DestinationController::class, 'destroy']);

    Route::get('/admin/facilities', [FacilityController::class, 'index']);
    Route::get('/admin/facilities/create', [FacilityController::class, 'create']);
    Route::post('/admin/facilities', [FacilityController::class, 'store']);
    Route::get('/admin/facilities/{id}/edit', [FacilityController::class, 'edit']);
    Route::put('/admin/facilities/{id}', [FacilityController::class, 'update']);
    Route::delete('/admin/facilities/{id}', [FacilityController::class, 'destroy']);
});

