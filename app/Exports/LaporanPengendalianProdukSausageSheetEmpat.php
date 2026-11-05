<?php

namespace App\Exports;

class LaporanPengendalianProdukSausageSheetEmpat extends LaporanPengendalianProdukSausageBaseSheet
{
    protected function sheetNumber(): int
    {
        return 4;
    }

    protected function buildContent($sheet, int $row): int
    {
        $pb = $this->productionBatch;

        $stages = [
            'Drying 1' => 'drying_1',
            'Drying 2' => 'drying_2',
            'Drying 3' => 'drying_3',
            'Cooking' => 'cooking',
            'Smoke' => 'smoke',
            'Drying 4' => 'drying_4',
        ];

        if ($pb->parameterPemasakans->isEmpty()) {
            $row = $this->table(
                $sheet,
                $row,
                null,
                ['Parameter Pemasakan', 'Suhu', 'RH', 'Waktu'],
                []
            );
        }

        foreach ($pb->parameterPemasakans as $p) {
            $rows = [];

            foreach ($stages as $label => $key) {
                $rows[] = [
                    $label,
                    $this->number($p->{$key . '_suhu'}),
                    $this->number($p->{$key . '_rh'}),
                    $this->number($p->{$key . '_waktu'}),
                ];
            }

            $rows[] = [
                'Suhu Produk Matang',
                $this->number($p->suhu_produk_matang),
                '-',
                '-',
            ];

            $row = $this->table(
                $sheet,
                $row,
                null,
                ['Parameter Pemasakan - ' . $this->val($p->penggunaan_mesin), 'Suhu', 'RH', 'Waktu'],
                $rows
            );
        }

        $row = $this->table(
            $sheet,
            $row,
            null,
            [
                'Waktu Mulai',
                'Waktu Selesai',
                'Jumlah Trolly (Pcs)',
                'Cooling Down Waktu',
                'Suhu Ruang',
                'Suhu Produk',
                'Pressure Angin',
                'Tekanan Steam Header',
                'Smoke Generator',
                'Downtime Kerusakan',
                'Downtime Waktu',
            ],
            $pb->monitoringPemasakans
                ->map(fn ($m) => [
                    $this->time($m->waktu_pemasakan_mulai),
                    $this->time($m->waktu_pemasakan_selesai),
                    $this->val($m->jumlah_trolly_pcs),
                    $this->number($m->cooling_down_waktu),
                    $this->number($m->cooling_down_suhu_ruang),
                    $this->number($m->cooling_down_suhu_produk),
                    $this->number($m->pressure_angin),
                    $this->number($m->tekanan_steam_header),
                    $this->number($m->smoke_generator),
                    $this->val($m->downtime_kerusakan),
                    $this->number($m->downtime_waktu),
                ])
                ->values()
                ->all()
        );

        return $this->table(
            $sheet,
            $row,
            null,
            [
                'Line Baso',
                'Suhu Air',
                'Suhu Produk',
                'Bentuk',
                'Forming Mulai',
                'Forming Selesai',
                'Cooling Down Mulai',
                'Cooling Down Selesai',
                'Suhu Produk Matang',
            ],
            $pb->monitoringLineBasos
                ->map(fn ($m) => [
                    $this->val($m->line_baso),
                    $this->number($m->parameter_pemasakan_suhu_air),
                    $this->number($m->parameter_pemasakan_suhu_produk),
                    $this->val($m->parameter_pemasakan_bentuk),
                    $this->time($m->waktu_forming_mulai),
                    $this->time($m->waktu_forming_selesai),
                    $this->time($m->cooling_down_mulai),
                    $this->time($m->cooling_down_selesai),
                    $this->number($m->suhu_produk_matang),
                ])
                ->values()
                ->all()
        );
    }
}