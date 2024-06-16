<?php

namespace App\Http\Services;

use App\Models\Product;
use App\Models\ProductVariant;

class ProductVariantService
{
    public function store($request): ProductVariant
    {
        $data = $request->validated();
        $data['created_by'] = auth()->id();

        $product = Product::find($data['product_id']);
        $product->update(['has_variant' => true]);

        $variant = new ProductVariant();
        $variant->fill($data);
        $variant->save();

        if (isset($data['variant_attribute_values'])) {
            $variant->variantAttributeValues()->sync($data['variant_attribute_values']);
        }

        return $variant;
    }

    public function update($request, $variant): ProductVariant
    {
        $data = $request->validated();
        $data['updated_by'] = auth()->id();
        $variant->fill($data);
        $variant->save();

        if (isset($data['variant_attribute_values'])) {
            $variant->variantAttributeValues()->sync($data['variant_attribute_values']);
        }

        return $variant;
    }

    public function destroy($variant): bool
    {
        return $variant->delete();
    }
}
