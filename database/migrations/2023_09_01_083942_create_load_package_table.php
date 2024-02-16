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
        Schema::create('load_packages', function (Blueprint $table) {
            $table->id();
            $table->string('uuid')->default(Str::uuid()->toString());
            $table->bigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('load_type_id');
            $table->string('load_type_name')->default("package")->nullable();
            $table->enum('deliver_from', ['address', 'office','map'])->nullable();
            $table->integer('to_office_id')->nullable();
            $table->string('sender_location')->nullable();
            $table->string('receiver_location')->nullable();
            $table->string('distance')->nullable();
            $table->string('sender_email', 100)->nullable();
            $table->string('sender_name', 100)->nullable();
            $table->string('sender_phone', 100)->nullable();
            $table->string('sender_lga')->nullable();
            $table->string('sender_street', 100)->nullable();
            $table->unsignedBigInteger('sender_state')->nullable();
            $table->string('sender_apartment', 100)->nullable();
            $table->string('sender_apartment_no', 100)->nullable();
            $table->enum('deliver_to', ['address', 'office','map'])->nullable();
            $table->integer('from_office_id')->nullable()->default(1);
            $table->string('receiver_name', 100)->nullable();
            $table->string('receiver_email', 100)->nullable();
            $table->string('receiver_phone', 100)->nullable();
            $table->string('receiver_lga', 100)->nullable();
            $table->unsignedBigInteger('receiver_state')->nullable();
            $table->string('receiver_street', 100)->nullable();
            $table->string('receiver_apartment', 100)->nullable();
            $table->string('receiver_apartment_no', 100)->nullable();
            $table->enum('is_document', ['No', 'Yes'])->default('Yes');
            $table->string('document')->nullable();
            $table->text('description')->nullable();
            $table->decimal('weight', 20)->nullable();
            $table->decimal('width', 20)->nullable();
            $table->decimal('length', 20)->nullable();
            $table->decimal('height', 20)->nullable();
            // $table->enum('status', ['Pending', 'Approved', 'Failed','Processing','waiting'])->default('Pending');
            $table->enum('insure_it', ['Yes', 'No'])->default('No')->nullable();
            $table->decimal('insure_amount', 20)->nullable()->default(0);
            $table->decimal('delivery_fee', 20)->nullable()->default(0);
            $table->decimal('total_amount', 20)->nullable()->default(0);
            $table->enum('is_fragile', ['Yes', 'No'])->default('No')->nullable();
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
        Schema::dropIfExists('load_packages');
    }
};
