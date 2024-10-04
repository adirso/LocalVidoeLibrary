<?php


use Illuminate\Support\Facades\Route;
use App\Http\Controllers\API\MovieController;
use App\Http\Controllers\API\SeriesController;
use App\Http\Controllers\API\CategoryController;

Route::apiResource('movies', MovieController::class);
Route::apiResource('series', SeriesController::class);
Route::apiResource('categories', CategoryController::class);


