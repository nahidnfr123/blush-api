<?php

namespace App\Models;

use App\Traits\HasCreatorTrait;
use App\Traits\HasSlugModelBinding;
use App\Traits\TrashScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Cache;
use NahidFerdous\Searchable\Searchable;

class Category extends Model
{
    use HasFactory, HasSlugModelBinding, SoftDeletes;
    use TrashScope, Searchable, HasCreatorTrait;

    protected $fillable = [
        'name',
        'name_bn',
        'slug',
        'icon',
        'image',
        'active',
        'featured',
        'order',
        'parent_id',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
        'featured' => 'boolean',
        'parent_id' => 'integer',
        'order' => 'integer',
    ];


    public static function boot(): void
    {
        parent::boot();

        static::creating(function () {
            cache()->forget('categoryTree');
        });

        static::updating(function () {
            cache()->forget('categoryTree');
        });

        static::deleting(function () {
            cache()->forget('categoryTree');
        });
    }


    public static function tree($select = null, $withProductCount = false)
    {
        $cacheKey = 'categoryTree';
        return Cache::rememberForever($cacheKey, function () use ($select, $withProductCount) {
            $allCategories = Category::query();
            $allCategories = $allCategories->trash()->orderBy('order');

            if ($withProductCount) {
                $allCategories = $allCategories->withCount('products');
            }

            if ($select) {
                $allCategories = $allCategories->select($select);
            }

            $allCategories = $allCategories->get();

            $rootCategories = $allCategories->whereNull('parent_id');
            self::formatTree($rootCategories, $allCategories);

            return $rootCategories->values();
        });
    }

    public static function formatTree($categories, $allCategories): void
    {
        foreach ($categories as $category) {
            $category->children = $allCategories->where('parent_id', $category->id)->values();
            if ($category->children->isNotEmpty()) {
                self::formatTree($category->children, $allCategories);
            }
        }
    }

    public function products(): \Illuminate\Database\Eloquent\Relations\BelongsToMany
    {
        return $this->belongsToMany(Product::class);
    }

    public function parent(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public function children(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Category::class, 'parent_id');
    }

    public function scopeParents($query)
    {
        return $query->whereNull('parent_id');
    }

    public function scopeChildren($query)
    {
        return $query->whereNotNull('parent_id');
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('name');
    }

    public function scopeOrderedParents($query)
    {
        return $query->parents()->ordered();
    }

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }
}
