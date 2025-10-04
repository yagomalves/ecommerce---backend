<?php

namespace App\Http\Controllers;

use App\Models\CartItem;
use App\Http\Requests\StoreCartItemRequest;
use App\Http\Requests\UpdateCartItemRequest;
use Illuminate\Support\Facades\Auth;


class CartItemController extends Controller
{

    public function index()
    {
        $user = Auth::user();

        return \App\Models\CartItem::with('product')
            ->whereHas('cart', function ($q) use ($user) {
                $q->where('user_id', $user->id);
            })
            ->get();
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
