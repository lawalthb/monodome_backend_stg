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
        Schema::create('driver_mangers', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->unsignedBigInteger('user_id'); // Foreign key to link the guarantor with an agent
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->string('lga')->nullable();
            $table->string('business_name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('street')->nullable();
            $table->string('state_of_residence')->nullable();
            $table->string('city_of_residence')->nullable();
            $table->string('office_front_image')->nullable();
            $table->string('inside_office_image')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('registration_documents')->nullable();
            $table->string('cac_certificate')->nullable();
            $table->string('company_name')->nullable();
            $table->string('company_address')->nullable();
            $table->string('company_state')->nullable();
            $table->string('company_lga')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Approved', 'Rejected','Failed'])->default('Pending');
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
        Schema::dropIfExists('driver_mangers');
    }
};
