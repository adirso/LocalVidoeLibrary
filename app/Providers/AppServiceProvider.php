<?php
// app/Providers/AppServiceProvider.php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

use NetflixEngine\Movie\MovieRepositoryInterface;
use App\Repositories\MovieRepository;

use NetflixEngine\Series\SeriesRepositoryInterface;
use App\Repositories\SeriesRepository;

use NetflixEngine\Category\CategoryRepositoryInterface;
use App\Repositories\CategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    public function register()
    {
        // Bind Movie Repository
        $this->app->bind(
            MovieRepositoryInterface::class,
            MovieRepository::class
        );

        // Bind Series Repository
        $this->app->bind(
            SeriesRepositoryInterface::class,
            SeriesRepository::class
        );

        // Bind Category Repository
        $this->app->bind(
            CategoryRepositoryInterface::class,
            CategoryRepository::class
        );
    }

    public function boot()
    {
        //
    }
}
