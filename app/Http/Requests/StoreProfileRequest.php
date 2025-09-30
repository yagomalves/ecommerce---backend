<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // ajuste conforme regras de autorização
    }

    public function rules(): array
    {
        return [
            'user_id'   => 'required|exists:users,id',
            'phone'     => 'nullable|string|max:20',
            'address'   => 'nullable|string|max:500',
            'city'      => 'nullable|string|max:255',
            'state'     => 'nullable|string|max:255',
            'zip_code'  => 'nullable|string|max:20',
            'country'   => 'nullable|string|max:255',
        ];
    }
}
