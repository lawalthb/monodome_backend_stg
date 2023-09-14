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
        Schema::create('cards', function (Blueprint $table) {
            $table->id();
            $table->uuid();
            $table->unsignedBigInteger('user_id');
            $table->string('card_number', 255);
            $table->string('cvv', 200)->nullable();
            $table->string('auth_token', 200)->nullable();
            $table->string('name_on_card', 255)->nullable();
            $table->string('expiry_month', 200);
            $table->string('expiry_year', 200);
            $table->string('type', 20)->comment('credit, debit')->default('debit');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cards');
    }
};
