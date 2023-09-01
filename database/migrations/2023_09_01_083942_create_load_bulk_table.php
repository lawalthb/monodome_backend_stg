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
        Schema::create('load_bulk', function (Blueprint $table) {
            $table->integer('id', true);
            $table->unsignedBigInteger('load_type_id');
            $table->string('load_type_type');
            $table->enum('deliver_from', ['address', 'office'])->nullable();
            $table->integer('to_office_id')->nullable()->default(1);
            $table->string('sender_name', 30)->nullable();
            $table->string('sender_phone', 30)->nullable();
            $table->string('sender_zipcode', 20)->nullable();
            $table->string('sender_city', 30)->nullable();
            $table->string('sender_street', 30)->nullable();
            $table->string('sender_number', 30)->nullable();
            $table->string('sender_appartment', 30)->nullable();
            $table->enum('deliver_to', ['address', 'office'])->nullable();
            $table->integer('from_office_id')->nullable()->default(1);
            $table->string('receiver_name', 30)->nullable();
            $table->string('receiver_phone', 30)->nullable();
            $table->string('receiver_zipcode', 30)->nullable();
            $table->string('receiver_city', 30)->nullable();
            $table->string('receiver_street', 30)->nullable();
            $table->string('receiver_number', 30)->nullable();
            $table->string('receiver_appartment', 30)->nullable();
            $table->enum('is_schedule', ['No', 'Yes'])->default('No');
            $table->text('description')->nullable();
            $table->string('vehicle_no', 30)->nullable();
            $table->decimal('weight', 20)->nullable();
            $table->dateTime('schedule_date')->nullable();
            $table->bigInteger('document_id')->nullable();
            $table->decimal('width', 20)->nullable();
            $table->decimal('length', 20)->nullable();
            $table->decimal('height', 20)->nullable();
            $table->enum('insure_it', ['Yes', 'No'])->nullable();
            $table->decimal('insure_amount', 20)->nullable()->default(0);
            $table->enum('is_fragile', ['Yes', 'No'])->nullable();
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
        Schema::dropIfExists('load_bulk');
    }
};
