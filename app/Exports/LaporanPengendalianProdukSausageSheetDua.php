<?php

namespace App\Exports;

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
            null,
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

        $row = $this->table(
            $sheet,
            $row,
            null,
            ['Sampling Ke', 'Diameter', 'Panjang', 'Berat / Pcs', 'Berat Kulit', 'Berat Adonan'],
            $pb->standarParameterProduks
                ->map(fn ($s) => [
                    $this->val($s->sampling_ke),
                    $this->number($s->diameter),
                    $this->number($s->panjang),
                    $this->number($s->berat_per_pcs),
                    $this->number($s->berat_kulit),
                    $this->number($s->berat_adonan),
                ])
                ->values()
                ->all()
        );

        return $this->table(
            $sheet,
            $row,
            null,
            [
                'Sampling Ke',
                'Berat / 3 Pcs',
                'Diameter',
                'Panjang',
                'Berat / Pcs',
                'Berat Kulit',
                'Berat Adonan',
                'Berat / 3 Pcs Akhir',
            ],
            $pb->parameterProduks
                ->map(fn ($p) => [
                    $this->val($p->sampling_ke),
                    $this->number($p->berat_per_3pcs),
                    $this->number($p->diameter),
                    $this->number($p->panjang),
                    $this->number($p->berat_per_pcs),
                    $this->number($p->berat_kulit),
                    $this->number($p->berat_adonan),
                    $this->number($p->berat_per_3pcs_akhir),
                ])
                ->values()
                ->all()
        );
    }
}