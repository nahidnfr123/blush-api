<?php

namespace App\Http\Resources\Product;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductDetailResource extends JsonResource
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
            'product_id' => $this->product_id,
            'description' => $this->description,
            'description_bn' => $this->description_bn,
            'content' => $this->content,
            'specification' => $this->specification,

            'origin' => $this->origin,

            'warranty_type_id' => $this->warranty_type_id,
            'warranty_duration' => $this->warranty_duration,
            'warranty_policy' => $this->warranty_policy,

            'weight' => $this->weight,
            'dimensions' => $this->dimensions,
            'handel_with_care' => $this->handel_with_care,

            'sku_code' => $this->sku_code,
            'size' => $this->size,
            'color' => $this->color,
            'material' => $this->material,
        ];
    }
}
