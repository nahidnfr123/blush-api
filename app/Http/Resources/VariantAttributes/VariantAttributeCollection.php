<?php

namespace App\Http\Resources\VariantAttributes;

use App\Models\VariantAttribute;
use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class VariantAttributeCollection extends ResourceCollection
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
                return VariantAttributeResource::make($data);
            }),
            'trashed_count' => VariantAttribute::onlyTrashed()->count(),
            'meta' => $this->generateMeta(),
        ];
    }
}
