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
        Schema::create('monitoring_line_basos', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();

            $table->string('line_baso')->nullable();

            $table->decimal('parameter_pemasakan_suhu_air', 8, 2)->nullable();
            $table->decimal('parameter_pemasakan_suhu_produk', 8, 2)->nullable();
            $table->string('parameter_pemasakan_bentuk')->nullable();

            $table->time('waktu_forming_mulai')->nullable();
            $table->time('waktu_forming_selesai')->nullable();

            $table->time('cooling_down_mulai')->nullable();
            $table->time('cooling_down_selesai')->nullable();

            $table->decimal('suhu_produk_matang', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monitoring_line_basos');
    }
};
