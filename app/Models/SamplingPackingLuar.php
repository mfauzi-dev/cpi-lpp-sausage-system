<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SamplingPackingLuar extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'sampling_ke',
        'berat_per_bok',
        'range_berat',
        'standar_berat',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
