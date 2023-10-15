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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('state_id')->unsigned();
            $table->bigInteger('country_id')->unsigned();
            $table->enum('type', ['driver', 'drives'])->default('driver');
            $table->string('street');
            $table->string('lga');
            $table->string('state_of_residence');
            $table->string('city_of_residence');
            $table->string('nin_number');
            $table->string('license_number');
            $table->bigInteger('vehicle_type_id')->unsigned();
            $table->string('profile_pic_url');
            $table->string('vehicle_img_url');
            $table->string('license_url');
            $table->enum('status', ['Pending', 'Confirmed', 'Approved', 'Rejected','Failed'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users');
            $table->foreign('state_id')->references('id')->on('states');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->foreign('vehicle_type_id')->references('id')->on('vehicle_types');

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
