<?php

namespace App\Models;

use App\Enums\GuardEnums;
use App\Scopes\AdminWithScope;
use App\Traits\FormatedDateTrait;
use App\Traits\HasCreatorTrait;
use App\Traits\TrashScope;
use Illuminate\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

//use Laravel\Sanctum\HasApiTokens;
use Laravel\Passport\HasApiTokens;
use NahidFerdous\Searchable\Searchable;
use Spatie\Permission\Traits\HasRoles;

class Admin extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, MustVerifyEmail, SoftDeletes, HasRoles;
    use TrashScope, Searchable, FormatedDateTrait, HasCreatorTrait;

    protected $guard = GuardEnums::Admin->value;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'mobile',
        'email_verified_at',
        'mobile_verified_at',
        'avatar',
        'password',
        'status',
        'is_super_admin',
        'created_by',
        'updated_by',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'mobile_verified_at' => 'datetime',
        'password' => 'hashed',
    ];


    protected static function booted(): void
    {
        static::addGlobalScope(new AdminWithScope);
    }

    public function getAvatarAttribute($value): ?string
    {
        return $value ? asset('/storage/' . $value) : null;
    }

    public function adminSetting(): \Illuminate\Database\Eloquent\Relations\HasOne
    {
        return $this->hasOne(AdminSetting::class);
    }

    public function getTrashModeAttribute(): bool
    {
        return $this->adminSetting->trash_mode ?? false;
    }
}
