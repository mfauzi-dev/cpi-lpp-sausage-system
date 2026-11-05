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
        Schema::create('penggunaan_mesins', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->string('name');
            $table->decimal('speed_machine', 12, 2)->default(0);
            $table->string('ukuran_holeplate_knife')->nullable();
            $table->string('linker')->nullable();
            $table->string('stuffing_tube')->nullable();
            $table->string('twisting')->nullable();
            $table->string('chuck')->nullable();
            $table->time('waktu_mulai')->nullable();
            $table->time('waktu_selesai')->nullable();
            $table->text('downtime_kerusakan')->nullable();
            $table->decimal('downtime_lama_waktu', 8, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('penggunaan_mesins');
    }
};
