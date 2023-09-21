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

        $currencyLength = 36;
        $currencyDecimals = 18;
        Schema::create('wallets', function (Blueprint $table) use ($currencyLength, $currencyDecimals)  {
            $table->id();
            $table->string('uuid');
            $table->string('wallet_type')->default('monolog_wallet');
            $table->bigInteger('user_id')->unsigned();
            $table->decimal('amount',$currencyLength, $currencyDecimals)->default(0);
            $table->string('status')->default('Active')->comment('0=inActive, 1=Active');
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
        Schema::dropIfExists('wallets');
    }
};
