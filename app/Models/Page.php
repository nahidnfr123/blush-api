<?php

namespace App\Models;

use App\Traits\FormatedDateTrait;
use App\Traits\HasCreatorTrait;
use App\Traits\HasSlugModelBinding;
use App\Traits\TrashScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NahidFerdous\Searchable\Searchable;

class Page extends Model
{
    use HasFactory, HasSlugModelBinding, SoftDeletes;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $fillable = [
        'title',
        'slug',
//        'content',
//        'meta_title',
//        'meta_description',
//        'meta_keywords',
//        'active',
//        'order',
        'created_by',
        'updated_by',
    ];

    public function sections(): \Illuminate\Database\Eloquent\Relations\HasMany
    {
        return $this->hasMany(Section::class);
    }
}
