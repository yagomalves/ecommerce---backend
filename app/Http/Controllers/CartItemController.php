<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;

class CartItemController extends Controller
{
    public function index()
    {
        return CartItem::with('product')->paginate(10);
    }

    public function store(StoreCartItemRequest $request)
    {
        $cartItem = CartItem::create($request->validated());

        return response()->json($cartItem, 201);
    }

    public function show(CartItem $cartItem)
    {
        return $cartItem->load('product');
    }

    public function update(UpdateCartItemRequest $request, CartItem $cartItem)
    {
        $cartItem->update($request->validated());

        return response()->json($cartItem);
    }

    public function destroy(CartItem $cartItem)
    {
        $cartItem->delete();

        return response()->json(null, 204);
    }
}
