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
        Schema::create('agents', function (Blueprint $table) {
        $table->id();
        $table->string('uuid');
        $table->string('agent_code');
        $table->unsignedBigInteger('user_id')->index('user_id');
        $table->unsignedBigInteger('country_id')->nullable();
        $table->unsignedBigInteger('state_id');
        $table->string('street')->nullable();
        // $table->enum('status', ['Active', 'Inactive'])->default('Active');
        $table->string('lga')->nullable();
        $table->string('business_name')->nullable();
        $table->string('phone_number')->nullable();
        $table->string('state_of_residence')->nullable();
        $table->string('city_of_residence')->nullable();
        $table->string('store_front_image')->nullable();
        $table->string('inside_store_image')->nullable();
        $table->string('registration_documents')->nullable();
        $table->enum('status', ['Pending', 'Confirmed', 'Rejected','Failed'])->default('Pending');
        $table->timestamps();
        $table->softDeletes();
        $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
        $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
    });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
