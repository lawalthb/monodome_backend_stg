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
        Schema::create('container_carriers', function (Blueprint $table) {
            $table->id();
            $table->string('name', 191);
            $table->timestamps();
        });


        // Insert carriers data into the table
        $carriers = [
            'Mediterranean Shipping Company',
            'AP Moller-Maersk Group',
            'CMA CGM Group',
            'China Cosco Group',
            'Hapag-Lloyd',
            'Evergreen Marine Corporation',
            'Ocean Network Express',
            'Hyundai Merchant Marine',
            'Yang Ming Marine Transport Corporation',
            'Zim Integrated Shipping Services',
        ];

        foreach ($carriers as $carrier) {
            DB::table('container_carriers')->insert([
                'name' => $carrier,
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('container_carriers');
    }
};
