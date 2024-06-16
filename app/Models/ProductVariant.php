<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class ProductVariant extends Model implements HasMedia
{
    use HasFactory, SoftDeletes, InteractsWithMedia;

    protected $fillable = [
        'product_id',
        'name',
        'value',
        'sku_code',
        'original_price',
        'selling_price',
        'discounted_price',
        'discount_percentage',
        'quantity',
        'featured',
        'active',
        'thumbnail',
        'order',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'original_price' => 'double:3',
        'selling_price' => 'double:3',
        'discounted_price' => 'double:3',
        'discount_percentage' => 'integer',
    ];

    protected function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
            set: fn(string $value) => strtolower($value),
        );
    }

    public function getThumbnailAttribute($value): ?string
    {
        return $value ? asset('/storage/' . $value) : null;
    }

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(200)
            ->height(320)
            ->sharpen(10)
            ->queued();

        $this->addMediaConversion('small_thumb')
            ->width(60)
            ->height(60)
            ->sharpen(10)
            ->queued();
    }

    public function scopeIsActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function productVariantValues(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(VariantAttributeValue::class, 'variant_attribute_option_sku', 'product_variant_id', 'variant_attribute_value_id');
    }
}
