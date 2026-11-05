<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class KartonBoxPackingLuar extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'jenis_karton_box',
        'qty_box',
        'pemakaian',
        'sisa',
        'reject',
    ];

    protected $casts = [
        'qty_box' => 'decimal:2',
        'pemakaian' => 'decimal:2',
        'sisa' => 'decimal:2',
        'reject' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
