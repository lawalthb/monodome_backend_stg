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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('full_name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('provider_id')->nullable();
            $table->string('provider')->nullable();
            $table->string('address')->nullable();
            $table->string('role_id')->nullable();
            $table->string('imageUrl')->nullable();
            $table->enum('user_type', ['customer', 'broker', 'shipping_company_super', 'shipping_company_admin', 'agent', 'clearing_forwarding', 'driver', 'driver_manager', 'driver_manager_driver', 'company_transporter_super', 'company_transporter_admin', 'company_transporter_driver']);
            $table->enum('role', ['customer', 'broker', 'shipping_company', 'agent', 'clearing_forwarding', 'driver', 'driver_manager', 'company_transporter']);
            $table->rememberToken();
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
        Schema::dropIfExists('users');
    }
};