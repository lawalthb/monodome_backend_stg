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
        Schema::create('wallet_histories', function (Blueprint $table) use  ($currencyLength, $currencyDecimals) {
            $table->id();
            $table->bigInteger('user_id')->unsigned();
            $table->bigInteger('wallet_id')->unsigned();
            $table->string('type', 20)->comment('withdrawal, transfer');
            $table->string('payment_type', 20)->comment('1=paystack,2=wallet');
            $table->string('paystack_reference')->nullable();
            $table->decimal('amount',$currencyLength, $currencyDecimals)->default(0);
            $table->decimal('closing_balance',$currencyLength, $currencyDecimals)->default(0);
            $table->float('fee');
            $table->string('description');
            $table->timestamps();

            // Define foreign key constraint
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('wallet_id')->references('id')->on('wallets')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wallet_histories');
    }
};
