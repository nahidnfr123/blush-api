<?php

namespace App\Http\Resources\Product;

use App\Http\Resources\Admin\AuthAdminUserResource;
use App\Http\Resources\Brand\BrandResource;
use App\Http\Resources\CategoryResource;
use App\Http\Resources\Tag\TagResource;
use App\Traits\FormatMediaTrait;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'name' => $this->name,
            'name_bn' => $this->name_bn,
            'slug' => $this->slug,
            'thumbnail' => $this->thumbnail,
            'video' => $this->video,
            'original_price' => $this->original_price,
            'selling_price' => $this->selling_price,
            'discounted_price' => $this->discounted_price,
            'discount_start_at' => $this->discount_start_at,
            'discount_end_at' => $this->discount_end_at,
            'discount_percentage' => $this->discount_percentage,
            'featured' => $this->featured,
            'active' => $this->active,
            'quantity' => $this->quantity,
            'views' => $this->views,
            'sales' => $this->sales,
            'average_rating' => $this->average_rating,
            'rating_count' => $this->rating_count,
            'published_at' => $this->published_at,
            'has_variant' => $this->has_variant,
            'order' => $this->order,
            'created_by' => new AuthAdminUserResource($this->whenLoaded('createdBy')),
            'updated_by' => new AuthAdminUserResource($this->whenLoaded('updatedBy')),
            'brand' => new BrandResource($this->whenLoaded('brand')),
            'categories' => CategoryResource::collection($this->whenLoaded('categories')),
            'tags' => TagResource::collection($this->whenLoaded('tags')),
            'productDetail' => new ProductDetailResource($this->whenLoaded('productDetail')),
            'variants' => ProductVariantResource::collection($this->whenLoaded('productVariants')),
//            'created_at' => $this->created_at->format('Y-m-d H:i:s'),
//            'updated_at' => $this->updated_at->format('Y-m-d H:i:s'),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'media' => $this->when($this->relationLoaded('media'), function () {
                return $this->getMediaAttributeSimple($this->getMedia('products'));
            }),
        ];
    }
}
