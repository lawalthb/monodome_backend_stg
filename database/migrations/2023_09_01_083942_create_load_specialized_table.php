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

        if(!Schema::hasTable('load_specializeds')){

        Schema::create('load_specializeds', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('uuid')->default(Str::uuid()->toString());;
            $table->bigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('load_type_id');
           // $table->bigInteger('load_board_id');
           $table->string('sender_location')->nullable();
            $table->string('receiver_location')->nullable();
            $table->string('distance')->nullable();
            $table->string('load_type_name')->default('specialize-shipment');
            $table->integer('deliver_from_country');
            $table->integer('deliver_from_state');
            $table->integer('deliver_to_country');
            $table->integer('deliver_to_state');

            $table->string('sender_email', 100)->nullable();
            $table->string('sender_name', 100)->nullable();
            $table->string('sender_phone', 100)->nullable();

            $table->string('receiver_name', 100)->nullable();
            $table->string('receiver_email', 100)->nullable();
            $table->string('receiver_phone', 100)->nullable();
            $table->decimal('delivery_fee', 20)->nullable()->default(0);
            $table->decimal('total_amount', 20)->nullable()->default(0);
            $table->enum('insure_it', ['Yes', 'No'])->default('No')->nullable();

            $table->text('description')->nullable();
            $table->enum('status', ['Pending', 'Confirmed', 'Rejected','Failed','Approved','Processing','Waiting'])->default('Pending');
            $table->timestamps();
        });
    }
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('load_specialized');
    }
};
