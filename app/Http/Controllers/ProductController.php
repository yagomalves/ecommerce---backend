<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

class ProductController extends Controller
{


    public function index()
    {
        return Product::with('images')->paginate(10);
    }


    public function store(StoreProductRequest $request)
    {
        $product = Product::create($request->validated());
        return response()->json($product, 201);
    }


    public function show(Product $product)
    {
        return $product->load('images', 'category', 'reviews');
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
