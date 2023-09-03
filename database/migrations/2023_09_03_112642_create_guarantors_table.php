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
        Schema::create('guarantors', function (Blueprint $table) {
            $table->id();
            $table->string('full_name')->nullable();
            $table->string('phone_number')->nullable();
            $table->string('address')->nullable();
            $table->string('street')->nullable();
            $table->string('state')->nullable();
            $table->string('lga')->nullable();
            $table->string('state_of_residence')->nullable();
            $table->string('city_of_residence')->nullable();
            $table->string('profile_picture')->nullable();
         //   $table->unsignedBigInteger('agent_id'); // Foreign key to link the guarantor with an agent
           // $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
            $table->unsignedBigInteger('loadable_id'); // Foreign key to the associated load
            $table->string('loadable_type'); // Type of load (e.g., 'load_packages', 'load_specialized', etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('guarantors');
    }
};
