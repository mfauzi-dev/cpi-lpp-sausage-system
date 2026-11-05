<?php

namespace App\Exports;

use App\Models\ProductionBatch;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class LaporanPengendalianProdukSausageExport implements WithMultipleSheets
{
    protected int $productionBatchId;

    protected ?ProductionBatch $productionBatch = null;

    public function __construct(int $productionBatchId)
    {
        $this->productionBatchId = $productionBatchId;

        $this->productionBatch = ProductionBatch::with([
            'product',
            'produksiBahanBaku.items.bahanBaku',
            'produksiBahanBaku.items.productFormula',
            'pengguaanMesins',
            'standarParameterProduks',
            'parameterProduks',
            'rejects',
            'suhuAreas',
            'parameterPemasakans',
            'monitoringPemasakans',
            'monitoringLineBasos',
            'packingDalams',
            'standarMesinPackingDalams',
            'pengemasanPlastikPackingDalams',
            'samplingPackingDalams',
            'metalDetectors',
            'packingLuars',
            'pengemasanPackingLuars',
            'samplingPackingLuars',
            'rekapitulasiPackingLuars',
            'kartonBoxPackingLuar',
        ])->findOrFail($productionBatchId);
    }

    public function sheets(): array
    {
        return [
            new LaporanPengendalianProdukSausageSheetSatu($this->productionBatch),
            new LaporanPengendalianProdukSausageSheetDua($this->productionBatch),
            new LaporanPengendalianProdukSausageSheetTiga($this->productionBatch),
            new LaporanPengendalianProdukSausageSheetEmpat($this->productionBatch),
            new LaporanPengendalianProdukSausageSheetLima($this->productionBatch),
            new LaporanPengendalianProdukSausageSheetEnam($this->productionBatch),
            new LaporanPengendalianProdukSausageSheetTujuh($this->productionBatch),
            new LaporanPengendalianProdukSausageSheetDelapan($this->productionBatch),
        ];
    }
}