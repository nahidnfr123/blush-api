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

class Section extends Model
{
    use HasFactory, HasSlugModelBinding, SoftDeletes;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $fillable = [
        'page_id',
        'title',
        'title_bn',
        'slug',
        'content',
        'view_more_url',
        'api_url',
        'class_name',
        'type',
        'autoplay',
        'active',
        'order',
        'created_by',
        'updated_by',

        'sectionable_id',
        'sectionable_type',
    ];

    public function sectionable(): \Illuminate\Database\Eloquent\Relations\MorphTo
    {
        return $this->morphTo();
    }

    public function page(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Page::class);
    }
}
