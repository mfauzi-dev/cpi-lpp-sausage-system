<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PackingLuar extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'proses_freezing',
        'jumlah_input',
        'suhu_iqf',
        'suhu_produk',
        'dweling_time',
        'waktu_awal',
        'waktu_akhir',
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
