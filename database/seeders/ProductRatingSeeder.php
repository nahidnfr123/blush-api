<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\ProductRating;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductRatingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 1; $i <= 10; $i++) {
            ProductRating::updateOrCreate([
                'product_id' => 1,
                'user_id' => $i,
            ], [
                'rating' => rand(1, 5),
                'review' => 'This is a review.',
            ]);
        }

        $product = Product::find(1);
        $product->average_rating = ProductRating::where('product_id', 1)->avg('rating');
        $product->rating_count = ProductRating::where('product_id', 1)->count();
        $product->save();
    }
}
