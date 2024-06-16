<?php

use App\Enums\ActiveInactiveStatus;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('grid_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('grid_id')->constrained()->cascadeOnDelete();
            $table->string('title')->nullable()->index();
            $table->string('title_bn')->nullable()->index();
            $table->string('subtitle')->nullable();
            $table->string('subtitle_bn')->nullable()->index();
            $table->string('button_text')->nullable();
            $table->string('button_text_bn')->nullable();
            $table->string('url')->nullable();
            $table->string('image')->nullable();
            $table->integer('order')->default(0);
            $table->string('class_name')->default('col-span-1')->nullable();
            $table->string('height')->default('160');
            $table->string('active')->default(ActiveInactiveStatus::Active);


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
        Schema::dropIfExists('home_product_grid_items');
    }
};
