<?php

namespace Database\Seeders;

use App\Models\Brand;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BrandSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Brand::create([
      'name' => 'Apple',
      'slug' => 'apple',
      'description' => 'Apple Inc. is an American multinational technology company that specializes in consumer electronics, computer software, and online services.',
      'logo' => 'uploads/default/brands/apple.png',
    ]);

    Brand::create([
      'name' => 'Samsung',
      'slug' => 'samsung',
      'description' => 'Samsung Electronics Co., Ltd. is a South Korean multinational electronics company headquartered in the Yeongtong District of Suwon.',
      'logo' => 'uploads/default/brands/samsung.png',
    ]);

    Brand::create([
      'name' => 'Huawei',
      'slug' => 'huawei',
      'description' => 'Huawei Technologies Co., Ltd. is a Chinese multinational technology company.',
      'logo' => 'uploads/default/brands/huawei.png',
    ]);

    Brand::create([
      'name' => 'Xiaomi',
      'slug' => 'xiaomi',
      'description' => 'Xiaomi Corporation is a Chinese multinational electronics company founded in April 2010 and headquartered in Beijing.',
      'logo' => 'uploads/default/brands/xiaomi.png',
    ]);

    Brand::create([
      'name' => 'Maybelline',
      'slug' => 'maybelline',
      'description' => 'Maybelline is a major American makeup brand sold worldwide and a subsidiary of French cosmetics company L\'Oréal.',
      'logo' => 'uploads/default/brands/maybelline.png',
    ]);

    Brand::create([
      'name' => 'L\'Oréal',
      'slug' => 'loreal',
      'description' => 'L\'Oréal S.A. is a French personal care company headquartered in Clichy, Hauts-de-Seine with a registered office in Paris.',
      'logo' => 'uploads/default/brands/loreal.png',
    ]);

    Brand::create([
      'name' => 'MAC Cosmetics',
      'slug' => 'mac-cosmetics',
      'description' => 'MAC Cosmetics, stylized as M·A·C, is a Canadian cosmetics manufacturer founded in Toronto in 1984 by Frank Toskan and Frank Angelo.',
      'logo' => 'uploads/default/brands/mac-cosmetics.png',
    ]);

  }
}
