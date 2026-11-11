<?php

namespace App\Exports;

class LaporanPengendalianProdukSausageSheetLima extends LaporanPengendalianProdukSausageBaseSheet
{
    protected function sheetNumber(): int
    {
        return 5;
    }

    protected function buildContent($sheet, int $row): int
    {
        $pb = $this->productionBatch;

        $row = $this->table(
            $sheet,
            $row,
            'PACKING DALAM',
            [
                'Petugas Pengemasan',
                'Manual Single',
                'Manual Dimsum',
                'Manual Baso',
                'Thermoforming 1',
                'Thermoforming 2',
                'Thermoforming 3',
                'Waktu Pengemasan Awal',
                'Waktu Pengemasan Akhir',
                'Downtime Kerusakan',
                'Downtime Waktu',
            ],
            $pb->packingDalams
                ->map(fn ($p) => [
                    $this->val($p->petugas_pengemasan),
                    $this->val($p->line_manual_single),
                    $this->val($p->line_manual_dimsum),
                    $this->val($p->line_manual_baso),
                    $this->val($p->line_thermoforming_1),
                    $this->val($p->line_thermoforming_2),
                    $this->val($p->line_thermoforming_3),
                    $this->time($p->waktu_pengemasan_awal),
                    $this->time($p->waktu_pengemasan_akhir),
                    $this->val($p->downtime_kerusakan),
                    $this->number($p->downtime_waktu),
                ])
                ->values()
                ->all()
        );

        $parameterList = [
            'Speed',
            'Tekanan',
            'Seal',
            'Angin',
            'Suhu Forming (°C)',
            'Vacuum Forming Time (s)',
            'Air Forming Time (s)',
            'Forming Ventilation Time (s)',
            'Suhu Sealing (°C)',
            'Sealing Time (s)',
            'Vacuum Time (mbar)',
            'Penggunaan Filler Plate',
            'Cycle',
        ];

        $standarByParameter = $pb->standarMesinPackingDalams->keyBy('parameter_mesin');

        return $this->table(
            $sheet,
            $row,
            'STANDAR MESIN PACKING DALAM',
            [
                'Parameter Mesin',
                'Sausage Cutter',
                'Vacuum Pack',
                'Thermoforming',
            ],
            collect($parameterList)
                ->map(function ($parameter) use ($standarByParameter) {
                    $s = $standarByParameter->get($parameter);

                    return [
                        $this->val($parameter),
                        $this->val($s->penggunaan_mesin_sausage_cutter ?? null),
                        $this->val($s->penggunaan_mesin_vacuum_pack ?? null),
                        $this->val($s->penggunaan_mesin_thermoforming ?? null),
                    ];
                })
                ->values()
                ->all()
        );
    }
}