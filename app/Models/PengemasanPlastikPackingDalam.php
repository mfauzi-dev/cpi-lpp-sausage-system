<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PengemasanPlastikPackingDalam extends Model
{
    use HasFactory;

    protected $fillable = [
        'production_batch_id',
        'jenis_plastik',
        'no_md',
        'qty_pack',
        'pemakaian',
        'sisa',
        'reject_plastik',
    ];

    protected $casts = [
        'qty_pack' => 'integer',
        'pemakaian' => 'decimal:2',
        'sisa' => 'decimal:2',
        'reject_plastik' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }
}
