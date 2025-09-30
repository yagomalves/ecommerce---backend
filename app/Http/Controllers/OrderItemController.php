<?php

namespace App\Http\Controllers;

use App\Models\OrderItem;
use App\Http\Requests\StoreOrderItemRequest;
use App\Http\Requests\UpdateOrderItemRequest;

class OrderItemController extends Controller
{
    public function index()
    {
        // Lista todos os itens, com info do produto e pedido
        return OrderItem::with('order', 'product')->paginate(10);
    }

    public function store(StoreOrderItemRequest $request)
    {
        $orderItem = OrderItem::create($request->validated());
        return response()->json($orderItem, 201);
    }

    public function show(OrderItem $orderItem)
    {
        return $orderItem->load('order', 'product');
    }

    public function update(UpdateOrderItemRequest $request, OrderItem $orderItem)
    {
        $orderItem->update($request->validated());
        return response()->json($orderItem);
    }

    public function destroy(OrderItem $orderItem)
    {
        $orderItem->delete();

        return response()->json(null, 204);
    }
}
