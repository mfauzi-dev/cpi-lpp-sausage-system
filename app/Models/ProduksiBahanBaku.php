<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiBahanBaku extends Model
{
    use HasFactory;

    protected $fillable = ['production_batch_id', 'total', 'penggunaan', 'sisa'];

    protected $casts = [
        'total' => 'decimal:2',
        'penggunaan' => 'decimal:2',
        'sisa' => 'decimal:2',
    ];

    public function productionBatch()
    {
        return $this->belongsTo(ProductionBatch::class);
    }

    public function items()
    {
        return $this->hasMany(ProduksiBahanBakuItem::class);
    }
}
