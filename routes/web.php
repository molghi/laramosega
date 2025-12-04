<?php

use App\Http\Controllers\PageController;
use Illuminate\Support\Facades\Route;

// show bookmarked titles
Route::get('/bookmarked', [PageController::class, 'bookmarked'])->middleware('auth');

// show about this app
Route::get('/about', [PageController::class, 'about']);

// show movie/series details
Route::get('/title/{type}/{id}', [PageController::class, 'details'])->middleware('auth');

// show search form
Route::get('/', [PageController::class, 'homepage'])->middleware('auth');

// add bookmark
Route::post('/bookmarked', [PageController::class, 'add_bookmark'])->name('bookmark.add')->middleware('auth');

// remove bookmark
Route::delete('/bookmarked', [PageController::class, 'remove_bookmark'])->name('bookmark.remove')->middleware('auth');

// show person's info (actor/actress/director)
Route::get('/personality/{id}', [PageController::class, 'show_personality'])->middleware('auth');

// show collection
Route::get('/collection/{id}', [PageController::class, 'show_collection'])->middleware('auth');

// show movies by genre
Route::get('/genre/movie/{id}', [PageController::class, 'show_movie_by_genre'])->middleware('auth');

// show series by genre
Route::get('/genre/series/{id}', [PageController::class, 'show_series_by_genre'])->middleware('auth');

// show login/signup forms
Route::get('/auth', [PageController::class, 'show_auth'])->name('login');

// sign user up
Route::post('/signup', [PageController::class, 'signup'])->name('user.signup');

// log user in
Route::post('/login', [PageController::class, 'login'])->name('user.login');

// log user out
Route::get('/logout', [PageController::class, 'logout'])->middleware('auth');