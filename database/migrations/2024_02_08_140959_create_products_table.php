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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('brand_id')->nullable()->constrained()->onDelete('set null');

            $table->string('name')->index();
            $table->string('name_bn')->nullable()->index();
            $table->string('slug')->unique()->index();

            $table->string('thumbnail')->nullable();
            $table->string('video')->nullable();

            $table->double('original_price', 10, 2); // purchase price
            $table->double('selling_price', 10, 2);
            $table->double('discounted_price', 10, 2)->nullable();
            $table->dateTime('discount_start_at')->nullable();
            $table->dateTime('discount_end_at')->nullable();
            $table->double('discount_percentage', 10, 2)->nullable();

            $table->boolean('featured')->default(false);
            $table->boolean('active')->default(true);

            $table->integer('quantity')->default(0);

            $table->integer('views')->default(0);
            $table->integer('sales')->default(0);
            $table->double('average_rating', 2, 1)->default(0);
            $table->integer('rating_count')->default(0);

            $table->timestamp('published_at')->default(now());
            $table->boolean('has_variant')->default(false);
            $table->boolean('draft')->default(false);
            $table->integer('order')->default(0);

            $table->foreignId('created_by')->nullable()->constrained('admins')->nullOnDelete();
            $table->foreignId('updated_by')->nullable()->constrained('admins')->nullOnDelete();

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
