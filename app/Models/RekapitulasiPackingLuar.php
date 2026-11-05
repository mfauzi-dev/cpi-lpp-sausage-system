<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RekapitulasiPackingLuar extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'jumlah_batch',
        'jumlah_pack',
        'jumlah_boks',
        'jumlah_kg',
        'no_bstb',
        'jumlah_wip_keluar_bag',
        'jumlah_wip_keluar_kg',
        'tanggal_transfer',
        'wip_masuk',
        'jumlah_wip_masuk',
        'checker',
        'kr',
    ];

    protected $casts = [
        'jumlah_batch' => 'integer',
        'jumlah_pack' => 'decimal:2',
        'jumlah_boks' => 'decimal:2',
        'jumlah_kg' => 'decimal:2',
        'jumlah_wip_keluar_bag' => 'decimal:2',
        'jumlah_wip_keluar_kg' => 'decimal:2',
        'tanggal_transfer' => 'date',
        'jumlah_wip_masuk' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
