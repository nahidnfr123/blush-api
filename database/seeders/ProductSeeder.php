<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $attributes = ['color', 'size', 'material', 'ram', 'storage', 'weight'];
        foreach ($attributes as $attribute) {
            \App\Models\VariantAttribute::create([
                'name' => $attribute,
            ]);
        }

        $options = [
            'color' => ['Red', 'Green', 'Blue', 'Black', 'White'],
            'size' => ['SM', 'M', 'L', 'XL', 'XXL'],
            'material' => ['Cotton', 'Polyester', 'Wool', 'Silk', 'Leather', 'Plastic', 'Iron'],
            'ram' => ['2GB', '4GB', '8GB', '16GB', '32GB', '64GB'],
            'storage' => ['128GB', '256GB', '512GB', '1TB', '2TB'],
            'weight' => ['100g', '200g', '300g', '400g', '500g', '600g', '700g', '800g', '900g', '1kg', '2kg', '3kg', '4kg', '5kg', '6kg', '7kg', '8kg', '9kg', '10kg'],
        ];
        foreach ($options as $attr => $values) {
            $attribute = \App\Models\VariantAttribute::where('name', $attr)->first();
            foreach ($values as $value) {
                $attribute->variantAttributeValues()->create([
                    'value' => $value,
                ]);
            }
        }


        for ($i = 1; $i <= 25; $i++) {
            $this->generateProduct($i);
        }
    }

    function generateProduct($index): void
    {
        $product = Product::create([
            'brand_id' => rand(1, 7),
            'name' => 'Product ' . $index,
            'name_bn' => 'প্রোডাক্ট ' . $index,
            'slug' => 'product-' . $index,
            'thumbnail' => 'uploads/default/products/' . $index . '.jpg',
            'video' => 'Product ' . $index . ' Video',
            'original_price' => 80 + $index,
            'selling_price' => 120 + $index,
            'discounted_price' => 100 + $index,
            'discount_percentage' => 20 + $index,
            'featured' => true,
            'active' => true,
            'quantity' => 100 + $index,
            'views' => 100 + $index,
            'sales' => 100 + $index,
            'published_at' => now(),
            'has_variant' => false,
            'order' => $index,
            'created_by' => 1,
            'updated_by' => 1,
        ]);
        $product->categories()->attach(rand(1, 10));
        $product->tags()->attach(rand(1, 10));
        $product->productDetail()->create([
            'description' => 'Product ' . $index . ' Description',
            'content' => 'Product ' . $index . ' Content',
            'specification' => 'Product ' . $index . ' Specification',
            'origin' => 'Product ' . $index . ' Origin',
            'weight' => 'Product ' . $index . ' Weight',
            'dimensions' => 'Product ' . $index . ' Dimensions',
            'size' => 'Product ' . $index . ' Size',
            'color' => 'Product ' . $index . ' Color',
            'material' => 'Product ' . $index . ' Material',
        ]);

    }
}
