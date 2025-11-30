<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// show bookmarked titles
Route::get('/bookmarked', [PageController::class, 'bookmarked']);

// show about this app
Route::get('/about', [PageController::class, 'about']);

// show movie/series details
Route::get('/title/{type}/{id}', [PageController::class, 'details']);

// show search form
Route::get('/', [PageController::class, 'homepage']);

// add bookmark
Route::post('/bookmarked', [PageController::class, 'add_bookmark'])->name('bookmark.add');