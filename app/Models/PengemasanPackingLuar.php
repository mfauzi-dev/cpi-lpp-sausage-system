<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengemasanPackingLuar extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'parameter_packing_luar',
        'no_mesin',
        'petugas',
        'kr',
        'foreman',
        'waktu_awal',
        'waktu_akhir',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
