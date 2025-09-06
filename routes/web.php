<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\TopDestinationController;
use App\Http\Controllers\TrendingTourController;
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
Route::post('/reviews', [ReviewController::class, 'store'])->name('reviews.store');

// ADMIN
Route::get('/admin/login', [AdminController::class, 'loginForm'])->name('admin.login');
Route::post('/admin/login', [AdminController::class, 'login']);

Route::middleware(['auth', EnsureRole::class . ':1'])->group(function () {
    Route::get('/admin/dashboard', [AdminController::class, 'index'])->name('admin.dashboard');

    // Destinations CRUD
    Route::get('/admin/destinations', [DestinationController::class, 'index'])->name('destinations.index');
    Route::get('/admin/destinations/create', [DestinationController::class, 'create'])->name('destinations.create');
    Route::post('/admin/destinations', [DestinationController::class, 'store'])->name('destinations.store');
    Route::get('/admin/destinations/{id}/edit', [DestinationController::class, 'edit'])->name('destinations.edit');
    Route::put('/admin/destinations/{id}', [DestinationController::class, 'update'])->name('destinations.update');
    Route::delete('/admin/destinations/{id}', [DestinationController::class, 'destroy'])->name('destinations.destroy');

    // Facilities CRUD
    Route::get('/admin/facilities', [FacilityController::class, 'index'])->name('facilities.index');
    Route::get('/admin/facilities/create', [FacilityController::class, 'create'])->name('facilities.create');
    Route::post('/admin/facilities', [FacilityController::class, 'store'])->name('facilities.store');
    Route::get('/admin/facilities/{id}/edit', [FacilityController::class, 'edit'])->name('facilities.edit');
    Route::put('/admin/facilities/{id}', [FacilityController::class, 'update'])->name('facilities.update');
    Route::delete('/admin/facilities/{id}', [FacilityController::class, 'destroy'])->name('facilities.destroy');

    // Trending CRUD
    Route::resource('/admin/trending', TrendingTourController::class)->names([
        'index'=>'trending.index',
        'create'=>'trending.create',
        'store'=>'trending.store',
        'edit'=>'trending.edit',
        'update'=>'trending.update',
        'destroy'=>'trending.destroy',
    ]);

    // Top CRUD
    Route::resource('/admin/top', TopDestinationController::class)->names([
        'index'=>'top.index',
        'create'=>'top.create',
        'store'=>'top.store',
        'edit'=>'top.edit',
        'update'=>'top.update',
        'destroy'=>'top.destroy',
    ]);

    // Reviews - hanya index & destroy
     Route::resource('/admin/reviews', ReviewController::class)->only(['index','destroy'])->names([
        'index'=>'reviews.index',
        'destroy'=>'reviews.destroy',
    ]);
});


