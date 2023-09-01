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
        Schema::create('load_container', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->integer('department_country');
            $table->integer('destination_country');
            $table->string('height', 10)->nullable();
            $table->string('carrier', 10)->nullable();
            $table->bigInteger('document_id');
            $table->string('container_value', 20)->nullable();
            $table->text('content_description')->nullable();
            $table->string('is_final', 20)->default('No');
            $table->string('deliver_from_city', 20)->nullable();
            $table->string('deliver_to_city', 20)->nullable();
            $table->string('receiver_name', 20)->nullable();
            $table->string('phone', 20)->nullable();
            $table->string('zipcode', 20)->nullable();
            $table->string('city', 20)->nullable();
            $table->string('street', 20)->nullable();
            $table->text('add_info')->nullable();
            $table->bigInteger('loadoard_id')->index('loadoard_id');
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
        Schema::dropIfExists('load_container');
    }
};
