<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Http\Requests\StoreCartRequest;
use App\Http\Requests\UpdateCartRequest;
use Illuminate\Support\Facades\Auth;


class CartController extends Controller
{
    public function index()
    {
        // Você pode querer listar apenas o carrinho do usuário logado
        $user = Auth::user();

        // Retorna apenas o carrinho do usuário autenticado com os itens + produto
        return Cart::with('items.product')
            ->where('user_id', $user->id)
            ->first();
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
