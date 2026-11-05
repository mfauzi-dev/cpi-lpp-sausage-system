<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarParameterProduk extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'sampling_ke',
        'diameter',
        'panjang',
        'berat_per_pcs',
        'berat_kulit',
        'berat_adonan',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
