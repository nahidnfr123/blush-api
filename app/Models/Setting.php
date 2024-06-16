<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        'site_name',
        'site_description',
        'site_keywords',
        'site_email',
        'site_phone',
        'site_address',
        'site_logo',
        'site_favicon',
        'facebook_url',
        'twitter_url',
        'linkedin_url',
        'youtube_url',
        'instagram_url',
        'whatsapp_url',
    ];

    public static function boot()
    {
        parent::boot();

        static::updating(function () {
            cache()->forget('settings');
        });

        static::creating(function () {
            cache()->forget('settings');
        });
    }

    public function getSiteLogoAttribute(): string|null
    {
        return $this->attributes['site_logo'] ? asset('/storage/' . $this->attributes['site_logo']) : null;
        // default logo asset('assets/images/logo.png')
    }

    public function getSiteFaviconAttribute(): string|null
    {
        return $this->attributes['site_favicon'] ? asset('/storage/' . $this->attributes['site_favicon']) : null;
        // default logo asset('assets/images/logo.png')
    }
}
