<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'order_id'       => 'required|exists:orders,id',
            'payment_method' => 'required|string|in:pix,credit_card,boleto',
            'amount'         => 'required|numeric|min:0',
            'status'         => 'required|string|in:pending,completed,failed',
        ];
    }
}
