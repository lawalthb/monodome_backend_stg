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
        Schema::create('load_specialized', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('uuid')->default(Str::uuid()->toString());;
            $table->bigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('load_type_id');
            $table->bigInteger('load_board_id');
            $table->string('load_type_name')->default('specialize-shipment');
            $table->integer('deliver_from_city');
            $table->integer('deliver_to_city');
            $table->text('description')->nullable();
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
        Schema::dropIfExists('load_specialized');
    }
};
