<?php

namespace App\Http\Requests;

use App\Models\Product;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductCreateRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255', Rule::unique(Product::class)],
            'description' => ['max:255'],
            'sku_code' => ['required', 'string', 'max:255'],
            'price' => ['required', 'string', 'max:255'],
            'price_adjustment' => ['max:10'],
        ];
    }
}
