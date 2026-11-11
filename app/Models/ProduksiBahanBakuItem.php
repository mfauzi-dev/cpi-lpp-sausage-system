<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProduksiBahanBakuItem extends Model
{
    use HasFactory;

     protected $fillable = [
        'produksi_bahan_baku_id',
        'bahan_baku_id',
        'product_formula_id',
        'kode_batch',
        'best_before',
        'suhu_rm',
    ];

    protected $casts = [
        'best_before' => 'date',
        'suhu_rm' => 'decimal:1',
    ];

    public function produksiBahanBaku()
    {
        return $this->belongsTo(ProduksiBahanBaku::class);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }

    public function productFormula()
    {
        return $this->belongsTo(ProductFormula::class);
    }
}
