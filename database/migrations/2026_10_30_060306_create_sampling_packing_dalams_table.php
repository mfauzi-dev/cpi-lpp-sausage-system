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
        Schema::create('sampling_packing_dalams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->unsignedTinyInteger('sampling_ke');
            $table->decimal('berat_kemasan', 8, 2)->nullable();
            $table->decimal('berat_per_bag', 8, 2)->nullable();
            $table->decimal('range_berat', 8, 2)->nullable();
            $table->decimal('standar_berat', 8, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sampling_packing_dalams');
    }
};
