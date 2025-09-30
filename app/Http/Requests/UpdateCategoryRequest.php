<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCategoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'        => 'sometimes|required|string|max:255|unique:categories,name,' . $this->category->id,
            'slug'        => 'sometimes|required|string|max:255|unique:categories,slug,' . $this->category->id,
            'description' => 'nullable|string',
        ];
    }
}
