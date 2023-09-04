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
        Schema::create('driver_details', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid');
            $table->bigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('state_id');
            // $table->unsignedBigInteger('city_id');
            $table->unsignedBigInteger('country_id');
            $table->enum('type', ['driver', 'drives'])->default('driver');
            $table->string('street');
            $table->string('lga');
            $table->string('state_of_residence');
            $table->string('city_of_residence');
            $table->string('nin_number');
            $table->string('license_number');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->string('profile_pic_url');
            $table->string('vehicle_img_url');
            $table->string('license_url');
            $table->enum('status', ['Pending', 'Approved', 'Rejected'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();
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
