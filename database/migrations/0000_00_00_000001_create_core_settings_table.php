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
//        Schema::create('core_settings', function (Blueprint $table) {
//            $table->id();
//            $table->boolean('maintenance_mode')->default(false);
//            // $table->boolean('trash_mode')->default(false);
//            $table->boolean('always_upto_date')->default(false);
//            $table->double('developer_percentage', 8, 2)->default(2);
//
//            $table->string('locale')->default('en');
//            $table->string('timezone')->default('Asia/Dhaka');
//            $table->string('currency_name')->default('Bangladeshi Taka');
//            $table->string('currency_code')->default('bdt');
//            $table->string('currency_symbol')->default('৳');
//            $table->timestamps();
//        });

        Schema::create('core_settings', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('group')->unique()->nullable();
            $table->string('value')->nullable();
            $table->json('validator')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shop_settings');
    }
};
