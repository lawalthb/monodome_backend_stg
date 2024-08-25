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
        // Create the next_of_kins table first
        Schema::create('next_of_kins', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('id_number');
            $table->enum('id_type', ['National ID', 'Passport', 'Driver License', 'Voters Card']);
            $table->date('expiry_date');
            $table->string('document')->nullable();
            $table->string('next_of_name');
            $table->string('next_of_phone');
            $table->string('next_of_email');
            $table->timestamps();

            // Foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        // Create the insurances table
        Schema::create('insurances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('order_no');
            $table->string('insurance_type')->nullable();
            $table->decimal('insurance_amount', 10, 2);
            $table->string('policy_number')->unique()->nullable();
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->string('document')->nullable();
            $table->unsignedBigInteger('next_of_kin_id')->nullable();
            $table->enum('payment_status', ['Pending', 'Paid'])->default('Pending');
            $table->enum('status', ['In Progress', 'Policy Created', 'Creating Policy', 'Cancelled'])->default('In Progress');
            $table->timestamps();

            // Foreign key constraints
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('next_of_kin_id')->references('id')->on('next_of_kins')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('insurances');
        Schema::dropIfExists('next_of_kins');
    }
};
