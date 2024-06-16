<?php

namespace App\Http\Requests\Product;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'name_bn' => 'sometimes|required|string|max:255',
            'slug' => 'sometimes|required|string|max:255',
            'brand' => 'sometimes|required|string|max:255',
            'category_ids' => 'required|array',
            'category_ids.*' => 'sometimes|required|integer',
            'tags' => 'sometimes|required',
            'featured' => 'sometimes|required|boolean',
            'active' => 'sometimes|required|boolean',
            'published_at' => 'sometimes|required|date',

            'thumbnail_link' => 'sometimes|required|string|max:255',
            'thumbnail' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:1024',
            'images' => 'sometimes|required|array',
            'images.*' => 'sometimes|required|string|max:255',
            'video' => 'sometimes|required|string|max:255|url',

            'original_price' => 'required|numeric|gte:0',
            'selling_price' => 'required|numeric|gte:0',
//            'selling_price' => 'required|numeric|lte:original_price|gte:0',
            'discounted_price' => 'sometimes|required|numeric|lte:selling_price|gte:0',
            'discount_percentage' => 'sometimes|required|numeric|lte:100|gte:0',
            'discount_duration' => 'sometimes|required|array',
            'quantity' => 'sometimes|required|numeric|gte:0',

            'description' => 'sometimes|required|string',
            'description_bn' => 'sometimes|required|string',
            'content' => 'sometimes|required|string',
            'specification' => 'sometimes|required|string',
            'origin' => 'sometimes|required|string|max:255',

            'warranty_type_id' => 'sometimes|required|integer|exists:warranty_types,id',
            'warranty_duration' => 'sometimes|required|string|max:255',
            'warranty_policy' => 'sometimes|required|string|max:255',

            'weight' => 'sometimes|required|string',
            'dimensions' => 'sometimes|required|string',
            'handel_with_care' => 'sometimes|required|boolean',

            'sku' => 'sometimes|required|string',
            'size' => 'sometimes|required|string',
            'color' => 'sometimes|required|string',
            'material' => 'sometimes|required|string',

            'has_variant' => 'sometimes|required|boolean',
            'draft' => 'sometimes|required|boolean',
            'featured_variant_index' => 'sometimes|required|integer',

            'variants' => 'required_if:has_variant,true|array',

            'variants.*.attributes' => 'required|array',
            'variants.*.attributes.*.name' => 'required',
            'variants.*.attributes.*.value' => 'required',

            'variants.*.sku_code' => 'required|string',
            'variants.*.quantity' => 'sometimes|required|numeric|gte:0',
            'variants.*.original_price' => 'required|string',
            'variants.*.selling_price' => 'required|string',
            'variants.*.discounted_price' => 'required|string',
            'variants.*.discount_percentage' => 'sometimes|required|string',
            'variants.*.discount_duration' => 'sometimes|required|string',
            'variants.*.active' => 'required|boolean',
            'variants.*.thumbnail' => 'sometimes|required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'variants.*.thumbnail_link' => 'sometimes|required|string|max:255',
            'variants.*.images' => 'sometimes|required|array',
            'variants.*.images.*' => 'sometimes|required|string|max:255',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'category_ids.required' => 'The category field is required.',

            'variants.*.attributes.required' => 'The attributes field is required.',
            'variants.*.attributes.*.name.required' => 'The name field is required.',
            'variants.*.attributes.*.value.required' => 'The value field is required.',

            'variants.*.sku_code.required' => 'The sku code field is required.',
            'variants.*.quantity.required' => 'The quantity field is required.',
            'variants.*.original_price.required' => 'The original price field is required.',
            'variants.*.selling_price.required' => 'The selling price field is required.',
            'variants.*.discounted_price.required' => 'The discounted price field is required.',
            'variants.*.discount_percentage.required' => 'The discount percentage field is required.',
            'variants.*.discount_duration.required' => 'The discount duration field is required.',
            'variants.*.active.required' => 'The active field is required.',
            'variants.*.thumbnail.required' => 'The thumbnail field is required.',
            'variants.*.thumbnail_link.required' => 'The thumbnail link field is required.',
        ];
    }
}
