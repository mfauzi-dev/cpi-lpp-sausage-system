<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonitoringLineBaso extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'line_baso',
        'parameter_pemasakan_suhu_air',
        'parameter_pemasakan_suhu_produk',
        'parameter_pemasakan_bentuk',
        'waktu_forming_mulai',
        'waktu_forming_selesai',
        'cooling_down_mulai',
        'cooling_down_selesai',
        'suhu_produk_matang',
    ];

    protected $casts = [
        'parameter_pemasakan_suhu_air' => 'decimal:2',
        'parameter_pemasakan_suhu_produk' => 'decimal:2',
        'suhu_produk_matang' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
