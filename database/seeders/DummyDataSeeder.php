<?php

namespace Database\Seeders;

use App\Enums\PageContentTypeEnums;
use App\Models\Grid;
use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DummyDataSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pageGrid = Grid::create([
            'title' => 'Home page welcome grid',
            'slug' => 'home-page-welcome-grid',
            'grid_id' => 'grid_1',
            'class_name' => 'grid-cols-4 grid-rows-5 gap-4',
        ]);

        $pageGrid->gridItems()->createMany([
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/1.jpg',
                'class_name' => 'text-white',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/2.jpg',
                'class_name' => 'col-span-2 row-span-2 text-white',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/3.jpg',
                'class_name' => ' text-white',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/4.jpg',
                'class_name' => 'row-span-3',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/5.jpg',
                'class_name' => '',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/10.jpg',
                'class_name' => '',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/7.jpg',
                'class_name' => 'text-white',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/8.jpg',
                'class_name' => 'row-span-2',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/9.jpg',
                'class_name' => 'col-span-2',
            ],
            [
                'title' => 'Product 1',
                'title_bn' => 'প্রোডাক্ট ১',
                'subtitle' => 'Product 1 subtitle',
                'subtitle_bn' => 'প্রোডাক্ট ১ সাবটাইটেল',
                'button_text' => 'View Details',
                'button_text_bn' => 'বিস্তারিত দেখুন',
                'url' => 'product-1',
                'image' => 'uploads/default/products/10.jpg',
                'class_name' => 'col-span-4',
            ],
        ]);

        $page = Page::create([
            'title' => 'Home'
        ]);

        $page->sections()->create([
            'class_name' => '',
            'type' => PageContentTypeEnums::Grid,
            'active' => true,
            'order' => 999999,
            'api_url' => '/admin/grids/' . $pageGrid->id,

//            'sectionable_id' => Grid::first()->id,
//            'sectionable_type' => Grid::class,
        ]);
    }
}
