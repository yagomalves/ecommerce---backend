<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'total'  => 'sometimes|required|numeric|min:0',
            'status' => 'sometimes|required|string|in:pending,paid,shipped,completed,cancelled',
        ];
    }
}
