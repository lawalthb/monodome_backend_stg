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
        Schema::create('order_route_plans', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('acceptable_id');
            $table->string('order_no');
            $table->json('data')->nullable();
            $table->string('name')->nullable();
            $table->integer('position')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Processing','Waiting','out_for_delivery','canceled','returned','Delivered','awaiting_confirmation'])->default('out_for_delivery');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_route_plans');
    }
};
