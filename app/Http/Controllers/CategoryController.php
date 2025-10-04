<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        return Category::paginate(10);
    }

    public function store(StoreCategoryRequest $request)
    {
        $category = Category::create($request->validated());
        return response()->json($category, 201);
    }

    // MANTÉM o método original para rotas protegidas (admin)
    public function show(Category $category)
    {
        return $category;
    }

    // NOVO MÉTODO para buscar por slug (rotas públicas)
    public function showBySlug($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        return $category;
    }

    // MÉTODO para buscar produtos da categoria
    public function getCategoryProducts($id, Request $request)
    {
        $perPage = $request->get('per_page', 21);
        $page = $request->get('page', 1);

        $category = Category::findOrFail($id);

        $products = $category->products()
            ->with('images')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $products->items(),
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage()
        ]);
    }

    // MÉTODO para buscar produtos da categoria por ID
    public function getCategoryProductsById($id, Request $request)
    {
        $perPage = $request->get('per_page', 21);
        $page = $request->get('page', 1);

        $category = Category::findOrFail($id);

        $products = $category->products()
            ->with('images')
            ->paginate($perPage, ['*'], 'page', $page);

        return response()->json([
            'data' => $products->items(),
            'total' => $products->total(),
            'per_page' => $products->perPage(),
            'current_page' => $products->currentPage(),
            'last_page' => $products->lastPage()
        ]);
    }

    public function update(UpdateCategoryRequest $request, Category $category)
    {
        $category->update($request->validated());
        return response()->json($category);
    }

    public function destroy(Category $category)
    {
        $category->delete();
        return response()->json(null, 204);
    }
}
