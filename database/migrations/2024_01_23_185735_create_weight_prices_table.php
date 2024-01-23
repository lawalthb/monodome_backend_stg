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
            $table->decimal('min_weight', 5, 2);
            $table->decimal('max_weight', 5, 2);
            $table->unsignedBigInteger('load_type_id');
            $table->integer('price');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('load_type_id')->references('id')->on('load_types');
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
