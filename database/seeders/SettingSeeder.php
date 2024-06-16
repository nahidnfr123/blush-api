<?php

namespace Database\Seeders;

use App\Models\Setting;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Model::unguard();

        // $this->call("OthersTableSeeder");

        Setting::firstOrCreate([
            'site_name' => 'GG Sports',
            'site_description' => 'GG Sports',
            'site_keywords' => 'GG Sports',
            'site_email' => 'gg@example.com',
            'site_phone' => '0123456789',
            'site_address' => 'Dhaka, Bangladesh',
            'site_logo' => '/uploads/default/site/643343.png',
        ]);
    }
}
