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
    public function getProductsByCategory($slug)
    {
        $category = Category::where('slug', $slug)->firstOrFail();
        $products = $category->products()->paginate(12); // Assumindo relação 'products'
        
        return response()->json([
            'category' => $category,
            'products' => $products
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