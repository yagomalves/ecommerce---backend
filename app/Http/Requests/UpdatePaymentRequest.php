<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'payment_method' => 'sometimes|required|string|in:pix,credit_card,boleto',
            'amount'         => 'sometimes|required|numeric|min:0',
            'status'         => 'sometimes|required|string|in:pending,completed,failed',
        ];
    }
}
