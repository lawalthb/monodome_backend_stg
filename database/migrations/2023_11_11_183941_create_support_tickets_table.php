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
        Schema::create('support_tickets', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable();
            $table->string('via_mode', 20)->default('WEB');
            $table->string('name')->nullable();
            $table->string('email', 91)->nullable();
            $table->string('ticket', 191)->nullable();
            $table->string('subject', 191)->nullable();
            $table->tinyInteger('status')->default(0)->comment('0: Open, 1: Answered, 2: Replied, 3: Closed');
            $table->integer('isClosed')->default(0);
            $table->datetime('last_reply')->nullable();
            $table->timestamps();

            $table->index('user_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_tickets');
    }
};
