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
        Schema::create('pengemasan_plastik_packing_dalams', function (Blueprint $table) {
            $table->id();
            $table->foreignId('production_batch_id')->constrained('production_batches')->cascadeOnDelete();

            $table->string('jenis_plastik')->nullable();
            $table->string('no_md')->nullable();
            $table->unsignedInteger('qty_pack')->default(0);
            $table->decimal('pemakaian', 12, 2)->default(0);
            $table->decimal('sisa', 12, 2)->default(0);
            $table->decimal('reject_plastik', 12, 2)->default(0);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pengemasan_plastik_packing_dalams');
    }
};
