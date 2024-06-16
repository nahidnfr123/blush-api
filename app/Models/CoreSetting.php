<?php

namespace App\Models;

use App\Traits\FormatedDateTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class CoreSetting extends Model
{
    use HasFactory;
    use FormatedDateTrait;

    protected $fillable = [
//        'maintenance_mode',
//        'always_upto_date',
//        'developer_percentage',
//        'locale',
//        'timezone',
//        'currency_name',
//        'currency_code',
//        'currency_symbol',

        'key',
        'value'
    ];

    protected $casts = [
//        'maintenance_mode' => 'boolean',
//        'developer_percentage' => 'double',
    ];

    public static function boot()
    {
        parent::boot();
        static::creating(function () {
            Cache::forget('coreSettings');
        });
        static::updating(function () {
            Cache::forget('coreSettings');
        });
        static::deleting(function () {
            Cache::forget('coreSettings');
        });

    }

    public static function getAll()
    {
        return Cache::rememberForever('coreSettings', function () {
            $data = (array)[];
            foreach (self::all() as $item) {
                $data[$item->key] = $item->value;
            }
            return (object)$data;
        });
    }
}
