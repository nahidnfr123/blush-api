<?php

namespace App\Models;

use App\Traits\HasSlugModelBinding;
use App\Traits\TrashScope;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NahidFerdous\Searchable\Searchable;

class VariantAttribute extends Model
{
    use HasFactory, HasSlugModelBinding, SoftDeletes;
    use TrashScope, Searchable;

    protected $fillable = [
        'name',
        'slug',
        'order',
        'active',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function name(): Attribute
    {
        return Attribute::make(
            get: fn (string $value) => ucfirst($value),
            set: fn (string $value) => strtolower($value),
        );
    }

    public function variantAttributeValues(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(VariantAttributeValue::class);
    }
}
