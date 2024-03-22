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
        Schema::create('trucks', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('business_name')->nullable();
            $table->string('phone_number')->unique();
            $table->string('street')->nullable();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('driver_user_id');
            $table->unsignedBigInteger('country_id')->nullable();
            $table->unsignedBigInteger('state_id');
            $table->string('lga')->nullable();
            $table->string('truck_name')->nullable();
            $table->string('truck_type')->nullable();
            $table->string('truck_location')->nullable();
            $table->string('truck_make')->nullable();
            $table->string('plate_number')->nullable();
            $table->string('cac_number')->nullable();
            $table->text('truck_description')->nullable();
            $table->string('profile_picture')->nullable();
            $table->string('outside_truck_picture')->nullable();
            $table->string('truck_document')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Approved', 'Rejected','Failed'])->default('Pending');

            $table->timestamps();


            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('driver_user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trucks');
    }
};
