<?php
// routes/web.php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\MovieController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\MovieSeriesController;
use App\Http\Controllers\VideoStreamController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group that
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', [HomeController::class, 'index'])->name('home');

// Routes for Movies
Route::resource('movies', MovieController::class);

// Routes for Series
Route::resource('series', SeriesController::class);

// Routes for Categories
Route::resource('categories', CategoryController::class);

Route::get('/watch/{type}/{id}', [MovieSeriesController::class, 'watch'])->name('watch');

Route::get('/stream/{type}/{id}', [VideoStreamController::class, 'stream'])->name('stream');

