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

class GridItem extends Model
{
    use HasFactory, SoftDeletes;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $fillable = [
        'grid_id',
        'title',
        'title_bn',
        'subtitle',
        'subtitle_bn',
        'button_text',
        'button_text_bn',
        'url',
        'image',
        'class_name',
        'height',
        'active',
        'order',
        'created_by',
        'created_by',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', ActiveInactiveStatus::Active);
    }

    public function getImageAttribute($value): ?string
    {
        return $value ? asset('/storage/' . $value) : null;
    }

    public function Grid(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Grid::class);
    }
}
