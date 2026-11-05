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
        Schema::create('monitoring_pemasakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();

            $table->time('waktu_pemasakan_mulai')->nullable();
            $table->time('waktu_pemasakan_selesai')->nullable();

            $table->unsignedInteger('jumlah_trolly_pcs')->nullable();

            $table->decimal('cooling_down_waktu', 8, 2)->nullable();
            $table->decimal('cooling_down_suhu_ruang', 8, 2)->nullable();
            $table->decimal('cooling_down_suhu_produk', 8, 2)->nullable();

            $table->decimal('pressure_angin', 8, 2)->nullable();
            $table->decimal('tekanan_steam_header', 8, 2)->nullable();
            $table->decimal('smoke_generator', 8, 2)->nullable();

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
        Schema::dropIfExists('monitoring_pemasakans');
    }
};
