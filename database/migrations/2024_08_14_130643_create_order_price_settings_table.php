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
            $table->string('slug')->comment('Possible values: driver, agent, driver_manager, truck');
            $table->integer('price')->comment('percentage');
            $table->boolean('is_default')->default(false);
            $table->string('status')->default('active')->comment('active , inActive');
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
