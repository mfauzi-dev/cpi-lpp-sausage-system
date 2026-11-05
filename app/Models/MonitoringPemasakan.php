<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringPemasakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'waktu_pemasakan_mulai',
        'waktu_pemasakan_selesai',
        'jumlah_trolly_pcs',
        'cooling_down_waktu',
        'cooling_down_suhu_ruang',
        'cooling_down_suhu_produk',
        'pressure_angin',
        'tekanan_steam_header',
        'smoke_generator',
        'downtime_kerusakan',
        'downtime_waktu',
    ];

    protected $casts = [
        'cooling_down_waktu' => 'decimal:2',
        'cooling_down_suhu_ruang' => 'decimal:2',
        'cooling_down_suhu_produk' => 'decimal:2',
        'pressure_angin' => 'decimal:2',
        'tekanan_steam_header' => 'decimal:2',
        'smoke_generator' => 'decimal:2',
        'downtime_waktu' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
