<?php

namespace App\Models;

use App\Traits\FormatedDateTrait;
use App\Traits\HasCreatorTrait;
use App\Traits\TrashScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NahidFerdous\Searchable\Searchable;

class Coupon extends Model
{
    use HasFactory, SoftDeletes;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $fillable = [
        'code',
        'type',
        'value',
        'expiry_date',
        'active',
        'created_by',
        'updated_by',
    ];
}
