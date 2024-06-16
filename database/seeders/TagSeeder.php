<?php

namespace Database\Seeders;

use App\Models\Tag;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
  /**
   * Run the database seeds.
   */
  public function run(): void
  {
    Tag::create([
      'name' => 'Electronics',
      'slug' => 'electronics',
    ]);

    Tag::create([
      'name' => 'Fashion',
      'slug' => 'fashion',
    ]);

    Tag::create([
      'name' => 'Health',
      'slug' => 'health',
    ]);

    Tag::create([
      'name' => 'Shoes',
      'slug' => 'shoes',
    ]);

    Tag::create([
      'name' => 'Clothes',
      'slug' => 'clothes',
    ]);

    Tag::create([
      'name' => 'Beauty',
      'slug' => 'beauty',
    ]);

    Tag::create([
      'name' => 'phone',
      'slug' => 'phone',
    ]);

    Tag::create([
      'name' => 'laptop',
      'slug' => 'laptop',
    ]);

    Tag::create([
      'name' => 'camera',
      'slug' => 'camera',
    ]);

    Tag::create([
      'name' => 'watch',
      'slug' => 'watch',
    ]);

    Tag::create([
      'name' => 'headphone',
      'slug' => 'headphone',
    ]);

    Tag::create([
      'name' => 'speaker',
      'slug' => 'speaker',
    ]);

    Tag::create([
      'name' => 'accessories',
      'slug' => 'accessories',
    ]);

    Tag::create([
      'name' => 'jewelry',
      'slug' => 'jewelry',
    ]);

    Tag::create([
      'name' => 'bag',
      'slug' => 'bag',
    ]);

    Tag::create([
      'name' => 'wallet',
      'slug' => 'wallet',
    ]);

    Tag::create([
      'name' => 'belt',
      'slug' => 'belt',
    ]);

    Tag::create([
      'name' => 'sandal',
      'slug' => 'sandal',
    ]);

    Tag::create([
      'name' => 'slipper',
      'slug' => 'slipper',
    ]);

    Tag::create([
      'name' => 't-shirt',
      'slug' => 't-shirt',
    ]);

    Tag::create([
      'name' => 'shirt',
      'slug' => 'shirt',
    ]);

    Tag::create([
      'name' => 'jeans',
      'slug' => 'jeans',
    ]);

    Tag::create([
      'name' => 'pant',
      'slug' => 'pant',
    ]);

    Tag::create([
      'name' => 'shorts',
      'slug' => 'shorts',
    ]);

    Tag::create([
      'name' => 'makeup',
      'slug' => 'makeup',
    ]);

    Tag::create([
      'name' => 'skincare',
      'slug' => 'skincare',
    ]);

    Tag::create([
      'name' => 'haircare',
      'slug' => 'haircare',
    ]);

    Tag::create([
      'name' => 'personal care',
      'slug' => 'personal-care',
    ]);

    Tag::create([
      'name' => 'supplement',
      'slug' => 'supplement',
    ]);

    Tag::create([
      'name' => 'vitamin',
      'slug' => 'vitamin',
    ]);

    Tag::create([
      'name' => 'medicine',
      'slug' => 'medicine',
    ]);

    Tag::create([
      'name' => 'first aid',
      'slug' => 'first-aid',
    ]);

    Tag::create([
      'name' => 'medical equipment',
      'slug' => 'medical-equipment',
    ]);

    Tag::create([
      'name' => 'medical device',
      'slug' => 'medical-device',
    ]);

    Tag::create([
      'name' => 'medical supplies',
      'slug' => 'medical-supplies',
    ]);

    Tag::create([
      'name' => 'medical instrument',
      'slug' => 'medical-instrument',
    ]);

    Tag::create([
      'name' => 'medical tool',
      'slug' => 'medical-tool',
    ]);

    Tag::create([
      'name' => 'medical product',
      'slug' => 'medical-product',
    ]);

    Tag::create([
      'name' => 'medical material',
      'slug' => 'medical-material',
    ]);
  }
}
