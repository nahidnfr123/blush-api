<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cart extends Model
{
  use HasFactory, SoftDeletes;

  protected $fillable = [
    'user_id',
    'product_id',
    'product_variant_id',
    'quantity',
    'price',
    'total',
    'status',
  ];

  public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(Product::class);
  }

  public function productVariant(): \Illuminate\Database\Eloquent\Relations\BelongsTo
  {
    return $this->belongsTo(ProductVariant::class);
  }
}
