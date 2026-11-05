<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PenggunaanMesin extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'name',
        'speed_machine',
        'ukuran_holeplate_knife',
        'linker',
        'stuffing_tube',
        'twisting',
        'chuck',
        'waktu_mulai',
        'waktu_selesai',
        'downtime_kerusakan',
        'downtime_lama_waktu',
    ];

    protected $casts = [
        'speed_machine' => 'decimal:2',
        'downtime_lama_waktu' => 'decimal:2',
        'waktu_mulai' => 'datetime:H:i',
        'waktu_selesai' => 'datetime:H:i',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
