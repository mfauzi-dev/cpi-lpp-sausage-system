<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reject extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'lepas_twisting_cooking',
        'lepas_twisting_packing',
        'jatuh_cooking',
        'jatuh_packing',
        'potong_cooking',
        'potong_packing',
        'total_rijek_cooking_kg',
        'total_rijek_packing_kg',
    ];

    protected $casts = [
        'lepas_twisting_cooking' => 'decimal:2',
        'lepas_twisting_packing' => 'decimal:2',
        'jatuh_cooking' => 'decimal:2',
        'jatuh_packing' => 'decimal:2',
        'potong_cooking' => 'decimal:2',
        'potong_packing' => 'decimal:2',
        'total_rijek_cooking_kg' => 'decimal:2',
        'total_rijek_packing_kg' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
