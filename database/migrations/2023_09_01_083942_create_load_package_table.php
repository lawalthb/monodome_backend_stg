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
        Schema::create('load_package', function (Blueprint $table) {
            $table->integer('id', true);
            $table->bigInteger('load_board_id')->index('load_board_id');
            $table->enum('deliver_from', ['address', 'office'])->nullable();
            $table->integer('to_office_id')->nullable()->default(1);
            $table->string('sender_name', 30)->nullable();
            $table->string('sender_phone', 30)->nullable();
            $table->string('sender_zipcode', 20)->nullable();
            $table->string('sender_city', 30)->nullable();
            $table->string('sender_street', 30)->nullable();
            $table->string('state_id', 30)->nullable();
            $table->string('sender_email', 30)->nullable();
            $table->enum('deliver_to', ['address', 'office'])->nullable();
            $table->integer('from_office_id')->nullable()->default(1);
            $table->string('receiver_name', 30)->nullable();
            $table->string('receiver_phone', 30)->nullable();
            $table->string('receiver_zipcode', 30)->nullable();
            $table->string('receiver_city', 30)->nullable();
            $table->string('receiver_street', 30)->nullable();
            $table->string('receiver_number', 30)->nullable();
            $table->string('receiver_email', 30)->nullable();
            $table->enum('is_document', ['No', 'Yes'])->default('Yes');
            $table->text('description')->nullable();
            $table->decimal('weight', 20)->nullable();
            $table->decimal('width', 20)->nullable();
            $table->decimal('length', 20)->nullable();
            $table->decimal('height', 20)->nullable();
            $table->enum('insure_it', ['Yes', 'No'])->nullable();
            $table->decimal('insure_amount', 20)->nullable()->default(0);
            $table->enum('is_fragile', ['Yes', 'No'])->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('load_package');
    }
};
