<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;

class CartController extends Controller
{
    public function index()
    {
        // Você pode querer listar apenas o carrinho do usuário logado
        return Cart::with('items')->paginate(10);
    }


    public function store(StoreCartRequest $request)
    {
        $cart = Cart::create($request->validated());

        return response()->json($cart, 201);
    }

    public function show(Cart $cart)
    {
        return $cart->load('items.product');
    }


    public function update(UpdateCartRequest $request, Cart $cart)
    {
        $cart->update($request->validated());

        return response()->json($cart);
    }

    public function destroy(Cart $cart)
    {
        $cart->delete();

        return response()->json(null, 204);
    }
}
