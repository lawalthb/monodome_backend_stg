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
        Schema::create('invoices', function (Blueprint $table) {
            $table->id();
            $table->string('user_id', 100);
            $table->string('order_no', 200);
            $table->string('delivery_from', 50);
            $table->string('delivery_to', 15);
            $table->string('sender', 20);
            $table->string('receiver', 20);
            $table->integer('delivery_price');
            $table->tinyInteger('sent')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('invoices');
    }
};
