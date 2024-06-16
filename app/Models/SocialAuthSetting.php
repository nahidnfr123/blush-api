<?php

namespace App\Models;

use App\Traits\HasSlugModelBinding;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use NahidFerdous\Searchable\Searchable;

class SocialAuthSetting extends Model
{
  use HasFactory, HasSlugModelBinding, SoftDeletes, Searchable;

  protected $fillable = [
    'slug',
    'provider',
    'client_id',
    'client_secret',
    'redirect_url',
    'active',
    'logo'
  ];
}
