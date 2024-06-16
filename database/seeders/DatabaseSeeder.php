<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Artisan;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {

        // Artisan::call('migrate:fresh', ['--seed' => true,]);
        Artisan::call('config:clear');
        Artisan::call('cache:clear');
        Artisan::call('route:cache');
        Artisan::call('view:clear');
        Artisan::call('config:cache');

//        Artisan::call('passport:install', ['--force' => true,]);
        Artisan::call('passport:keys', ['--force' => true,]);
        Artisan::call('optimize:clear');

        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        $this->call([
            SettingSeeder::class,
            CoreSettingSeeder::class,
            SocialAuthSettingSeeder::class,
            RolesAndPermissionDatabaseSeeder::class,
            AdminSeeder::class,


            UserSeeder::class,
            BrandSeeder::class,
            TagSeeder::class,
            CategorySeeder::class,
            WarrantyTypeSeeder::class,
            ProductSeeder::class,
            ProductRatingSeeder::class,
            DummyDataSeeder::class,
        ]);
    }
}
