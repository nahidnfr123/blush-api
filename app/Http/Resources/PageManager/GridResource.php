<?php

namespace App\Http\Resources\PageManager;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class GridResource extends JsonResource
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
            'grid_id' => $this->grid_id,
            'title' => $this->title,
            'slug' => $this->slug,
            'class_name' => $this->class_name,
            'active' => $this->active,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'grid_items' => GridItemResource::collection($this->whenLoaded('gridItems')),
        ];
    }
}
