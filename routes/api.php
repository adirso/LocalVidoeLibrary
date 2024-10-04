<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\SeriesController;
use App\Http\Controllers\API\CategoryController;
use App\Http\Controllers\API\ProgressController;


Route::apiResource('movies', MovieController::class);
Route::apiResource('series', SeriesController::class);
Route::apiResource('categories', CategoryController::class);

Route::put('/movies/{id}/progress', [ProgressController::class, 'updateMovieProgress'])->name('movies.progress');
Route::put('/episodes/{id}/progress', [ProgressController::class, 'updateEpisodeProgress'])->name('episodes.progress');

