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
            $table->id();
            $table->string('uuid')->default(Str::uuid()->toString());
            $table->bigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('load_type_id')->nullable();
            $table->string('load_type_name')->default('bulk');
            $table->string('sender_location')->nullable();
            $table->string('receiver_location')->nullable();
            $table->string('distance')->nullable();
            $table->enum('deliver_from', ['address', 'office','map'])->nullable();
            $table->integer('to_office_id')->nullable();
            $table->string('sender_email', 100)->nullable();
            $table->string('sender_name', 100)->nullable();
            $table->string('sender_phone', 100)->nullable();
            $table->string('sender_lga')->nullable();
            $table->string('sender_street', 100)->nullable();
            $table->unsignedBigInteger('sender_state')->nullable();
            $table->string('sender_apartment', 100)->nullable();
            $table->string('sender_apartment_no', 100)->nullable();
            //  $table->string('sender_city', 100)->nullable();
            $table->enum('deliver_to', ['address', 'office','map'])->nullable();
            $table->integer('from_office_id')->nullable();
            $table->string('receiver_name', 100)->nullable();
            $table->string('receiver_email', 100)->nullable();
            $table->string('receiver_phone', 100)->nullable();
            $table->string('receiver_lga', 100)->nullable();
            $table->unsignedBigInteger('receiver_state')->nullable();
            $table->string('receiver_street', 30)->nullable();
            $table->string('receiver_apartment', 30)->nullable();
            $table->string('receiver_apartment_no', 30)->nullable();
            $table->enum('is_schedule', ['No', 'Yes'])->default('No');
            $table->text('description')->nullable();
            $table->string('vehicle_no', 30)->nullable();
            $table->decimal('weight', 20)->nullable();
            $table->string('schedule_date')->nullable();
            // $table->string('document')->nullable();
            $table->decimal('width', 20)->nullable();
            $table->decimal('length', 20)->nullable();
            $table->decimal('height', 20)->nullable();
            $table->enum('insure_it', ['Yes', 'No'])->default('No')->nullable();
            $table->decimal('insure_amount', 20)->nullable()->default(0);
            $table->decimal('total_amount', 20)->nullable()->default(0);
            $table->enum('is_fragile', ['Yes', 'No'])->default('No')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Rejected','Failed','Approved','Processing'])->default('Pending');

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
