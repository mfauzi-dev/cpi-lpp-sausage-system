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
        Schema::create('produksi_bahan_baku_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('produksi_bahan_baku_id')->constrained('produksi_bahan_bakus')->cascadeOnDelete();
            $table->foreignId('bahan_baku_id')->constrained('bahan_bakus')->cascadeOnDelete();
            $table->foreignId('product_formula_id')->nullable()->constrained('product_formulas')->nullOnDelete();
            $table->string('kode_batch')->nullable();
            $table->date('best_before')->nullable();
            $table->decimal('total_kg', 12, 2);
            $table->decimal('suhu_rm', 5, 1)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('produksi_bahan_baku_items');
    }
};
