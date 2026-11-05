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
        Schema::create('standar_mesin_packing_dalams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();

            $table->string('parameter_mesin');

            $table->string('penggunaan_mesin_sausage_cutter')->nullable();
            $table->string('penggunaan_mesin_vacuum_pack')->nullable();
            $table->string('penggunaan_mesin_thermoforming')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_mesin_packing_dalams');
    }
};
