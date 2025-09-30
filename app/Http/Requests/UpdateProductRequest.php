<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste conforme sua lógica de autorização
    }

    public function rules(): array
    {
        $productId = $this->route('product')->id;

        return [
            'category_id'    => 'sometimes|required|exists:categories,id',
            'user_id'        => 'sometimes|required|exists:users,id',
            'name'           => 'sometimes|required|string|max:255',
            'slug'           => "sometimes|required|string|max:255|unique:products,slug,{$productId}",
            'description'    => 'nullable|string',
            'price'          => 'sometimes|required|numeric|min:0',
            'stock_quantity' => 'sometimes|required|integer|min:0',
            'status'         => 'sometimes|required|in:active,inactive,draft',
        ];
    }
}
