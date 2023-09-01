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
            $table->bigInteger('user_id')->index('user_id');
            $table->integer('loadtype')->index('loadtype');
            $table->string('loadtype_name', 30)->nullable();
            $table->enum('status', ['Pending', 'Failed', 'Completed', 'Rejected'])->default('Pending');
            $table->bigInteger('order_no');
            $table->timestamp('load_date')->useCurrent();

            $table->unique(['id', 'order_no'], 'id');
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
