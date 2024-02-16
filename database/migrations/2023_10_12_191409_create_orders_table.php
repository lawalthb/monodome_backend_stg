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
            $table->bigInteger('placed_by_id')->unsigned()->nullable();
            $table->enum('accepted', ['Yes', 'No', 'Rejected'])->default('No');
            $table->decimal('amount', 10, 2)->default(0);
            $table->decimal('fee',38, 2)->default(0);
            $table->unsignedBigInteger('acceptable_id')->nullable();
            $table->string('acceptable_type')->nullable();
            $table->enum('admin_approve', ['Yes', 'No'])->default('No');
            $table->enum('payment_type',['wallet','online','offline'])->nullable();
            // $table->enum('payment_note',['wallet','online','offline'])->nullable();
            $table->enum('payment_status',['Failed', 'Paid','Pending'])->default("Pending");
            $table->unsignedBigInteger('loadable_id');
            $table->string('loadable_type');
            // $table->enum('status', ['Pending', 'Confirmed', 'Processing','Waiting','out_for_delivery','canceled','returned','Delivered','awaiting_confirmation'])->default('Pending');
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
