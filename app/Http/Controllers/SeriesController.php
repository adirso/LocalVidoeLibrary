<?php

namespace App\Http\Controllers;

use NetflixEngine\Category\CategoryService;
use NetflixEngine\Series\SeriesService;
use NetflixEngine\Series\Exceptions\SeriesNotFoundException;
use Illuminate\Http\Request;

class SeriesController extends Controller
{
    private SeriesService $seriesService;
    private CategoryService $categoryService;

    public function __construct(SeriesService $seriesService, CategoryService $categoryService)
    {
        $this->seriesService = $seriesService;
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the series.
     */
    public function index()
    {
        $seriesList = $this->seriesService->listSeries();
        return view('series.index', ['seriesList' => $seriesList]);
    }

    public function create()
    {
        $categories = $this->categoryService->listCategories();
        return view('series.create', compact('categories'));
    }

    /**
     * Store a newly created series in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'path'           => 'required|string',
            'name'           => 'required|string',
            'description'    => 'required|string',
            'photo'          => 'required|string',
            'season'         => 'required|integer',
            'episode'        => 'required|integer',
            'progress_time'  => 'required|integer',
            'category_id'    => 'required|integer|exists:categories,id',
        ]);

        $this->seriesService->createSeries($data);

        return redirect()->route('series.index')->with('success', 'Series created successfully.');
    }

    /**
     * Display the specified series.
     */
    public function show(int $id)
    {
        try {
            $series = $this->seriesService->getSeriesById($id);
            return view('series.show', ['series' => $series]);
        } catch (SeriesNotFoundException $e) {
            return redirect()->route('series.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified series.
     */
    public function edit(int $id)
    {
        try {
            $series = $this->seriesService->getSeriesById($id);
            $categories = $this->categoryService->listCategories();
            return view('series.edit', compact('series', 'categories'));
        } catch (SeriesNotFoundException $e) {
            return redirect()->route('series.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified series in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'path'           => 'required|string',
            'name'           => 'required|string',
            'description'    => 'required|string',
            'photo'          => 'required|string',
            'season'         => 'required|integer',
            'episode'        => 'required|integer',
            'progress_time'  => 'required|integer',
            'category_id'    => 'required|integer|exists:categories,id',
        ]);

        try {
            $this->seriesService->updateSeries($id, $data);
            return redirect()->route('series.show', $id)->with('success', 'Series updated successfully.');
        } catch (SeriesNotFoundException $e) {
            return redirect()->route('series.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified series from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->seriesService->deleteSeries($id);
            return redirect()->route('series.index')->with('success', 'Series deleted successfully.');
        } catch (SeriesNotFoundException $e) {
            return redirect()->route('series.index')->with('error', $e->getMessage());
        }
    }
}
