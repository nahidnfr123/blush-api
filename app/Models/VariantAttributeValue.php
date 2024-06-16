<?php

namespace App\Models;

use App\Traits\HasSlug\HasSlug;
use App\Traits\HasSlug\SlugOptions;
use App\Traits\HasSlugModelBinding;
use App\Traits\TrashScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NahidFerdous\Searchable\Searchable;

class VariantAttributeValue extends Model
{
    use HasFactory, HasSlug, SoftDeletes, TrashScope, Searchable;

    protected $fillable = [
        'variant_attribute_id',
        'value',
        'slug',
        'order',
    ];

    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('value')
            ->saveSlugsTo('slug')
            ->replaceRouteKey(true, true);
    }

    public function value(): Attribute
    {
        return Attribute::make(
            get: fn ($value) => ucfirst($value),
            set: fn ($value) => strtolower($value),
        );
    }

    public function variantAttribute(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(VariantAttribute::class);
    }

    public function productVariants(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(ProductVariant::class, 'variant_attribute_option_sku', 'variant_attribute_value_id', 'product_variant_id');
    }
}
