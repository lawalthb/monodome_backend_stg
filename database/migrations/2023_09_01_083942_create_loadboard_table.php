<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('loadboard', function (Blueprint $table) {
            $table->bigInteger('id', true);
            $table->string('uuid');
            $table->bigInteger('user_id')->index('user_id');
            $table->integer('load_type_id')->index('loadtype');
            $table->string('loadtype_name', 30)->nullable()->comment('package, bulk, car clearing, container shipment, specialize shipment');
            $table->enum('status', ['Pending', 'Failed', 'Completed', 'Rejected'])->default('Pending');
            $table->bigInteger('order_no');
            $table->timestamp('load_date')->useCurrent();

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
        Schema::dropIfExists('loadboard');
    }
};
