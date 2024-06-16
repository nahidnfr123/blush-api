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

class Brand extends Model
{
    use HasFactory, HasSlugModelBinding, SoftDeletes;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $fillable = [
        'name',
        'name_bn',
        'slug',
        'description',
        'logo',
        'image',
        'featured',
        'active',
        'order',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean'
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn(string $value) => ucfirst($value),
            set: fn(string $value) => strtolower($value),
        );
    }

    public function getLogoAttribute($value): ?string
    {
        return $value ? asset('/storage/' . $value) : null;
    }

    public function getImageAttribute($value): ?string
    {
        return $value ? asset('/storage/' . $value) : null;
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Product::class);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order', 'asc');
    }

    public function scopeActive($query)
    {
        return $query->where('active', 1);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', 1);
    }
}
