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
        Schema::create('shipping_companies', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('user_id'); // Foreign key to link the guarantor with an agent
            $table->unsignedBigInteger('state_id');
            $table->string('street')->nullable();
            $table->string('lga')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('nin_number')->nullable();
            $table->string('profile_picture')->nullable();
            $table->enum('status', ['Waiting', 'confirmed', 'Rejected', 'Banned'])->default('Waiting');
            $table->timestamps();
            $table->softDeletes();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_companies');
    }
};
