<?php

namespace App\Exports;

class LaporanPengendalianProdukSausageSheetDelapan extends LaporanPengendalianProdukSausageBaseSheet
{
    protected function sheetNumber(): int
    {
        return 8;
    }

    protected function buildContent($sheet, int $row): int
    {
        $pb = $this->productionBatch;

        $row = $this->table(
            $sheet,
            $row,
            null,
            [
                'Proses Freezing',
                'Jumlah Input',
                'Suhu IQF',
                'Suhu Produk',
                'Dweling Time',
                'Waktu Awal',
                'Waktu Akhir',
                'Downtime Kerusakan',
                'Downtime Waktu',
            ],
            $pb->packingLuars
                ->map(fn ($p) => [
                    $this->val($p->proses_freezing),
                    $this->val($p->jumlah_input),
                    $this->val($p->suhu_iqf),
                    $this->val($p->suhu_produk),
                    $this->val($p->dweling_time),
                    $this->time($p->waktu_awal),
                    $this->time($p->waktu_akhir),
                    $this->val($p->downtime_kerusakan),
                    $this->number($p->downtime_waktu),
                ])
                ->values()
                ->all()
        );

        $parameterPackingLuarList = [
            'Pengisian ke dalam boks',
            'Sealer boks',
            'Check Weigher',
        ];

        $pengemasanByParameter = $pb->pengemasanPackingLuars->keyBy('parameter_packing_luar');

        $row = $this->table(
            $sheet,
            $row,
            null,
            [
                'Parameter Packing Luar',
                'No. Mesin',
                'Petugas',
                'KR',
                'Foreman',
                'Waktu Awal',
                'Waktu Akhir',
            ],
            collect($parameterPackingLuarList)
                ->map(function ($parameter) use ($pengemasanByParameter) {
                    $p = $pengemasanByParameter->get($parameter);

                    return [
                        $this->val($parameter),
                        $this->val($p->no_mesin ?? null),
                        $this->val($p->petugas ?? null),
                        $this->val($p->kr ?? null),
                        $this->val($p->foreman ?? null),
                        $this->time($p->waktu_awal ?? null),
                        $this->time($p->waktu_akhir ?? null),
                    ];
                })
                ->values()
                ->all()
        );

        $row = $this->verticalTable(
            $sheet,
            $row,
            'Sampling Ke',
            [
                'Berat / Bok' => fn ($s) => $this->number($s->berat_per_bok),
                'Range Berat' => fn ($s) => $this->val($s->range_berat),
                'Standar Berat' => fn ($s) => $this->val($s->standar_berat),
            ],
            $pb->samplingPackingLuars->sortBy('sampling_ke'),
            fn ($s) => $s->sampling_ke
        );

        $row = $this->table(
            $sheet,
            $row,
            null,
            [
                'Jumlah Batch',
                'Jumlah Pack',
                'Jumlah Boks',
                'Jumlah Kg',
                'No. BSTB',
                'WIP Keluar (Bag)',
                'WIP Keluar (Kg)',
                'Tanggal Transfer',
                'WIP Masuk',
                'Jumlah WIP Masuk',
                'Checker',
                'KR',
            ],
            $pb->rekapitulasiPackingLuars
                ->map(fn ($r) => [
                    $this->val($r->jumlah_batch),
                    $this->number($r->jumlah_pack),
                    $this->number($r->jumlah_boks),
                    $this->number($r->jumlah_kg),
                    $this->val($r->no_bstb),
                    $this->number($r->jumlah_wip_keluar_bag),
                    $this->number($r->jumlah_wip_keluar_kg),
                    $this->date($r->tanggal_transfer),
                    $this->val($r->wip_masuk),
                    $this->number($r->jumlah_wip_masuk),
                    $this->val($r->checker),
                    $this->val($r->kr),
                ])
                ->values()
                ->all()
        );

        return $this->table(
            $sheet,
            $row,
            null,
            ['Jenis Karton Box', 'Qty Box', 'Pemakaian', 'Sisa', 'Reject'],
            $pb->kartonBoxPackingLuar
                ->map(fn ($k) => [
                    $this->val($k->jenis_karton_box),
                    $this->number($k->qty_box),
                    $this->number($k->pemakaian),
                    $this->number($k->sisa),
                    $this->number($k->reject),
                ])
                ->values()
                ->all()
        );
    }
}