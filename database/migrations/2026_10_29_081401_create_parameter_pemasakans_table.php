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
        Schema::create('parameter_pemasakans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->string('penggunaan_mesin');

            $table->decimal('drying_1_suhu', 8, 2)->nullable();
            $table->decimal('drying_1_rh', 8, 2)->nullable();
            $table->decimal('drying_1_waktu', 8, 2)->nullable();

            $table->decimal('drying_2_suhu', 8, 2)->nullable();
            $table->decimal('drying_2_rh', 8, 2)->nullable();
            $table->decimal('drying_2_waktu', 8, 2)->nullable();

            $table->decimal('drying_3_suhu', 8, 2)->nullable();
            $table->decimal('drying_3_rh', 8, 2)->nullable();
            $table->decimal('drying_3_waktu', 8, 2)->nullable();

            $table->decimal('cooking_suhu', 8, 2)->nullable();
            $table->decimal('cooking_rh', 8, 2)->nullable();
            $table->decimal('cooking_waktu', 8, 2)->nullable();

            $table->decimal('smoke_suhu', 8, 2)->nullable();
            $table->decimal('smoke_rh', 8, 2)->nullable();
            $table->decimal('smoke_waktu', 8, 2)->nullable();

            $table->decimal('drying_4_suhu', 8, 2)->nullable();
            $table->decimal('drying_4_rh', 8, 2)->nullable();
            $table->decimal('drying_4_waktu', 8, 2)->nullable();

            $table->decimal('suhu_produk_matang', 8, 2)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parameter_pemasakans');
    }
};
