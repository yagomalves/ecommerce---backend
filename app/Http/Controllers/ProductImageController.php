<?php

namespace App\Http\Controllers;

use App\Models\ProductImage;
use App\Models\Product;
use App\Http\Requests\StoreProductImageRequest;
use App\Http\Requests\UpdateProductImageRequest;
use Illuminate\Http\Request;

class ProductImageController extends Controller
{
    public function storeImages(Request $request, Product $product)
    {
        $request->validate([
            'images.*' => 'required|image|max:2048', // até 2MB cada
        ]);

        $uploadedImages = [];

        foreach ($request->file('images') as $image) {
            $path = $image->store('product_images', 'public'); // salva em storage/app/public/product_images

            $uploadedImages[] = ProductImage::create([
                'product_id' => $product->id,
                'image_url' => asset('storage/' . $path),
            ]);
        }

        return response()->json($uploadedImages, 201);
    }

    public function index()
    {
        return Product::with('images')->paginate(10);
    }

    public function store(StoreProductImageRequest $request)
    {
        $productImage = ProductImage::create($request->validated());
        return response()->json($productImage, 201);
    }

    public function show($slug)
    {
        // Já deve estar incluindo o relacionamento
        return Product::with('images')->where('slug', $slug)->firstOrFail();
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
