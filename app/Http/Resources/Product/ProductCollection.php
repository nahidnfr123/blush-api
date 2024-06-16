<?php

namespace App\Http\Resources\Product;

use App\Models\Product;
use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class ProductCollection extends ResourceCollection
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
                return ProductResource::make($data);
            }),
            'trashed_count' => Product::onlyTrashed()->count(),
            'meta' => $this->generateMeta(),
        ];
    }
}
