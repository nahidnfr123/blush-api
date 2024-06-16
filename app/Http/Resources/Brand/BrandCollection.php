<?php

namespace App\Http\Resources\Brand;

use App\Models\Brand;
use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class BrandCollection extends ResourceCollection
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
                return BrandResource::make($data);
            }),
            'trashed_count' => Brand::onlyTrashed()->count(),
            'meta' => $this->generateMeta(),
        ];
    }
}
