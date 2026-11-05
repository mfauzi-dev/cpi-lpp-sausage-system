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
        Schema::create('standar_parameter_produks', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->unsignedTinyInteger('sampling_ke');
            $table->decimal('diameter', 8, 2)->nullable();
            $table->decimal('panjang', 8, 2)->nullable();
            $table->decimal('berat_per_pcs', 8, 2)->nullable();
            $table->decimal('berat_kulit', 8, 2)->nullable();
            $table->decimal('berat_adonan', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('standar_parameter_produks');
    }
};
