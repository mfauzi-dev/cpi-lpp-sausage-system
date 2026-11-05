<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'sampling_ke',
        'berat_per_3pcs',
        'diameter',
        'panjang',
        'berat_per_pcs',
        'berat_kulit',
        'berat_adonan',
        'berat_per_3pcs_akhir',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
