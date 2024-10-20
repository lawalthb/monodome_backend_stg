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
        Schema::create('load_boards', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('uuid')->default(Str::uuid()->toString());;
            $table->bigInteger('user_id')->index('user_id');
            $table->unsignedBigInteger('acceptable_id')->nullable();
            $table->string('acceptable_type')->nullable();
            $table->integer('load_type_id')->index('load_type_name');
            $table->string('load_type_name', 30)->nullable()->comment('package, bulk, car clearing, container shipment, specialize shipment');
            // $table->enum('admin_approve', ['Yes', 'No'])->default('No');
            $table->enum('status', ['pending', 'processing', 'on_transit', 'delivered', 'rejected',"delayed"])->default('pending');
            $table->string('status_comment')->nullable();
            $table->string('order_no');
            $table->timestamp('load_date')->useCurrent();
            $table->unsignedBigInteger('loadable_id');
            $table->string('loadable_type');
            $table->unique(['id', 'order_no'], 'id');
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
        Schema::dropIfExists('load_boards');
    }
};
