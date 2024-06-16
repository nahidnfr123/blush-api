<?php

namespace App\Http\Resources\PageManager;

use App\Models\Page;
use App\Traits\MetaResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\ResourceCollection;

class PageCollection extends ResourceCollection
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
                return PageResource::make($data);
            }),
            'trashed_count' => Page::onlyTrashed()->count(),
            'meta' => $this->generateMeta(),
        ];
    }
}
