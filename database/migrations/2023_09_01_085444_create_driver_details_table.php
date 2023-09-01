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
            $table->bigInteger('user_id')->index('user_id');
            $table->string('name');
            $table->string('phone_number');
            $table->string('street');
            $table->unsignedBigInteger('state_id');
            $table->unsignedBigInteger('city_id');
            $table->string('lga');
            $table->string('state_of_resident');
            $table->string('city_of_resident');
            $table->string('nin_number');
            $table->string('license_number');
            $table->unsignedBigInteger('vehicle_type_id');
            $table->string('profile_pic_url');
            $table->string('vehicle_img_url');
            $table->string('licence_url');
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
