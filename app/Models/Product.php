<?php

namespace App\Models;

use App\Traits\FormatedDateTrait;
use App\Traits\HasCreatorTrait;
use App\Traits\HasSlugModelBinding;
use App\Traits\TrashScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NahidFerdous\Searchable\Searchable;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Product extends Model implements HasMedia
{
    use HasFactory, HasSlugModelBinding, SoftDeletes, InteractsWithMedia;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $fillable = [
        'brand_id',
        'name',
        'name_bn',
        'slug',
        'thumbnail',
        'video',
        'original_price',
        'selling_price',
        'discounted_price',
        'discount_start_at',
        'discount_end_at',
        'discount_percentage',
        'featured',
        'active',
        'quantity',
        'views',
        'sales',
        'average_rating',
        'rating_count',
        'published_at',
        'has_variant',
        'draft',
        'order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'published_at' => 'datetime',
        'original_price' => 'double:3',
        'selling_price' => 'double:3',
        'discounted_price' => 'double:3',
        'discount_start_at' => 'datetime',
        'discount_end_at' => 'datetime',
        'discount_percentage' => 'integer',
        'has_variant' => 'boolean',
        'draft' => 'boolean',
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

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('quantity', '>', 0);
    }

    public function scopeVisible($query)
    {
        return $query->where('active', 1)
            ->where('draft', 0)
            ->where('published_at', '<=', now());
    }

    public function categories(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Category::class);
    }

    public function brand(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Brand::class);
    }

    public function tags(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Tag::class);
    }

    public function productDetail(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(ProductDetail::class);
    }

    public function productVariants(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function ratings(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(ProductRating::class);
    }
}
