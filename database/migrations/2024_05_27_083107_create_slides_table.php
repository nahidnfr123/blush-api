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
        Schema::create('slides', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('title_bn')->nullable()->index();

            $table->string('text_color')->default('white');

            $table->string('subtitle')->nullable();
            $table->string('subtitle_bn')->nullable()->index();

            $table->string('image');

            $table->string('button_text')->nullable();
            $table->string('button_text_bn')->nullable()->index();

            $table->string('link')->nullable();

            $table->integer('order')->default(0);
            $table->boolean('active')->default(true);

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
        Schema::dropIfExists('home_slides');
    }
};
