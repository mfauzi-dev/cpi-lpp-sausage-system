<?php

namespace App\Exports;

class LaporanPengendalianProdukSausageSheetTiga extends LaporanPengendalianProdukSausageBaseSheet
{
    protected function sheetNumber(): int
    {
        return 3;
    }

    protected function buildContent($sheet, int $row): int
    {
        $pb = $this->productionBatch;

        // Judul untuk tabel vertikal (Reject Cooking)
        $this->sectionTitle($sheet, $row, 'REJECT COOKING');
        $row++;

        $row = $this->verticalTable(
            $sheet,
            $row,
            'Reject Cooking',
            [
                'Lepas Twisting' => fn ($r) => $this->number($r->lepas_twisting_cooking),
                'Jatuh' => fn ($r) => $this->number($r->jatuh_cooking),
                'Potong' => fn ($r) => $this->number($r->potong_cooking),
                'Total Rijek Cooking (Kg)' => fn ($r) => $this->number($r->total_rijek_cooking_kg),
            ],
            $pb->rejects
        );

        $suhu = $pb->suhuAreas->first();

        $areas = [
            'Chillroom' => 'chillroom',
            'Meat Prep' => 'meatprep',
            'Cooking' => 'cooking',
            'Seasoning' => 'seasoning',
            'Cooling Down' => 'cooling_down',
            'Packing Dalam' => 'packing_dalam',
            'Packing Luar' => 'packing_luar',
        ];

        $suhuRows = [];

        if ($suhu) {
            foreach ($areas as $label => $key) {
                $suhuRows[] = [
                    $label,
                    $this->number($suhu->{$key . '_std'}),
                    $this->number($suhu->{$key . '_act'}),
                ];
            }
        }

        return $this->table(
            $sheet,
            $row,
            'SUHU AREA',
            ['Suhu Area', 'Standar', 'Aktual'],
            $suhuRows
        );
    }
}