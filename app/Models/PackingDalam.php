<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingDalam extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'petugas_pengemasan',
        'line_manual_single',
        'line_manual_dimsum',
        'line_manual_baso',
        'line_thermoforming_1',
        'line_thermoforming_2',
        'line_thermoforming_3',
        'waktu_pengemasan_awal',
        'waktu_pengemasan_akhir',
        'downtime_kerusakan',
        'downtime_waktu',
    ];

    protected $casts = [
        'downtime_waktu' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
