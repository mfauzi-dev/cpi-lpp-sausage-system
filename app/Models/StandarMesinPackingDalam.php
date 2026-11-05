<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class StandarMesinPackingDalam extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'parameter_mesin',
        'penggunaan_mesin_sausage_cutter',
        'penggunaan_mesin_vacuum_pack',
        'penggunaan_mesin_thermoforming',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
