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
        Schema::create('karton_box_packing_luars', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();
            $table->string('jenis_karton_box');
            $table->decimal('qty_box', 12, 2)->nullable();
            $table->decimal('pemakaian', 12, 2)->nullable();
            $table->decimal('sisa', 12, 2)->nullable();
            $table->decimal('reject', 12, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('karton_box_packing_luars');
    }
};
