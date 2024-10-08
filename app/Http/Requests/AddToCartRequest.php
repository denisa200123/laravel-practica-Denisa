<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AddToCartRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'id' => 'required|exists:products,id', //test if id is in products table
        ];
    }

    public function messages()
    {
        return [
            'id.required' => 'The product id is required.',
            'id.exists' => 'The selected product does not exist.',
        ];
    }
}
