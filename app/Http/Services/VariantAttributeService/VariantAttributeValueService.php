<?php

namespace App\Http\Services\VariantAttributeService;

use App\Http\Resources\VariantAttributeValueCollection;
use App\Http\Resources\VariantAttributeValueResource;
use App\Models\VariantAttributeValue;

class VariantAttributeValueService
{
    public function getAll(): VariantAttributeValueCollection
    {
        $variantAttribute = VariantAttributeValue::trash()
            ->where('variant_attribute_id', request('attribute_id', 0)) // attribute_id is required ...
            ->search(request('query'), ['%value', '%slug'])
            ->orderBy(request('order_by', 'created_at'), request('order', 'ASC'))
            ->paginate(perPage());

        return VariantAttributeValueCollection::make($variantAttribute);
    }

    public function store($request): VariantAttributeValueResource
    {
        $data = $request->validated();

        $variantAttributeValue = new VariantAttributeValue();
        $variantAttributeValue->fill($data);
        $variantAttributeValue->save();
        return new VariantAttributeValueResource($variantAttributeValue);
    }

    public function update($request, $variantAttributeValue): VariantAttributeValueResource
    {
        $data = $request->validated();
        $variantAttributeValue->fill($data);
        $variantAttributeValue->save();

        return new VariantAttributeValueResource($variantAttributeValue);
    }
}
