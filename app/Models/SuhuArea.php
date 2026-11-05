<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SuhuArea extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'chillroom_std',
        'chillroom_act',
        'meatprep_std',
        'meatprep_act',
        'cooking_std',
        'cooking_act',
        'seasoning_std',
        'seasoning_act',
        'cooling_down_std',
        'cooling_down_act',
        'packing_dalam_std',
        'packing_dalam_act',
        'packing_luar_std',
        'packing_luar_act',
    ];
 
    protected $casts = [
        'chillroom_std' => 'decimal:2',
        'chillroom_act' => 'decimal:2',
        'meatprep_std' => 'decimal:2',
        'meatprep_act' => 'decimal:2',
        'cooking_std' => 'decimal:2',
        'cooking_act' => 'decimal:2',
        'seasoning_std' => 'decimal:2',
        'seasoning_act' => 'decimal:2',
        'cooling_down_std' => 'decimal:2',
        'cooling_down_act' => 'decimal:2',
        'packing_dalam_std' => 'decimal:2',
        'packing_dalam_act' => 'decimal:2',
        'packing_luar_std' => 'decimal:2',
        'packing_luar_act' => 'decimal:2',
    ];
 
    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
