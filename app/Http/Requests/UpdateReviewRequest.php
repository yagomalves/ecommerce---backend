<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ajuste conforme regras de autorização
    }

    public function rules(): array
    {
        return [
            'user_id'    => 'sometimes|required|exists:users,id',
            'product_id' => 'sometimes|required|exists:products,id',
            'rating'     => 'sometimes|required|integer|min:1|max:5',
            'comment'    => 'nullable|string|max:1000',
        ];
    }
}
