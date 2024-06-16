<?php

namespace App\Http\Resources\Tag;

use App\Models\Tag;
use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class TagCollection extends ResourceCollection
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
                return TagResource::make($data);
            }),
            'trashed_count' => Tag::onlyTrashed()->count(),
            'meta' => $this->generateMeta(),
        ];
    }
}
