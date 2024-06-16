<?php

namespace App\Models;

use App\Enums\ActiveInactiveStatus;
use App\Traits\FormatedDateTrait;
use App\Traits\HasCreatorTrait;
use App\Traits\HasSlugModelBinding;
use App\Traits\TrashScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NahidFerdous\Searchable\Searchable;

class Grid extends Model
{
    use HasFactory, SoftDeletes, HasSlugModelBinding;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $fillable = [
        'grid_id',
        'title',
        'slug',
        'class_name',
        'active',
        'created_by',
        'updated_by',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', ActiveInactiveStatus::Active);
    }

    public function sections(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Section::class, 'sectionable');
    }

    public function gridItems(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(GridItem::class);
    }


}
