<?php

namespace App\Exports;

use PhpOffice\PhpSpreadsheet\Cell\DataType;

class LaporanPengendalianProdukSausageSheetDua extends LaporanPengendalianProdukSausageBaseSheet
{
    protected function sheetNumber(): int
    {
        return 2;
    }

    protected function buildContent($sheet, int $row): int
    {
        $pb = $this->productionBatch;

        $row = $this->table(
            $sheet,
            $row,
            'PENGGUNAAN MESIN',
            [
                'Nama Mesin',
                'Speed Machine',
                'Ukuran Holeplate / Knife',
                'Linker',
                'Stuffing Tube',
                'Twisting',
                'Chuck',
                'Waktu Mulai',
                'Waktu Selesai',
                'Downtime Kerusakan',
                'Downtime Lama Waktu',
            ],
            $pb->pengguaanMesins
                ->map(fn ($m) => [
                    $this->val($m->name),
                    $this->number($m->speed_machine),
                    $this->val($m->ukuran_holeplate_knife),
                    $this->val($m->linker),
                    $this->val($m->stuffing_tube),
                    $this->val($m->twisting),
                    $this->val($m->chuck),
                    $this->time($m->waktu_mulai),
                    $this->time($m->waktu_selesai),
                    $this->val($m->downtime_kerusakan),
                    $this->number($m->downtime_lama_waktu),
                ])
                ->values()
                ->all()
        );

        // ------------------------------------------------------------------
        // PARAMETER PRODUK (Standar + Aktual per sampling, seperti halaman detail)
        // ------------------------------------------------------------------
        $parameterBySampling = [];

        foreach ($pb->parameterProduks as $p) {
            $parameterBySampling[(int) $p->sampling_ke] = $p;
        }

        $standarBySampling = [];

        foreach ($pb->standarParameterProduks as $s) {
            $standarBySampling[(int) $s->sampling_ke] = $s;
        }

        $this->sectionTitle($sheet, $row, 'PARAMETER PRODUK');

        $row++;

        $headerRow1 = $row;
        $headerRow2 = $row + 1;

        // [kolom awal, kolom akhir, label, digabung 2 baris?]
        $groupHeaders = [
            ['A', 'B', 'Sampling Ke', true],
            ['C', 'E', 'Berat / 3 Pcs (gr)', true],
            ['F', 'G', 'Diameter (mm)', false],
            ['H', 'I', 'Panjang (cm)', false],
            ['J', 'K', 'Berat per Pcs (gr)', false],
            ['L', 'M', 'Berat Kulit (gr)', false],
            ['N', 'O', 'Berat Adonan (gr)', false],
            ['P', 'R', 'Berat per 3 Pcs Akhir (gr)', true],
        ];

        foreach ($groupHeaders as $header) {
            $start = $header[0];
            $end = $header[1];
            $label = $header[2];
            $rowspan = $header[3];

            $endRow = $headerRow1;

            if ($rowspan) {
                $endRow = $headerRow2;
            }

            if ($start !== $end || $rowspan) {
                $sheet->mergeCells("{$start}{$headerRow1}:{$end}{$endRow}");
            }

            $sheet->setCellValueExplicit(
                "{$start}{$headerRow1}",
                $label,
                DataType::TYPE_STRING
            );
        }

        $subHeaders = [
            'F' => 'Standar',
            'G' => 'Aktual',
            'H' => 'Standar',
            'I' => 'Aktual',
            'J' => 'Standar',
            'K' => 'Aktual',
            'L' => 'Standar',
            'M' => 'Aktual',
            'N' => 'Standar',
            'O' => 'Aktual',
        ];

        foreach ($subHeaders as $col => $label) {
            $sheet->setCellValueExplicit(
                "{$col}{$headerRow2}",
                $label,
                DataType::TYPE_STRING
            );
        }

        $this->styleRow($sheet, $headerRow1, 12, true);
        $this->styleRow($sheet, $headerRow2, 12, true);

        $sheet->getRowDimension($headerRow1)->setRowHeight(34);
        $sheet->getRowDimension($headerRow2)->setRowHeight(30);

        $row = $headerRow2 + 1;

        for ($i = 1; $i <= 5; $i++) {
            $standar = null;

            if (isset($standarBySampling[$i])) {
                $standar = $standarBySampling[$i];
            }

            $parameterProduk = null;

            if (isset($parameterBySampling[$i])) {
                $parameterProduk = $parameterBySampling[$i];
            }

            $standarDiameter = '-';
            $standarPanjang = '-';
            $standarBeratPerPcs = '-';
            $standarBeratKulit = '-';
            $standarBeratAdonan = '-';

            if ($standar) {
                $standarDiameter = $this->number($standar->diameter);
                $standarPanjang = $this->number($standar->panjang);
                $standarBeratPerPcs = $this->number($standar->berat_per_pcs);
                $standarBeratKulit = $this->number($standar->berat_kulit);
                $standarBeratAdonan = $this->number($standar->berat_adonan);
            }

            $aktualBeratPer3Pcs = '-';
            $aktualDiameter = '-';
            $aktualPanjang = '-';
            $aktualBeratPerPcs = '-';
            $aktualBeratKulit = '-';
            $aktualBeratAdonan = '-';
            $aktualBeratPer3PcsAkhir = '-';

            if ($parameterProduk) {
                $aktualBeratPer3Pcs = $this->number($parameterProduk->berat_per_3pcs);
                $aktualDiameter = $this->number($parameterProduk->diameter);
                $aktualPanjang = $this->number($parameterProduk->panjang);
                $aktualBeratPerPcs = $this->number($parameterProduk->berat_per_pcs);
                $aktualBeratKulit = $this->number($parameterProduk->berat_kulit);
                $aktualBeratAdonan = $this->number($parameterProduk->berat_adonan);
                $aktualBeratPer3PcsAkhir = $this->number($parameterProduk->berat_per_3pcs_akhir);
            }

            // [kolom awal, kolom akhir, nilai, tebal?]
            $cells = [
                ['A', 'B', (string) $i, true],
                ['C', 'E', $aktualBeratPer3Pcs, false],
                ['F', 'F', $standarDiameter, false],
                ['G', 'G', $aktualDiameter, true],
                ['H', 'H', $standarPanjang, false],
                ['I', 'I', $aktualPanjang, true],
                ['J', 'J', $standarBeratPerPcs, false],
                ['K', 'K', $aktualBeratPerPcs, true],
                ['L', 'L', $standarBeratKulit, false],
                ['M', 'M', $aktualBeratKulit, true],
                ['N', 'N', $standarBeratAdonan, false],
                ['O', 'O', $aktualBeratAdonan, true],
                ['P', 'R', $aktualBeratPer3PcsAkhir, false],
            ];

            foreach ($cells as $cell) {
                $start = $cell[0];
                $end = $cell[1];
                $value = $cell[2];

                if ($start !== $end) {
                    $sheet->mergeCells("{$start}{$row}:{$end}{$row}");
                }

                $sheet->setCellValueExplicit(
                    "{$start}{$row}",
                    (string) $value,
                    DataType::TYPE_STRING
                );
            }

            $this->styleRow($sheet, $row, 11, false);

            // Kolom Aktual dan Sampling Ke dibuat tebal (setelah styleRow)
            foreach ($cells as $cell) {
                $start = $cell[0];
                $bold = $cell[3];

                if ($bold) {
                    $sheet->getStyle("{$start}{$row}")->getFont()->setBold(true);
                }
            }

            $sheet->getRowDimension($row)->setRowHeight(30);

            $row++;
        }

        return $row + 1;
    }
}