<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductionBatch extends Model
{
    use HasFactory;

    protected $fillable = [
        'hari',
        'tanggal',
        'product_id',
        'kode_batch',
        'yield_meat',
        'total_meat',
        'shift',
    ];

    protected $casts = [
        'tanggal' => 'date',
        'yield_meat' => 'decimal:3',
        'total_meat' => 'decimal:3',
        'shift' => 'integer',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function produksiBahanBaku()
    {
        return $this->hasMany(ProduksiBahanBaku::class);
    }

    public function pengguaanMesins()
    {
        return $this->hasMany(PenggunaanMesin::class);
    }

    public function parameterProduks()
    {
        return $this->hasMany(ParameterProduk::class, 'production_batch_id');
    }

    public function standarParameterProduks()
    {
        return $this->hasMany(StandarParameterProduk::class);
    }

    public function rejects()
    {
        return $this->hasMany(Reject::class);
    }

    public function suhuAreas()
    {
        return $this->hasMany(SuhuArea::class);
    }

    public function parameterPemasakans()
    {
        return $this->hasMany(ParameterPemasakan::class);
    }

    public function monitoringPemasakans()
    {
        return $this->hasMany(MonitoringPemasakan::class);
    }

    public function monitoringLineBasos()
    {
        return $this->hasMany(MonitoringLineBaso::class);
    }

    public function packingDalams()
    {
        return $this->hasMany(PackingDalam::class);
    }

    public function standarMesinPackingDalams()
    {
        return $this->hasMany(StandarMesinPackingDalam::class);
    }

    public function pengemasanPlastikPackingDalams()
    {
        return $this->hasMany(PengemasanPlastikPackingDalam::class);
    }

    public function metalDetectors()
    {
        return $this->hasMany(MetalDetector::class);
    }

    public function samplingPackingDalams()
    {
        return $this->hasMany(SamplingPackingDalam::class);
    }

    public function packingLuars()
    {
        return $this->hasMany(PackingLuar::class);
    }

    public function pengemasanPackingLuars()
    {
        return $this->hasMany(PengemasanPackingLuar::class);
    }

    public function samplingPackingLuars()
    {
        return $this->hasMany(SamplingPackingLuar::class);
    }

    public function rekapitulasiPackingLuars()
    {
        return $this->hasMany(RekapitulasiPackingLuar::class);
    }

    public function kartonBoxPackingLuar()
    {
        return $this->hasMany(KartonBoxPackingLuar::class);
    }
}
