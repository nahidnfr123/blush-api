<?php

namespace App\Traits;

use App\Models\Admin;

trait HasCreatorTrait
{

    public static function bootHasCreatorTrait(): void
    {
        static::creating(function ($model) {
            $model->created_by = auth()->id();
        });

        static::updating(function ($model) {
            $model->updated_by = auth()->id();
        });
    }

    public function createdBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'created_by')
            ->select('id', 'name', 'username', 'email', 'avatar');
    }

    public function updatedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
    {
        return $this->belongsTo(Admin::class, 'updated_by')
            ->select('id', 'name', 'username', 'email', 'avatar');
    }

//    public function deletedBy(): \Illuminate\Database\Eloquent\Relations\BelongsTo
//    {
//        return $this->belongsTo(Admin::class, 'deleted_by')
//            ->select('id', 'name', 'username', 'email', 'avatar');
//    }

    public function scopeCreatedBy($query, $id = null)
    {
        return $query->where('created_by', $id);
    }
}
