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
        Schema::create('load_containers', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('uuid')->default(Str::uuid()->toString());
            $table->bigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('load_type_id');
            $table->string('load_type_name')->default('container-shipment');
            $table->string('sender_location')->nullable();
            $table->string('receiver_location')->nullable();
            $table->string('distance')->nullable();
            $table->integer('departure_country');
            $table->integer('destination_country');
            $table->string('container_height', 10)->nullable();
            $table->integer('container_carrier_id')->nullable();
            $table->string('container_value', 20)->nullable();
            $table->string('cars_in_container')->nullable();
            $table->string('other_contents_in_container')->nullable();
            $table->string('document')->nullable();
            $table->text('content_description')->nullable();
            $table->enum('is_final', ['Yes', 'No'])->default('No');
            $table->string('receiver_name', 100)->nullable();
            $table->string('receiver_email', 100)->nullable();
            $table->string('receiver_phone', 100)->nullable();
            $table->string('deliver_apartment', 100)->nullable();
            $table->string('deliver_from_city', 100)->nullable();
            $table->string('deliver_to_city', 100)->nullable();
            $table->string('city', 30)->nullable();
            $table->string('street', 30)->nullable();
            $table->text('add_info')->nullable();
            $table->decimal('suggested_amount', 20)->nullable()->default(0);
            $table->decimal('total_amount', 20)->nullable()->default(0);
            $table->enum('status', ['Pending', 'Confirmed', 'Rejected','Failed','Approved','Processing','Waiting'])->default('Pending');

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
        Schema::dropIfExists('load_containers');
    }
};
