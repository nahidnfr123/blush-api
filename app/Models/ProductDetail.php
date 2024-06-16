<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductDetail extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'product_id',
        'description',
        'description_bn',
        'content',
        'specification',

        'origin',

        'warranty_type_id',
        'warranty_duration',
        'warranty_policy',

        'weight',
        'dimensions',
        'handel_with_care',

        'sku_code',
        'size',
        'color',
        'material',
    ];

    public function product(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Product::class);
    }

    public function warrantyType(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(WarrantyType::class);
    }
}
