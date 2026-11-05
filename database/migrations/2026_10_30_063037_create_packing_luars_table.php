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
        Schema::create('packing_luars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->string('proses_freezing')->nullable();
            $table->decimal('jumlah_input', 10, 2)->nullable();
            $table->decimal('suhu_iqf', 8, 2)->nullable();
            $table->decimal('suhu_produk', 8, 2)->nullable();
            $table->string('dweling_time')->nullable();
            $table->time('waktu_awal')->nullable();
            $table->time('waktu_akhir')->nullable();
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
        Schema::dropIfExists('packing_luars');
    }
};
