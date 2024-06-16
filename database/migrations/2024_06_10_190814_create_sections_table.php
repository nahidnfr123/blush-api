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
        Schema::create('sections', function (Blueprint $table) {
            $table->id();
            $table->foreignId('page_id')->constrained()->cascadeOnDelete();
//            $table->morphs('sectionable');
            $table->string('title')->nullable()->index();
            $table->string('title_bn')->nullable()->index();
            $table->string('slug')->nullable()->index();
            $table->longText('content')->nullable();
            $table->string('view_more_url')->nullable();
            $table->string('api_url')->nullable();
            $table->string('class_name')->default('col-span-4');
            $table->string('type')->default(\App\Enums\PageContentTypeEnums::Content);
            $table->boolean('autoplay')->default(false);
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
        Schema::dropIfExists('sections');
    }
};
