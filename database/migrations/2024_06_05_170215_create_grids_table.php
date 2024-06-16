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
        Schema::create('grids', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable()->index();
            $table->string('slug')->nullable()->index();
            $table->string('class_name')->default('grid-cols-3 gap-4');
            $table->string('grid_id')->nullable();
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
        Schema::dropIfExists('home_product_grids');
    }
};
