<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use NetflixEngine\Movie\MovieService;
use NetflixEngine\Series\SeriesService;
use NetflixEngine\Category\CategoryService;

class HomeController extends Controller
{
    private MovieService $movieService;
    private SeriesService $seriesService;
    private CategoryService $categoryService;

    public function __construct(
        MovieService $movieService,
        SeriesService $seriesService,
        CategoryService $categoryService
    ) {
        $this->movieService = $movieService;
        $this->seriesService = $seriesService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $latestMovies = $this->movieService->getLatestMovies(4); // Fetch latest 4 movies
        $latestSeries = $this->seriesService->getLatestSeries(4); // Fetch latest 4 series
        $categories = $this->categoryService->listCategories();

        return view('home', [
            'latestMovies' => $latestMovies,
            'latestSeries' => $latestSeries,
            'categories' => $categories,
        ]);
    }

}
