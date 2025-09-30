<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreOrderRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'total'   => 'required|numeric|min:0',
            'status'  => 'required|string|in:pending,paid,shipped,completed,cancelled',
        ];
    }
}
