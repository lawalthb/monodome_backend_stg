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
            $table->string('min')->comment('in KM');
            $table->string('max')->comment('in KM');
            $table->string('price');
            $table->unsignedBigInteger('loadable_id');
            $table->string('loadable_type');
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
