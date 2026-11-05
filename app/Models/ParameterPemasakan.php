<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ParameterPemasakan extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'penggunaan_mesin',
        'drying_1_suhu',
        'drying_1_rh',
        'drying_1_waktu',
        'drying_2_suhu',
        'drying_2_rh',
        'drying_2_waktu',
        'drying_3_suhu',
        'drying_3_rh',
        'drying_3_waktu',
        'cooking_suhu',
        'cooking_rh',
        'cooking_waktu',
        'smoke_suhu',
        'smoke_rh',
        'smoke_waktu',
        'drying_4_suhu',
        'drying_4_rh',
        'drying_4_waktu',
        'suhu_produk_matang',
    ];

    protected $casts = [
        'drying_1_suhu' => 'decimal:2',
        'drying_1_rh' => 'decimal:2',
        'drying_1_waktu' => 'decimal:2',
        'drying_2_suhu' => 'decimal:2',
        'drying_2_rh' => 'decimal:2',
        'drying_2_waktu' => 'decimal:2',
        'drying_3_suhu' => 'decimal:2',
        'drying_3_rh' => 'decimal:2',
        'drying_3_waktu' => 'decimal:2',
        'cooking_suhu' => 'decimal:2',
        'cooking_rh' => 'decimal:2',
        'cooking_waktu' => 'decimal:2',
        'smoke_suhu' => 'decimal:2',
        'smoke_rh' => 'decimal:2',
        'smoke_waktu' => 'decimal:2',
        'drying_4_suhu' => 'decimal:2',
        'drying_4_rh' => 'decimal:2',
        'drying_4_waktu' => 'decimal:2',
        'suhu_produk_matang' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
