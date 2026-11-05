<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductFormula extends Model
{
    use HasFactory;

    protected $fillable = ['product_id', 'bahan_baku_id', 'multiplier', 'qty'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function bahanBaku()
    {
        return $this->belongsTo(BahanBaku::class);
    }
}
