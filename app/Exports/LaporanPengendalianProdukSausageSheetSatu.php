<?php

namespace App\Exports;

class LaporanPengendalianProdukSausageSheetSatu extends LaporanPengendalianProdukSausageBaseSheet
{
    protected function sheetNumber(): int
    {
        return 1;
    }

    protected function buildContent($sheet, int $row): int
    {
        $records = $this->productionBatch->produksiBahanBaku;

        if ($records->isEmpty()) {
            return $this->table(
                $sheet,
                $row,
                'PRODUKSI BAHAN BAKU',
                ['Bahan Baku', 'Formula', 'Total Kg', 'Kode Batch', 'Best Before', 'Suhu RM'],
                []
            );
        }

        $jumlahRecord = $records->count();
        $no = 1;

        foreach ($records as $record) {
            $judul = 'PRODUKSI BAHAN BAKU';

            if ($jumlahRecord > 1) {
                $judul = 'PRODUKSI BAHAN BAKU ' . $no;
            }

            $rows = $record->items
                ->map(fn ($item) => [
                    $this->val($item->bahanBaku->name ?? null),
                    $this->val($item->productFormula->multiplier ?? null),
                    $this->number($item->productFormula->total_kg),
                    $this->val($item->kode_batch),
                    $this->date($item->best_before),
                    $this->number($item->suhu_rm),
                ])
                ->values()
                ->all();

            $row = $this->table(
                $sheet,
                $row,
                $judul,
                ['Bahan Baku', 'Formula', 'Total Kg', 'Kode Batch', 'Best Before','Suhu RM',],
                $rows
            );

            // Tabel Total / Penggunaan / Sisa menempel di bawah tabel bahan baku,
            // jadi tidak diberi judul sendiri.
            $row = $this->table(
                $sheet,
                $row - 1,
                null,
                ['Total', 'Penggunaan', 'Sisa'],
                [[
                    $this->number($record->total),
                    $this->number($record->penggunaan),
                    $this->number($record->sisa),
                ]]
            );

            $no++;
        }

        return $row;
    }
}