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
        Schema::table('chats', function (Blueprint $table) {
            // Adding chat_room_id column and creating foreign key
            $table->unsignedBigInteger('chat_room_id')->after('id')->nullable();

            // Set up the foreign key constraint for chat_room_id
            $table->foreign('chat_room_id')->references('id')->on('chat_rooms')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('chats', function (Blueprint $table) {
            // Dropping the chat_room_id column
            $table->dropForeign(['chat_room_id']);
            $table->dropColumn('chat_room_id');
        });
    }
};
