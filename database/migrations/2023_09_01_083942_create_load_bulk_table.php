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
        Schema::create('load_bulks', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('uuid')->default(Str::uuid()->toString());;
            $table->unsignedBigInteger('load_type_id')->default(2);
            $table->string('load_type_name')->default('bulk');
            $table->enum('deliver_from', ['address', 'office'])->nullable();
            $table->integer('to_office_id')->nullable()->default(1);
            $table->string('sender_name', 30)->nullable();
            $table->string('sender_phone', 30)->nullable();
            $table->string('sender_zip_code', 20)->nullable();
            $table->string('sender_city', 30)->nullable();
            $table->string('sender_state_id', 30)->nullable();
            $table->string('sender_number', 30)->nullable();
            $table->string('sender_email', 30)->nullable();
            $table->enum('deliver_to', ['address', 'office'])->nullable();
            $table->integer('from_office_id')->nullable()->default(1);
            $table->string('receiver_name', 30)->nullable();
            $table->string('receiver_phone', 30)->nullable();
            $table->string('receiver_zip_code', 30)->nullable();
            $table->string('receiver_city', 30)->nullable();
            $table->string('receiver_state_id', 30)->nullable();
           // $table->string('receiver_number', 30)->nullable();
            $table->string('receiver_email', 30)->nullable();
            $table->enum('is_schedule', ['No', 'Yes'])->default('No');
            $table->text('description')->nullable();
            $table->string('vehicle_no', 30)->nullable();
            $table->decimal('weight', 20)->nullable();
            $table->dateTime('schedule_date')->nullable();
            // $table->string('document')->nullable();
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
        Schema::dropIfExists('load_bulks');
    }
};
