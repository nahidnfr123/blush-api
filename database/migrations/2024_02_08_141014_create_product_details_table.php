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
        Schema::create('product_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('product_id')->constrained()->onDelete('cascade');
            $table->longText('description')->nullable();
            $table->longText('description_bn')->nullable();
            $table->longText('content')->nullable();
            $table->longText('specification')->nullable();

            $table->string('origin')->nullable();

            $table->foreignId('warranty_type_id')->nullable()->constrained()->onDelete('set null');
            $table->string('warranty_duration')->nullable();
            $table->string('warranty_policy')->nullable();

            $table->string('weight')->nullable();
            $table->string('dimensions')->nullable(); // length/width/height
            $table->boolean('handel_with_care')->default(false);

            $table->string('sku_code')->nullable();
            $table->string('size')->nullable();
            $table->string('color')->nullable();
            $table->string('material')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_details');
    }
};
