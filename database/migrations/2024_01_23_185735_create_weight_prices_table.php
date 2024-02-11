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
        Schema::create('weight_prices', function (Blueprint $table) {
            $table->id();
            $table->decimal('min_weight');
            $table->decimal('max_weight');
            $table->integer('load_type_id');
            $table->integer('price');
            $table->string('vehicle_description')->nullable();
            // $table->string('status')->default('Active');
            $table->enum('status', ['Active', 'inActive'])->default('Active');
            $table->timestamps();

            // Foreign key constraint
            // $table->foreign('load_type_id')->references('id')->on('load_types');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('weight_prices');
    }
};
