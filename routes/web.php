<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Admin\AdminDashboardController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\ServicesController;
use App\Http\Controllers\User\UserDashboardController;



Route::get('/', function () {
    return view('auth.login');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});




/* Admin Routes */
Route::middleware(['auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', [AdminDashboardController::class, 'index'])->name('dashboard');
        Route::get('/logout', [AdminDashboardController::class, 'logout'])->name('logout');
        Route::get('/change-password', [AdminDashboardController::class, 'changePassword'])->name('change-password');
        Route::post('/update-password', [AdminDashboardController::class, 'updatePassword'])->name('update-password');
        Route::get('/settings', [AdminDashboardController::class, 'settings'])->name('settings');

        // Other Route



        // Category Route
        Route::get('/category', [CategoryController::class, 'index'])->name('category');
        Route::post('/add-category', [CategoryController::class, 'store'])->name('category.store');
        Route::get('/edit-category/{id}', [CategoryController::class, 'edit'])->name('category.edit');
        Route::post('/update-category/{id}', [CategoryController::class, 'update'])->name('category.update');
        Route::delete('/category/{id}', [CategoryController::class, 'destroy'])->name('category.delete');

        // Services Route
        Route::get('/service', [ServicesController::class, 'index'])->name('service');
        Route::post('/add-service', [ServicesController::class, 'store'])->name('service.store');
        Route::get('/edit-service/{id}', [ServicesController::class, 'edit'])->name('service.edit');
        Route::post('/update-service/{id}', [ServicesController::class, 'update'])->name('service.update');
        Route::delete('/service/{id}', [ServicesController::class, 'destroy'])->name('service.delete');


        Route::get('/whychoose', [AdminDashboardController::class, 'index'])->name('whychoose');
    });

/* User Routes */
Route::middleware(['auth', 'user'])
    ->prefix('user')
    ->name('user.')
    ->group(function () {
        Route::get('/dashboard', [UserDashboardController::class, 'index'])
            ->name('dashboard');
    });


require __DIR__ . '/auth.php';
