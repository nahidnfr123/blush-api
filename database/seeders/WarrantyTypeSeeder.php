<?php

namespace Database\Seeders;

use App\Models\WarrantyType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class WarrantyTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        WarrantyType::create(['name' => 'International Manufacturer Warranty',]);
        WarrantyType::create(['name' => 'Non-local Warranty',]);
        WarrantyType::create(['name' => 'No Warranty',]);
        WarrantyType::create(['name' => 'Local Seller Warranty',]);
        WarrantyType::create(['name' => 'International Seller Warranty',]);
    }
}
