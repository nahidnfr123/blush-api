<?php

namespace App\Http\Resources\PageManager;

use App\Http\Resources\SectionResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PageResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->title,
            'slug' => $this->slug,
            'created_at' => $this->created_at,

            'sections' => SectionResource::collection($this->whenLoaded('sections')),
        ];
    }
}
