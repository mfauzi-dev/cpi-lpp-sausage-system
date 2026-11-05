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
        Schema::create('rekapitulasi_packing_luars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();

            $table->unsignedInteger('jumlah_batch')->nullable();
            $table->decimal('jumlah_pack', 12, 2)->nullable();
            $table->decimal('jumlah_boks', 12, 2)->nullable();
            $table->decimal('jumlah_kg', 12, 2)->nullable();

            $table->string('no_bstb')->nullable();

            $table->decimal('jumlah_wip_keluar_bag', 12, 2)->nullable();
            $table->decimal('jumlah_wip_keluar_kg', 12, 2)->nullable();

            $table->date('tanggal_transfer')->nullable();
            $table->string('wip_masuk')->nullable();
            $table->decimal('jumlah_wip_masuk', 12, 2)->nullable();
            $table->string('checker')->nullable();
            $table->string('kr')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rekapitulasi_packing_luars');
    }
};
