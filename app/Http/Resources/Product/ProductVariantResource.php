<?php

namespace App\Http\Resources\Product;

use App\Traits\FormatMediaTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductVariantResource extends JsonResource
{
    use FormatMediaTrait;

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
            'name' => $this->name,
            'value' => $this->value,
            'sku_code' => $this->sku_code,
            'original_price' => $this->original_price,
            'selling_price' => $this->selling_price,
            'discounted_price' => $this->discounted_price,
            'discount_percentage' => $this->discount_percentage,
            'quantity' => $this->quantity,
            'featured' => $this->featured,
            'active' => $this->active,
            'thumbnail' => $this->thumbnail,
            'order' => $this->order,
            'media' => $this->when($this->relationLoaded('media'), function () {
                return $this->getMediaAttributeSimple($this->getMedia('productVariants'));
            }),
        ];
    }
}
