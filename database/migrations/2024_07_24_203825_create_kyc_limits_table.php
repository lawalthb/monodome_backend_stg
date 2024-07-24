<?php

use Illuminate\Support\Facades\DB;
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
        Schema::create('kyc_limits', function (Blueprint $table) {
            $table->id();
            $table->string('kyc_level')->unique();
            $table->decimal('min_limit', 10, 2);
            $table->decimal('max_limit', 10, 2);
            $table->timestamps();
        });

        // Seed initial data
        DB::table('kyc_limits')->insert([
            ['kyc_level' => 'basic', 'min_limit' => 100, 'max_limit' => 500000],
            ['kyc_level' => 'silver', 'min_limit' => 500000, 'max_limit' => 5000000],
            ['kyc_level' => 'gold', 'min_limit' => 5000000, 'max_limit' => 50000000],
            ['kyc_level' => 'platinum', 'min_limit' => 5000000, 'max_limit' => 50000000],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kyc_limits');
    }
};
