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
        Schema::create('load_car_clearing', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->unsignedBigInteger('load_type_id');
            $table->string('load_type_type');
            $table->integer('departure_country');
            $table->integer('destination_country');
            $table->integer('cartype');
            $table->string('car_model', 30)->nullable();
            $table->bigInteger('document_id');
            $table->string('car_value', 30)->nullable();
            $table->year('car_year');
            $table->text('comment')->nullable();
            $table->enum('is_final', ['Yes', 'No'])->default('No');
            $table->string('deliver_from_city', 20)->nullable();
            $table->string('deliver_to_city', 20)->nullable();
            $table->string('receiver_name', 30)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('zipcode', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('street', 30)->nullable();
            $table->text('add_info')->nullable();
            $table->bigInteger('loadboard_id')->index('loadboard_id');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('load_car_clearing');
    }
};