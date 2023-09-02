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
        Schema::create('load_types', function (Blueprint $table) {
            $table->integer('id', true);
            $table->string('uuid')->default(Str::uuid()->toString());
            $table->string('name', 30)->comment('package, bulk, car clearing, container shipment, specialize shipment');;
            $table->string('slug');
            $table->enum('is_active', ['Yes', 'No'])->default('Yes');
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
        Schema::dropIfExists('load_types');
    }
};
