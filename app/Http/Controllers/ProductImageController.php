<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;

class ProductImageController extends Controller
{
    public function index()
    {
        return ProductImage::with('product')->paginate(10);
    }

    public function store(StoreProductImageRequest $request)
    {
        $productImage = ProductImage::create($request->validated());
        return response()->json($productImage, 201);
    }

    public function show(ProductImage $productImage)
    {
        return $productImage->load('product');
    }

    public function update(UpdateProductImageRequest $request, ProductImage $productImage)
    {
        $productImage->update($request->validated());
        return response()->json($productImage);
    }

    public function destroy(ProductImage $productImage)
    {
        $productImage->delete();

        return response()->json(null, 204);
    }
}
