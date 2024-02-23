<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use App\Enums\ProductStatus;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
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
            'category' => ['required', 'max:40'],
            'name' => ['required', 'max:100'],
            'description' => ['max:400'],
            'selling_price' => ['required', 'min:0'],
            'special_price' => ['min:0'],
            'is_delivery_available' => ['accepted'],
            'status' => [Rule::enum(ProductStatus::class)],
            'image' => ['mimes:png,jpg,jpeg', 'max:2048'],
            'product_attributes_ids.*' => ['required'],
            'product_attributes_names.*' => ['required', 'max:40'],
            'product_attributes_values.*' => ['required', 'max:40'],
        ];
    }
}
