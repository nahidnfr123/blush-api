<?php

namespace Database\Seeders;

use App\Enums\StatusEnums;
use App\Models\Admin;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $userSuperAdmin = Admin::create([
            'name' => 'Developer',
            'email' => 'dev@dev.com',
            'mobile' => '01810122175',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'status' => StatusEnums::Active,
            'is_super_admin' => true,
        ]);
        $userSuperAdmin->adminSetting()->create();
        $userSuperAdmin->assignRole(['developer', 'super admin', 'admin']);


        $userSuperAdmin = Admin::create([
            'name' => 'Super Admin',
            'email' => 'super_admin@admin.com',
            'mobile' => '01111111111',
            'password' => Hash::make('admin123'),
            'email_verified_at' => now(),
            'status' => StatusEnums::Active,
            'is_super_admin' => true,
        ]);
        $userSuperAdmin->adminSetting()->create();
        $userSuperAdmin->assignRole(['super admin', 'admin']);

        $user = Admin::create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'mobile' => '01234567890',
            'password' => Hash::make('password'),
            'email_verified_at' => now(),
            'status' => StatusEnums::Active,
            'is_super_admin' => false,
        ]);
        $user->adminSetting()->create();
        $user->assignRole(['admin']);

    }
}
