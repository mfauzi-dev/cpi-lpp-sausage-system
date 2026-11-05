<?php

namespace App\Exports;

class LaporanPengendalianProdukSausageSheetEnam extends LaporanPengendalianProdukSausageBaseSheet
{
    protected function sheetNumber(): int
    {
        return 6;
    }

    protected function buildContent($sheet, int $row): int
    {
        $pb = $this->productionBatch;

        $row = $this->table(
            $sheet,
            $row,
            null,
            ['Jenis Plastik', 'No. MD', 'Qty Pack', 'Pemakaian', 'Sisa', 'Reject Plastik'],
            $pb->pengemasanPlastikPackingDalams
                ->map(fn ($p) => [
                    $this->val($p->jenis_plastik),
                    $this->val($p->no_md),
                    $this->val($p->qty_pack),
                    $this->number($p->pemakaian),
                    $this->number($p->sisa),
                    $this->number($p->reject_plastik),
                ])
                ->values()
                ->all()
        );

        return $this->table(
            $sheet,
            $row,
            null,
            ['Sampling Ke', 'Berat Kemasan', 'Berat / Bag', 'Range Berat', 'Standar Berat'],
            $pb->samplingPackingDalams
                ->map(fn ($s) => [
                    $this->val($s->sampling_ke),
                    $this->number($s->berat_kemasan),
                    $this->number($s->berat_per_bag),
                    $this->val($s->range_berat),
                    $this->val($s->standar_berat),
                ])
                ->values()
                ->all()
        );
    }
}