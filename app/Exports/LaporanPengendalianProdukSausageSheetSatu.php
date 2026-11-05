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
                null,
                ['Bahan Baku', 'Kode Batch', 'Best Before', 'Total Kg', 'Suhu RM', 'Formula'],
                []
            );
        }

        foreach ($records as $record) {
            $rows = $record->items
                ->map(fn ($item) => [
                    $this->val($item->bahanBaku->name ?? null),
                    $this->val($item->kode_batch),
                    $this->date($item->best_before),
                    $this->number($item->total_kg),
                    $this->number($item->suhu_rm),
                    // Sesuaikan kolom formula kalau bukan `qty`
                    $this->number($item->productFormula->qty ?? null),
                ])
                ->values()
                ->all();

            $row = $this->table(
                $sheet,
                $row,
                null,
                ['Bahan Baku', 'Kode Batch', 'Best Before', 'Total Kg', 'Suhu RM', 'Formula'],
                $rows
            );

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
        }

        return $row;
    }
}