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
        Schema::create('offices', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedBigInteger('agent_id');
            $table->string('address');
            $table->unsignedBigInteger('country_id');
            $table->unsignedBigInteger('state_id');
            $table->enum('status', ['Active', 'Inactive'])->default('Active');
            $table->timestamps();

            // Define foreign key constraints
          //  $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->foreign('country_id')->references('id')->on('countries')->onDelete('cascade');
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('offices');
    }
};
