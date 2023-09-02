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
            $table->bigInteger('loadboard_id');
            $table->integer('delivery_from_country');
            $table->integer('delivery_to_country');
            $table->text('description')->nullable();
            $table->bigInteger('document_id');
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
