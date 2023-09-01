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
        Schema::create('states', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->unsignedBigInteger('country_id')->index('states_country_id_foreign');
            $table->char('country_code', 2);
            $table->string('fips_code')->nullable()->default('NULL');
            $table->string('iso2')->nullable()->default('NULL');
            $table->string('type', 191)->nullable()->default('NULL');
            $table->decimal('latitude', 10, 8)->nullable()->default(0);
            $table->decimal('longitude', 11, 8)->nullable()->default(0);
            $table->tinyInteger('flag')->default(1);
            $table->string('wikiDataId')->nullable()->default('NULL');
            $table->string('created_at')->nullable();
            $table->string('updated_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('states');
    }
};
