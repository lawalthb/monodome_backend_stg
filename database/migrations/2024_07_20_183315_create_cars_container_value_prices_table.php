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
        Schema::create('cars_container_value_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('min', 32, 2);
            $table->decimal('max', 32, 2);
            $table->decimal('price', 32, 2);
            $table->enum('status', ['active', 'inactive'])->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cars_container_value_prices');
    }
};