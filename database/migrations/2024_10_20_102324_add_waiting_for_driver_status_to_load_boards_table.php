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
        Schema::table('load_boards', function (Blueprint $table) {
            // Change enum to string to avoid issues with DBAL
            $table->string('status', 30)->default('pending')->change(); // Use string instead of enum
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('load_boards', function (Blueprint $table) {
            // Revert back to the original enum if needed
            $table->enum('status', ['pending', 'processing', 'on_transit', 'delivered', 'rejected', 'delayed'])->default('pending')->change();
        });
    }
};
