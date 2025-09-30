<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ajuste conforme sua lógica de autorização
    }

    public function rules(): array
    {
        return [
            'category_id'    => 'required|exists:categories,id',
            'user_id'        => 'required|exists:users,id',
            'name'           => 'required|string|max:255',
            'slug'           => 'required|string|max:255|unique:products,slug',
            'description'    => 'nullable|string',
            'price'          => 'required|numeric|min:0',
            'stock_quantity' => 'required|integer|min:0',
            'status'         => 'required|in:active,inactive,draft', // Ajuste os status conforme seu projeto
        ];
    }
}
