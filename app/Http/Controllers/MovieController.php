<?php
// app/Http/Controllers/MovieController.php

namespace App\Http\Controllers;

use NetflixEngine\Category\CategoryService;
use NetflixEngine\Movie\MovieService;
use NetflixEngine\Movie\Exceptions\MovieNotFoundException;
use Illuminate\Http\Request;

class MovieController extends Controller
{
    private MovieService $movieService;
    private CategoryService $categoryService;

    public function __construct(MovieService $movieService, CategoryService  $categoryService)

    {
        $this->movieService = $movieService;
        $this->categoryService = $categoryService;
    }

    public function index()
    {
        $movies = $this->movieService->listMovies();
        return view('movies.index', ['movies' => $movies]);
    }

    public function show(int $id)
    {
        try {
            $movie = $this->movieService->getMovieById($id);
            return view('movies.show', ['movie' => $movie]);
        } catch (MovieNotFoundException $e) {
            return redirect()->route('movies.index')->with('error', $e->getMessage());
        }
    }

    public function create()
    {
        $categories = $this->categoryService->listCategories();
        return view('movies.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // Validate and create a new movie
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'path' => 'required|string',
            'photo' => 'required|string',
            'progress_time' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        $this->movieService->createMovie($data);

        return redirect()->route('movies.index')->with('success', 'Movie created successfully.');
    }

    public function edit(int $id)
    {
        try {
            $movie = $this->movieService->getMovieById($id);
            $categories = $this->categoryService->listCategories();
            return view('movies.edit', compact('movie', 'categories'));
        } catch (MovieNotFoundException $e) {
            return redirect()->route('movies.index')->with('error', $e->getMessage());
        }
    }

    public function update(Request $request, int $id)
    {
        // Validate and update the movie
        $data = $request->validate([
            'name' => 'required|string',
            'description' => 'required|string',
            'path' => 'required|string',
            'photo' => 'required|string',
            'progress_time' => 'required|integer',
            'category_id' => 'required|integer|exists:categories,id',
        ]);

        try {
            $this->movieService->updateMovie($id, $data);
            return redirect()->route('movies.show', $id)->with('success', 'Movie updated successfully.');
        } catch (MovieNotFoundException $e) {
            return redirect()->route('movies.index')->with('error', $e->getMessage());
        }
    }

    public function destroy(int $id)
    {
        try {
            $this->movieService->deleteMovie($id);
            return redirect()->route('movies.index')->with('success', 'Movie deleted successfully.');
        } catch (MovieNotFoundException $e) {
            return redirect()->route('movies.index')->with('error', $e->getMessage());
        }
    }
}
