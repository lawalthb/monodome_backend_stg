<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('order_price_settings', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('level')->comment('Possible values: level_one, level_two, level_three');
            $table->json('percentage')->comment('JSON format for percentage allocations');
            $table->enum('status', ['active', 'inactive'])->default('active')->comment('Status of this setting');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_price_settings');
    }
};
