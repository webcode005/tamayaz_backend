<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\ServiceController;

Route::get('/services', [ServiceController::class, 'index']);
Route::get('/services/{id}', [ServiceController::class, 'show']);
