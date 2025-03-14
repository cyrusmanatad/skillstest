<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class AdminProductUpdateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('productId');

        return [
            'title' => [
                'required', 
                'string', 
                'max:255', 
                Rule::unique(Product::class)->ignore($productId)
            ],
            'body' => ['required', 'string', 'max:255'],
            'user_id' => ['integer'],
        ];
    }
}
