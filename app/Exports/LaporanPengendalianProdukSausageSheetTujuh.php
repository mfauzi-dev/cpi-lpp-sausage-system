<?php

namespace App\Exports;

class LaporanPengendalianProdukSausageSheetTujuh extends LaporanPengendalianProdukSausageBaseSheet
{
    protected function sheetNumber(): int
    {
        return 7;
    }

    protected function buildContent($sheet, int $row): int
    {
        $pb = $this->productionBatch;

        // Judul untuk tabel vertikal (Reject Packing)
        $this->sectionTitle($sheet, $row, 'REJECT PACKING');
        $row++;

        $row = $this->verticalTable(
            $sheet,
            $row,
            'Reject Packing',
            [
                'Lepas Twisting' => fn ($r) => $this->number($r->lepas_twisting_packing),
                'Jatuh' => fn ($r) => $this->number($r->jatuh_packing),
                'Potong' => fn ($r) => $this->number($r->potong_packing),
                'Total Rijek Packing (Kg)' => fn ($r) => $this->number($r->total_rijek_packing_kg),
            ],
            $pb->rejects
        );

        $jenisList = ['Metal Detector', 'Fe / Sus / Non Fe', 'Timbangan'];

        $metalDetectorByJenis = $pb->metalDetectors->keyBy('jenis_pemeriksaan');

        return $this->table(
            $sheet,
            $row,
            'METAL DETECTOR',
            [
                'Jenis Pemeriksaan',
                'No. Mesin',
                'Petugas',
                'Foreman',
                'KR',
                'Waktu Awal',
                'Waktu Akhir',
            ],
            collect($jenisList)
                ->map(function ($jenis) use ($metalDetectorByJenis) {
                    $m = $metalDetectorByJenis->get($jenis);

                    return [
                        $this->val($jenis),
                        $this->val($m->no_mesin ?? null),
                        $this->val($m->petugas ?? null),
                        $this->val($m->foreman ?? null),
                        $this->val($m->kr ?? null),
                        $this->time($m->waktu_awal ?? null),
                        $this->time($m->waktu_akhir ?? null),
                    ];
                })
                ->values()
                ->all()
        );
    }
}