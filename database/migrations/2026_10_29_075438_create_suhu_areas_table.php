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
        Schema::create('suhu_areas', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
 
            $table->decimal('chillroom_std', 8, 2)->nullable();
            $table->decimal('chillroom_act', 8, 2)->nullable();
 
            $table->decimal('meatprep_std', 8, 2)->nullable();
            $table->decimal('meatprep_act', 8, 2)->nullable();
 
            $table->decimal('cooking_std', 8, 2)->nullable();
            $table->decimal('cooking_act', 8, 2)->nullable();
 
            $table->decimal('seasoning_std', 8, 2)->nullable();
            $table->decimal('seasoning_act', 8, 2)->nullable();
 
            $table->decimal('cooling_down_std', 8, 2)->nullable();
            $table->decimal('cooling_down_act', 8, 2)->nullable();
 
            $table->decimal('packing_dalam_std', 8, 2)->nullable();
            $table->decimal('packing_dalam_act', 8, 2)->nullable();
 
            $table->decimal('packing_luar_std', 8, 2)->nullable();
            $table->decimal('packing_luar_act', 8, 2)->nullable();
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suhu_areas');
    }
};
