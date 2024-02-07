<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('drivers', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->unsignedBigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('state_id');
            $table->enum('type', ['driver', 'drives'])->default('driver');
            $table->enum('have_motor', ['Yes', 'No'])->default('Yes');
            $table->string('street');
            $table->string('lga');
            $table->string('nin_number');
            $table->string('license_number');
            $table->string('proof_of_license');
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->string('profile_picture');
            $table->enum('status', ['Pending', 'Confirmed', 'Approved', 'Rejected','Failed'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('driver_details');
    }
};
