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
        Schema::create('production_batches', function (Blueprint $table) {
            $table->id();
            $table->string('hari');
            $table->date('tanggal');
            $table->foreignId('product_id')->constrained('products')->restrictOnDelete();
            $table->string('kode_batch');
            $table->decimal('yield_meat', 12, 3)->nullable();
            $table->decimal('total_meat', 12, 3)->nullable();
            $table->unsignedTinyInteger('shift')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('production_batches');
    }
};
