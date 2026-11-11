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
        Schema::table('production_batches', function (Blueprint $table) {
            $table->string('foto_kartu_rute')->nullable()->after('kode_batch');
            $table->string('foto_stamp_plastik')->nullable()->after('foto_kartu_rute');
            $table->string('foto_stamp_box')->nullable()->after('foto_stamp_plastik');
            $table->string('foto_ed_plastik')->nullable()->after('foto_stamp_box');
            $table->string('foto_ed_carton_box')->nullable()->after('foto_ed_plastik');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('production_batches', function (Blueprint $table) {
            $table->dropColumn([
                'foto_kartu_rute',
                'foto_stamp_plastik',
                'foto_stamp_box',
                'foto_ed_plastik',
                'foto_ed_carton_box',
            ]);
        });
    }
};
