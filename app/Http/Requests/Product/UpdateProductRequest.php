<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\formRequest;

class UpdateProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation Rules that apply to the request
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'sometimes|string|unique:products,name',
            'price' => 'sometimes|numeric',
            'description' => 'sometimes|string',
            'category' => 'sometimes|string',
            'image' => 'url',
        ];
    }
}
