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

// remove bookmark
Route::delete('/bookmarked', [PageController::class, 'remove_bookmark'])->name('bookmark.remove');

// show person's info (actor/actress/director)
Route::get('/personality/{id}', [PageController::class, 'show_personality']);

// show collection
Route::get('/collection/{id}', [PageController::class, 'show_collection']);