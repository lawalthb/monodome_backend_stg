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
        Schema::create('admin_permissions', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('admin_id')->default(0);
            $table->tinyInteger('block_user')->default(0);
            $table->tinyInteger('see_full_user_info')->default(0);
            $table->tinyInteger('edit_user')->default(0);
            $table->tinyInteger('provide_premium')->default(0);
            $table->tinyInteger('view_request')->default(0);
            $table->tinyInteger('approve_changes')->default(0);
            $table->tinyInteger('see_full_order_info')->default(0);
            $table->tinyInteger('edit_order')->default(0);
            $table->tinyInteger('refund')->default(0);
            $table->tinyInteger('wallet_read')->default(0);
            $table->tinyInteger('wallet_transer')->default(0);
            $table->tinyInteger('block_admin')->default(0);
            $table->tinyInteger('give_permissions')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admin_permissions');
    }
};
