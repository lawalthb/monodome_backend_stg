<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->default(Str::uuid()->toString());
            $table->string('order_no');
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('driver_id')->unsigned()->nullable();
            $table->decimal('amount',38, 18)->default(0);
            $table->decimal('fee',38, 18)->default(0);
            $table->unsignedBigInteger('loadable_id'); // Foreign key to the associated load
            $table->string('loadable_type'); // Type of load (e.g., 'load_packages', 'load_specialized', etc.)
            $table->enum('status', ['Pending', 'Confrimed', 'Failed', 'Paid'])->default('Pending');
            $table->timestamps();


            // Define foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};