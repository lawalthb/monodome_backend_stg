<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('local_governments', function (Blueprint $table) {
            $table->id('id');
            $table->bigInteger('state_id')->unsigned();
            $table->string('name', 255);
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });

        }



    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('local_governments');
    }
};
