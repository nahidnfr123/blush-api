<?php

namespace App\Http\Resources\PageManager;

use App\Models\Grid;
use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class GridCollection extends ResourceCollection
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
                return GridResource::make($data);
            }),
            'trashed_count' => Grid::onlyTrashed()->count(),
            'meta' => $this->generateMeta(),
        ];
    }
}
