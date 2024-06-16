<?php

namespace App\Http\Resources;

use App\Models\VariantAttributeValue;
use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VariantAttributeValueCollection extends ResourceCollection
{
    use MetaResponseTrait;
    /**
     * Transform the resource collection into an array.
     *
     * @return array<int|string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'data' => $this->collection->transform(function ($data) {
                return VariantAttributeValueResource::make($data);
            }),
            'trashed_count' => VariantAttributeValue::onlyTrashed()->count(),
            'meta' => $this->generateMeta(),
        ];
    }
}
