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
        Schema::create('pengemasan_packing_luars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->string('parameter_packing_luar')->nullable();
            $table->string('no_mesin')->nullable();
            $table->string('petugas')->nullable();
            $table->string('kr')->nullable();
            $table->string('foreman')->nullable();
            $table->time('waktu_awal')->nullable();
            $table->time('waktu_akhir')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengemasan_packing_luars');
    }
};
