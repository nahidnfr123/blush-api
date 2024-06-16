<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('product_variants', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g. "Color", "size" | "Ram", "Storage"
            $table->string('value'); // e.g. "Red", "XL" | "8GB", "256GB"
            $table->string('sku_code')->nullable(); // Red-XL
            $table->double('original_price', 10, 2)->nullable();
            $table->double('selling_price', 10, 2)->nullable();
            $table->double('discounted_price', 10, 2)->nullable();
            $table->double('discount_percentage')->nullable(); // e.g. 10% off
            $table->integer('quantity')->default(0);
            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);
            $table->string('thumbnail')->nullable();
            $table->integer('order')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_variants');
    }
};
