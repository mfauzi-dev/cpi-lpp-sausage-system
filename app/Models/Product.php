<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    public function formulas()
    {
        return $this->hasMany(ProductFormula::class);
    }

    public function standarParameterProduks()
    {
        return $this->hasMany(StandarParameterProduk::class);
    }
}
