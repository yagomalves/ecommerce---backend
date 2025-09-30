<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'quantity' => 'sometimes|required|integer|min:1',
            'price'    => 'sometimes|required|numeric|min:0',
        ];
    }
}
