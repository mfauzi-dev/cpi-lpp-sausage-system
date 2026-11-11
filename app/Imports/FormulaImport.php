<?php

namespace App\Imports;

use App\Models\BahanBaku;
use App\Models\ProductFormula;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;

class FormulaImport implements ToCollection, WithMultipleSheets
{
    protected int $productId;
    protected int $sheetCount;
    protected int $imported = 0;
    protected int $skipped = 0;
    protected int $blocksFound = 0;

    public function __construct(int $productId, int $sheetCount = 1)
    {
        $this->productId = $productId;
        $this->sheetCount = max(1, $sheetCount); // minimal 1, jaga-jaga
    }

    public function sheets(): array
    {
        $map = [];
        for ($i = 0; $i < $this->sheetCount; $i++) {
            $map[$i] = $this;
        }
        return $map;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            return;
        }

        foreach ($rows as $r => $row) {
            $labelCol = $this->findFormulaLabelCol($row);

            if ($labelCol === null) {
                continue;
            }

            $this->parseBlock($rows, $r, $labelCol);
        }
    }

    protected function parseBlock(Collection $rows, int $headerRow, int $labelCol): void
    {
        $headerRowData = $rows->get($headerRow);

        $versionCols = [];
        $c = $labelCol + 1;
        while ($this->isNumeric($headerRowData->get($c))) {
            $versionCols[$c] = (int) $this->parseNumber($headerRowData->get($c));
            $c++;
        }

        if (empty($versionCols)) {
            throw new \Exception(
                "Baris 'Formula' di baris " . ($headerRow + 1) . " tidak punya kolom nomor formula yang valid di sebelah kanannya."
            );
        }

        $this->blocksFound++;
        $dataRow = $headerRow + 1;

        while ($rows->has($dataRow)) {
            $row = $rows->get($dataRow);
            $bahanNama = trim((string) ($row->get($labelCol) ?? ''));

            if (empty($bahanNama)) {
                $dataRow++;
                continue;
            }

            if (strtoupper($bahanNama) === 'TOTAL') {
                break;
            }

            $bahanBaku = BahanBaku::firstOrCreate(['name' => $bahanNama]);

            foreach ($versionCols as $col => $multiplier) {
                $raw = trim((string) ($row->get($col) ?? ''));

                if ($raw === '' || $raw === '-') {
                    $this->skipped++;
                    continue;
                }

                if (!$this->isNumeric($raw)) {
                    throw new \Exception(
                        "Nilai qty tidak valid untuk bahan '{$bahanNama}', formula {$multiplier}: '{$raw}' (baris " . ($dataRow + 1) . ")."
                    );
                }

                ProductFormula::updateOrCreate(
                    [
                        'product_id' => $this->productId,
                        'bahan_baku_id' => $bahanBaku->id,
                        'multiplier' => $multiplier,
                    ],
                    ['total_kg' => $this->parseNumber($raw)]
                );
                $this->imported++;
            }

            $dataRow++;
        }
    }

    protected function findFormulaLabelCol(Collection $row): ?int
    {
        foreach ($row as $col => $value) {
            if (strtolower(trim((string) $value)) === 'formula') {
                return $col;
            }
        }
        return null;
    }

    protected function isNumeric($value): bool
    {
        $value = trim((string) $value);
        return $value !== '' && is_numeric(str_replace(',', '.', $value));
    }

    protected function parseNumber($value): float
    {
        if (is_numeric($value)) {
            return (float) $value;
        }

        $value = trim((string) $value);
        $value = str_replace(',', '.', $value);

        return (float) $value;
    }

    public function getSummary(): array
    {
        if ($this->blocksFound === 0) {
            throw new \Exception("Tidak ditemukan baris 'Formula' di file ini. Pastikan format sesuai template.");
        }

        return [
            'blocks' => $this->blocksFound,
            'imported' => $this->imported,
            'skipped' => $this->skipped,
        ];
    }
}