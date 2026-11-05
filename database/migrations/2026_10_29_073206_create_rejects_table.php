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
        Schema::create('rejects', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->decimal('lepas_twisting_cooking', 10, 2)->nullable();
            $table->decimal('lepas_twisting_packing', 10, 2)->nullable();
            $table->decimal('jatuh_cooking', 10, 2)->nullable();
            $table->decimal('jatuh_packing', 10, 2)->nullable();
            $table->decimal('potong_cooking', 10, 2)->nullable();
            $table->decimal('potong_packing', 10, 2)->nullable();
            $table->decimal('total_rijek_cooking_kg', 10, 2)->nullable();
            $table->decimal('total_rijek_packing_kg', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('rejects');
    }
};
