<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class CategoryResource extends JsonResource
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
            'name' => $this->name,
            'name_bn' => $this->name_bn,
            'slug' => $this->slug,
            'icon' => $this->icon,
            'image' => $this->image,
            'active' => $this->active,
            'featured' => $this->featured,
//            'order' => $this->order,
            'parent_id' => $this->parent_id,
            'products_count' => $this->products_count,
            'children' => CategoryResource::collection($this->whenLoaded('children')),
        ];
    }
}
