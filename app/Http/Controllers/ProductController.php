<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\UpdateProductRequest;
use Illuminate\Support\Facades\Log; // ✅ ADICIONE ESTA LINHA

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Verifica se o parâmetro 'all' está presente
        if ($request->has('all') && $request->get('all') === 'true') {
            // Retorna TODOS os produtos sem paginação
            return Product::with('images')->get();
        }

        // ✅ CORREÇÃO: Garantir que o slug seja sempre retornado
        // Retorna apenas 15 produtos com paginação (comportamento padrão)
        return Product::with('images')
            ->select('id', 'name', 'slug', 'description', 'price', 'stock_quantity', 'status', 'category_id', 'user_id')
            ->paginate(15);
    }

    // NOVO: Buscar produtos por categoria (slug)
    public function getProductsByCategory($categorySlug)
    {
        // Busca a categoria pelo slug
        $category = \App\Models\Category::where('slug', $categorySlug)->firstOrFail();

        // Retorna produtos da categoria
        $products = Product::where('category_id', $category->id)
            ->with('images')
            ->select('id', 'name', 'slug', 'description', 'price', 'stock_quantity', 'status')
            ->paginate(15);

        return response()->json([
            'category' => $category,
            'products' => $products
        ]);
    }

    // NOVO: Buscar produto por slug
    public function showBySlug($slug)
    {
        Log::info("Buscando produto por slug: " . $slug);

        $product = Product::where('slug', $slug)
            ->with('images', 'category', 'reviews.user', 'user')
            ->firstOrFail();

        return $product;
    }

    public function getProductReviews($identifier)
    {
        // Aceita tanto ID quanto Slug
        if (is_numeric($identifier)) {
            $product = Product::findOrFail($identifier);
        } else {
            $product = Product::where('slug', $identifier)->firstOrFail();
        }

        return $product->load('reviews.user');
    }

    // MANTÉM para rotas protegidas (admin)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'price' => 'required|numeric',
            'stock_quantity' => 'required|integer',
            'category_id' => 'required|exists:categories,id',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_url'] = '/storage/' . $path;
        }

        // ✅ Adiciona automaticamente o user_id do usuário logado
        $validated['user_id'] = Auth::id();


        $product = Product::create($validated);

        return response()->json($product, 201);
    }


    // MANTÉM original para compatibilidade (admin)
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
