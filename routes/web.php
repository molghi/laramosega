<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// show search form
Route::get('/', [PageController::class, 'homepage']);

// show bookmarked titles
Route::get('/bookmarked', [PageController::class, 'bookmarked']);

// show about this app
Route::get('/about', [PageController::class, 'about']);