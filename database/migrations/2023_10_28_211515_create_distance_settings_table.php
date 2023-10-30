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
        Schema::create('distance_settings', function (Blueprint $table) {
            $table->id();
            $table->string('weight');
            $table->string('from');
            $table->string('to');
            $table->string('price');
            $table->unsignedBigInteger('loadable_id'); // Foreign key to the associated load
            $table->string('loadable_type'); // Type of load (e.g., 'load_packages', 'load_specialized', etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('distance_settings');
    }
};
