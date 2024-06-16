<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Categories
        Category::create([
            'name' => 'Fashion',
            'name_bn' => 'ফ্যাশন',
            'slug' => 'fashion',
            'icon' => '',
            'parent_id' => null,
            'featured' => 1
        ]);

        Category::create([
            'name' => 'Electronics',
            'name_bn' => 'ইলেকট্রনিক্স',
            'slug' => 'electronics',
            'icon' => 'iconoir:electronics-chip',
            'parent_id' => null,
            'featured' => 1
        ]);

        Category::create([
            'name' => 'Home & Garden',
            'name_bn' => 'বাড়ি ও বাগান',
            'slug' => 'home-garden',
            'icon' => 'solar:sofa-bold-duotone',
            'parent_id' => null,
            'featured' => 1
        ]);

        Category::create([
            'name' => 'Health & Beauty',
            'name_bn' => 'স্বাস্থ্য এবং সৌন্দর্য',
            'slug' => 'health-beauty',
            'icon' => 'material-symbols-light:health-and-beauty-sharp',
            'parent_id' => null,
            'featured' => 1
        ]);

        Category::create([
            'name' => 'Toys & Hobbies',
            'name_bn' => 'খেলনা এবং শখ',
            'slug' => 'toys-hobbies',
            'icon' => '',
            'parent_id' => null,
            'featured' => 1
        ]);

        Category::create([
            'name' => 'Pets & Animals',
            'name_bn' => 'পোষা প্রাণী এবং প্রাণী',
            'slug' => 'pets-animals',
            'icon' => '',
            'parent_id' => null,
            'featured' => 1
        ]);


        // Subcategories
        Category::create([
            'name' => 'Men\'s Clothing',
            'name_bn' => 'পুরুষদের পোশাক',
            'slug' => 'mens-clothing',
            'icon' => '',
            'parent_id' => 1,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Women\'s Clothing',
            'name_bn' => 'মহিলাদের পোশাক',
            'slug' => 'womens-clothing',
            'icon' => '',
            'parent_id' => 1,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Phones & Accessories',
            'name_bn' => 'ফোন এবং সংযোগকরণ',
            'slug' => 'phones-accessories',
            'icon' => '',
            'parent_id' => 2,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Computer & Office',
            'name_bn' => 'কম্পিউটার এবং অফিস',
            'slug' => 'computer-office',
            'icon' => '',
            'parent_id' => 2,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Home Textiles',
            'name_bn' => 'হোম টেক্সটাইল',
            'slug' => 'home-textiles',
            'icon' => '',
            'parent_id' => 3,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Kitchen,Dining & Bar',
            'name_bn' => 'রান্নাঘর, ডাইনিং এবং বার',
            'slug' => 'kitchen-dining-bar',
            'icon' => '',
            'parent_id' => 3,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Hair Care & Styling',
            'name_bn' => 'চুলের যত্ন এবং স্টাইলিং',
            'slug' => 'hair-care-styling',
            'icon' => '',
            'parent_id' => 4,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Skin Care',
            'name_bn' => 'ত্বকের যত্ন',
            'slug' => 'skin-care',
            'icon' => '',
            'parent_id' => 4,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Dolls & Stuffed Toys',
            'name_bn' => 'পুতুল এবং স্টাফড টয়স',
            'slug' => 'dolls-stuffed-toys',
            'icon' => '',
            'parent_id' => 5,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Remote Control Toys',
            'name_bn' => 'রিমোট কন্ট্রোল টয়স',
            'slug' => 'remote-control-toys',
            'icon' => '',
            'parent_id' => 5,
            'featured' => 0
        ]);


        // sub-subcategories
        Category::create([
            'name' => 'Shirts',
            'name_bn' => 'শার্ট',
            'slug' => 'shirts',
            'icon' => '',
            'parent_id' => 7,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Dresses',
            'name_bn' => 'পোশাক',
            'slug' => 'dresses',
            'icon' => '',
            'parent_id' => 8,
            'featured' => 0
        ]);

        Category::create([
            'name' => 'Mobile Phones',
            'name_bn' => 'মোবাইল ফোন',
            'slug' => 'mobile-phones',
            'icon' => '',
            'parent_id' => 9,
            'featured' => 0
        ]);
    }
}
