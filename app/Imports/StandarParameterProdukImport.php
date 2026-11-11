<?php

namespace App\Imports;

use App\Models\StandarParameterProduk;
use Illuminate\Support\Collection;
use Maatwebsite\Excel\Concerns\ToCollection;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class StandarParameterProdukImport implements ToCollection, WithHeadingRow
{
    protected int $productId;
    protected int $imported = 0;
    protected int $skipped = 0;

    public function __construct(int $productId)
    {
        $this->productId = $productId;
    }

    public function headingRow(): int
    {
        return 3;
    }

    public function collection(Collection $rows)
    {
        if ($rows->isEmpty()) {
            throw new \Exception('File Excel kosong.');
        }

        $requiredHeaders = [
            'sampling_ke',
            'diameter',
            'panjang',
            'berat_per_pcs',
            'berat_kulit',
            'berat_adonan',
        ];

        $headers = array_keys($rows->first()->toArray());

        foreach ($requiredHeaders as $header) {
            if (!in_array($header, $headers)) {
                throw new \Exception(
                    "Format Excel tidak sesuai. Kolom '{$header}' tidak ditemukan."
                );
            }
        }

        foreach ($rows as $r => $row) {
            $samplingKe = trim((string) ($row['sampling_ke'] ?? ''));

            if ($samplingKe === '') {
                $this->skipped++;
                continue;
            }

            if (!$this->isNumeric($samplingKe)) {
                throw new \Exception(
                    "Nilai 'sampling_ke' tidak valid: '{$samplingKe}' (baris " . ($r + $this->headingRow() + 1) . ")."
                );
            }

            $numericFields = [
                'diameter',
                'panjang',
                'berat_per_pcs',
                'berat_kulit',
                'berat_adonan',
            ];

            $values = [];

            foreach ($numericFields as $field) {
                $raw = trim((string) ($row[$field] ?? ''));

                if ($raw === '' || $raw === '-') {
                    $values[$field] = null;
                    continue;
                }

                if (!$this->isNumeric($raw)) {
                    throw new \Exception(
                        "Nilai '{$field}' tidak valid: '{$raw}' (baris " . ($r + $this->headingRow() + 1) . ")."
                    );
                }

                $values[$field] = $this->parseNumber($raw);
            }

            StandarParameterProduk::updateOrCreate(
                [
                    'product_id' => $this->productId,
                    'sampling_ke' => (int) $this->parseNumber($samplingKe),
                ],
                $values
            );

            $this->imported++;
        }

        if ($this->imported === 0) {
            throw new \Exception('Tidak ada baris data sampling yang berhasil diimpor. Pastikan kolom sampling_ke terisi.');
        }
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
        return [
            'imported' => $this->imported,
            'skipped' => $this->skipped,
        ];
    }
}