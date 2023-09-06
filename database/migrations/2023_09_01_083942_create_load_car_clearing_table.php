<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

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
            $table->string('uuid')->default(Str::uuid()->toString());
            $table->bigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('load_type_id');
            $table->string('load_type_name')->default('car-clearing');
            $table->integer('departure_country');
            $table->integer('destination_country');
            $table->integer('car_type');
            $table->string('car_model', 30)->nullable();
            $table->string('car_value', 30)->nullable();
            $table->year('car_year');
            $table->unsignedBigInteger('document');
            $table->text('comment')->nullable();
            $table->enum('is_final', ['Yes', 'No'])->default('No');
            $table->string('deliver_from_city', 20)->nullable();
            $table->string('deliver_to_city', 20)->nullable();
            $table->string('receiver_name', 30)->nullable();
            $table->string('phone', 30)->nullable();
            $table->string('zip_code', 30)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('street', 30)->nullable();
            $table->text('add_info')->nullable();
            // $table->bigInteger('load_board_id')->index('load_board_id');
            $table->enum('status', ['Pending', 'Approved', 'Failed'])->default('Pending');
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
