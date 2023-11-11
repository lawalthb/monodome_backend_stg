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
        Schema::create('support_attachments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('support_message_id');
            $table->string('attachment', 191);
            $table->timestamps();

            $table->foreign('support_message_id')->references('id')->on('support_messages');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('support_attachments');
    }
};
