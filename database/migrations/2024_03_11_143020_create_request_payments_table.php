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
        Schema::create('request_payments', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id')->nullable();
            $table->unsignedBigInteger('receiver_id')->nullable();
            $table->unsignedBigInteger('currency_id')->nullable();
            $table->decimal('amount', 20, 8)->default(0.00000000);
            $table->decimal('accept_amount', 20, 8)->default(0.00000000);
            $table->string('email')->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('purpose')->nullable();
            $table->text('comment')->nullable();
            $table->enum('status', ['Pending','Success','Refund','Blocked'])->default('Pending')->comment('Pending, Success, Refund, Blocked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_payments');
    }
};
