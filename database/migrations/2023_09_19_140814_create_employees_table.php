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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->string('uuid');
            $table->string('full_name');
            $table->string('address');
            $table->string('phone_number');
            $table->string('email');
            $table->string('department');
            $table->enum('status', ['Pending', 'Confirmed', 'Approved', 'Rejected','Failed'])->default('Pending');
            $table->timestamps();
            $table->softDeletes();

        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};
