<?php

namespace App\Http\Resources\Brand;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class BrandResource extends JsonResource
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
            'description' => $this->description,
            'logo' => $this->logo,
            'image' => $this->image,
            'active' => $this->active,
            'featured' => $this->featured,
            'order' => $this->order,
            'products_count' => $this->products_count,
            'created_by' => $this->created_by,
        ];
    }
}
