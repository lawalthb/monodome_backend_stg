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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('user_id'); // Foreign key to link the guarantor with an agent
            $table->unsignedBigInteger('state_id');
            $table->string('street')->nullable();
            $table->string('lga')->nullable();
            $table->string('state_of_residence')->nullable();
            $table->string('city_of_residence')->nullable();
            $table->string('number_of_drivers')->nullable();
            $table->string('number_of_trucks')->nullable();
            $table->string('truck_type')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('company_logo')->nullable();
            $table->string('company_name')->nullable();
            $table->string('registration_documents')->nullable();
            $table->enum('status', ['Waiting', 'Confirmed', 'Rejected', 'Banned', 'Cancelled'])->default('Waiting');
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
        Schema::dropIfExists('companies');
    }
};
