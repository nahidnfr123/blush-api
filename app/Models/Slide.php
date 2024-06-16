<?php

namespace App\Models;

use App\Enums\ActiveInactiveStatus;
use App\Traits\FormatedDateTrait;
use App\Traits\HasCreatorTrait;
use App\Traits\TrashScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NahidFerdous\Searchable\Searchable;

class Slide extends Model
{
    use HasFactory, SoftDeletes;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $fillable = [
        'title',
        'title_bn',
        'subtitle',
        'subtitle_bn',
        'image',
        'button_text',
        'button_text_bn',
        'link',
        'order',
        'active',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', ActiveInactiveStatus::Active);
    }

    public function getImageAttribute($value): ?string
    {
        return $value ? asset('/storage/' . $value) : null;
    }

    public function sections(): \Illuminate\Database\Eloquent\Relations\MorphOne
    {
        return $this->morphOne(Section::class, 'sectionable');
    }

}
