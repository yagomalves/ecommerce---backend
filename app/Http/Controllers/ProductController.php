<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Review;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{


    public function index(Request $request)
    {
        // Verifica se o parâmetro 'all' está presente
        if ($request->has('all') && $request->get('all') === 'true') {
            // Retorna TODOS os produtos sem paginação
            return Product::with('images')->get();
        }

        // Retorna apenas 15 produtos com paginação (comportamento padrão)
        return Product::with('images')->paginate(15);
    }

    public function getProductReviews(Product $product)
    {
        return $product->load('reviews.user');
    }

    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }


    public function show(Product $product)
    {
        return $product->load('images', 'category', 'reviews.user', 'user');
    }


    public function update(UpdateProductRequest $request, Product $product)
    {
        $product->update($request->validated());
        return response()->json($product);
    }


    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(null, 204);
    }
}
