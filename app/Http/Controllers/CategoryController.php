<?php
// app/Http/Controllers/CategoryController.php

namespace App\Http\Controllers;

use NetflixEngine\Category\CategoryService;
use NetflixEngine\Category\Exceptions\CategoryNotFoundException;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private CategoryService $categoryService;

    public function __construct(CategoryService $categoryService)
    {
        $this->categoryService = $categoryService;
    }

    /**
     * Display a listing of the categories.
     */
    public function index()
    {
        $categories = $this->categoryService->listCategories();
        return view('categories.index', ['categories' => $categories]);
    }

    /**
     * Show the form for creating a new category.
     */
    public function create()
    {
        return view('categories.create');
    }

    /**
     * Store a newly created category in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:categories,name',
        ]);

        $this->categoryService->createCategory($data);

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    /**
     * Display the specified category.
     */
    public function show(int $id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return view('categories.show', ['category' => $category]);
        } catch (CategoryNotFoundException $e) {
            return redirect()->route('categories.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Show the form for editing the specified category.
     */
    public function edit(int $id)
    {
        try {
            $category = $this->categoryService->getCategoryById($id);
            return view('categories.edit', ['category' => $category]);
        } catch (CategoryNotFoundException $e) {
            return redirect()->route('categories.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Update the specified category in storage.
     */
    public function update(Request $request, int $id)
    {
        $data = $request->validate([
            'name' => 'required|string|unique:categories,name,' . $id,
        ]);

        try {
            $this->categoryService->updateCategory($id, $data);
            return redirect()->route('categories.show', $id)->with('success', 'Category updated successfully.');
        } catch (CategoryNotFoundException $e) {
            return redirect()->route('categories.index')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified category from storage.
     */
    public function destroy(int $id)
    {
        try {
            $this->categoryService->deleteCategory($id);
            return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
        } catch (CategoryNotFoundException $e) {
            return redirect()->route('categories.index')->with('error', $e->getMessage());
        }
    }
}
