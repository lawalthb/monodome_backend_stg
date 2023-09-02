<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('load_documents', function (Blueprint $table) {
            $table->id(); // Define the primary key column
            $table->string('uuid')->default(Str::uuid()->toString());
            $table->string('name'); // Original file name
            $table->string('path'); // File path in storage
            $table->unsignedBigInteger('loadable_id'); // Foreign key to the associated load
            $table->string('loadable_type'); // Type of load (e.g., 'load_packages', 'load_specialized', etc.)
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('load_documents');
    }
};
