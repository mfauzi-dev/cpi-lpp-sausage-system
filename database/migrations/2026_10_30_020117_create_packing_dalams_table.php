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
        Schema::create('packing_dalams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();

            $table->string('petugas_pengemasan')->nullable();

            $table->string('line_manual_single')->nullable();
            $table->string('line_manual_dimsum')->nullable();
            $table->string('line_manual_baso')->nullable();

            $table->string('line_thermoforming_1')->nullable();
            $table->string('line_thermoforming_2')->nullable();
            $table->string('line_thermoforming_3')->nullable();

            $table->time('waktu_pengemasan_awal')->nullable();
            $table->time('waktu_pengemasan_akhir')->nullable();

            $table->string('downtime_kerusakan')->nullable();
            $table->decimal('downtime_waktu', 8, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('packing_dalams');
    }
};
