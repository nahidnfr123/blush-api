<?php

namespace Database\Seeders;

use App\Models\SocialAuthSetting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SocialAuthSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        SocialAuthSetting::firstOrCreate([
            'provider' => 'facebook',
        ], [
            'slug' => 'facebook',
            'provider' => 'facebook',
            'client_id' => env('FACEBOOK_CLIENT_ID'),
            'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
            'redirect_url' => env('FACEBOOK_CALLBACK_URL'),
            'logo' => '/uploads/images/social_auth/facebook_logo_1696577796.png',
        ]);

        SocialAuthSetting::firstOrCreate([
            'provider' => 'google',
        ], [
            'slug' => 'google',
            'provider' => 'google',
            'client_id' => env('GOOGLE_CLIENT_ID'),
            'client_secret' => env('GOOGLE_CLIENT_SECRET'),
            'redirect_url' => env('GOOGLE_CALLBACK_URL'),
            'logo' => '/uploads/images/social_auth/google_logo_1696577853.png'
        ]);

        SocialAuthSetting::firstOrCreate([
            'provider' => 'twitter',
        ], [
            'slug' => 'twitter',
            'provider' => 'twitter',
            'client_id' => env('TWITTER_CLIENT_ID'),
            'client_secret' => env('TWITTER_CLIENT_SECRET'),
            'redirect_url' => env('TWITTER_CALLBACK_URL'),
            'logo' => ''
        ]);

        SocialAuthSetting::firstOrCreate([
            'provider' => 'linkedin',
        ], [
            'slug' => 'linkedin',
            'provider' => 'linkedin',
            'client_id' => env('LINKEDIN_CLIENT_ID'),
            'client_secret' => env('LINKEDIN_CLIENT_SECRET'),
            'redirect_url' => env('LINKEDIN_CALLBACK_URL'),
            'logo' => '/uploads/images/social_auth/linkedin_logo_1696578006.png'
        ]);

        SocialAuthSetting::firstOrCreate([
            'provider' => 'github',
        ], [
            'slug' => 'github',
            'provider' => 'github',
            'client_id' => env('GITHUB_CLIENT_ID'),
            'client_secret' => env('GITHUB_CLIENT_SECRET'),
            'redirect_url' => env('GITHUB_CALLBACK_URL'),
            'logo' => '/uploads/images/social_auth/github_logo_1696577959.png'
        ]);
    }
}
