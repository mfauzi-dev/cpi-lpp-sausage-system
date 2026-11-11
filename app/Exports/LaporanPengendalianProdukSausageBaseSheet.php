<?php

namespace App\Exports;

use App\Models\ProductionBatch;
use DateTimeInterface;
use Illuminate\Support\Facades\Storage;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Events\AfterSheet;
use PhpOffice\PhpSpreadsheet\Cell\Coordinate;
use PhpOffice\PhpSpreadsheet\Cell\DataType;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Worksheet\Drawing;
use PhpOffice\PhpSpreadsheet\Worksheet\PageSetup;

abstract class LaporanPengendalianProdukSausageBaseSheet implements
    FromCollection,
    WithColumnWidths,
    WithEvents,
    WithTitle
{
    protected ProductionBatch $productionBatch;

    protected string $lastCol = 'R';
    protected int $totalCols = 18;
    protected int $totalSheets = 8;

    public function __construct(ProductionBatch $productionBatch)
    {
        $this->productionBatch = $productionBatch;
    }

    abstract protected function sheetNumber(): int;

    abstract protected function buildContent($sheet, int $row): int;

    public function collection()
    {
        return collect([]);
    }

    public function title(): string
    {
        return 'Sheet ' . $this->sheetNumber();
    }

    public function columnWidths(): array
    {
        $widths = [];

        for ($i = 1; $i <= $this->totalCols; $i++) {
            $widths[Coordinate::stringFromColumnIndex($i)] = 15;
        }

        return $widths;
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $sheet = $event->sheet->getDelegate();

                $this->setupPage($sheet);
                $this->buildHeader($sheet);

                $row = $this->buildInfo($sheet, 7);
                $row = $this->buildContent($sheet, $row);

                $this->buildApproval($sheet, $row);

                $lastRow = $sheet->getHighestRow();

                $sheet->getStyle("A1:{$this->lastCol}{$lastRow}")
                    ->getAlignment()
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);

                $sheet->setShowGridlines(false);

                $sheet->getPageSetup()
                    ->setPrintArea("A1:{$this->lastCol}{$lastRow}");
            },
        ];
    }

    protected function setupPage($sheet): void
    {
        $sheet->getPageSetup()
            ->setOrientation(PageSetup::ORIENTATION_LANDSCAPE)
            ->setPaperSize(PageSetup::PAPERSIZE_A4)
            ->setFitToPage(true)
            ->setFitToWidth(1)
            ->setFitToHeight(1)
            ->setHorizontalCentered(true)
            ->setVerticalCentered(false);

        $sheet->getPageMargins()
            ->setTop(0.1)
            ->setRight(0.05)
            ->setBottom(0.1)
            ->setLeft(0.05);

        $sheet->getSheetView()->setZoomScale(75);
        $sheet->getDefaultRowDimension()->setRowHeight(28);
    }

    protected function buildHeader($sheet): void
    {
        $pb = $this->productionBatch;

        $tanggal = $pb->tanggal ? $pb->tanggal->format('d/m/Y') : '-';

        $lines = [
            1 => ['PT CHAROEN POKPHAND INDONESIA', 18, 36],
            2 => ['FOOD DIVISION', 14, 30],
            3 => ['LAPORAN PENGENDALIAN PRODUK - SAUSAGE', 16, 38],
            4 => [
                'PRODUCTION BATCH : ' . $tanggal . ' - SHIFT ' . ($pb->shift ?? '-'),
                14,
                34,
            ],
            5 => [
                'PRODUK : ' . ($pb->product->name ?? '-')
                    . '   |   KODE BATCH : ' . ($pb->kode_batch ?? '-')
                    . '   |   HALAMAN ' . $this->sheetNumber() . ' / ' . $this->totalSheets,
                12,
                30,
            ],
        ];

        foreach ($lines as $r => [$text, $size, $height]) {
            $sheet->mergeCells("A{$r}:{$this->lastCol}{$r}");
            $sheet->setCellValue("A{$r}", $text);

            $sheet->getStyle("A{$r}")->getFont()->setBold(true)->setSize($size);
            $sheet->getStyle("A{$r}:{$this->lastCol}{$r}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER)
                ->setWrapText(true);

            $sheet->getRowDimension($r)->setRowHeight($height);
        }

        $sheet->getRowDimension(6)->setRowHeight(10);
    }

    protected function buildApproval($sheet, int $row): void
    {
        $row++; 

        $cols = [
            ['A', 'I', 'Dibuat Oleh', 'Operator'],
            ['J', 'R', 'Diperiksa Oleh', 'QC'],
        ];

        foreach ($cols as [$start, $end, $title, $role]) {
            $sheet->mergeCells("{$start}{$row}:{$end}{$row}");
            $sheet->setCellValue("{$start}{$row}", $title);

            $sheet->getStyle("{$start}{$row}:{$end}{$row}")
                ->getFont()->setBold(true)->setSize(12);

            $sheet->getStyle("{$start}{$row}:{$end}{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);
        }

        $sheet->getRowDimension($row)->setRowHeight(30);

        $row++;
        $endTtdRow = $row + 3;

        foreach ($cols as [$start, $end]) {
            $sheet->mergeCells("{$start}{$row}:{$end}{$endTtdRow}");

            $sheet->getStyle("{$start}{$row}:{$end}{$endTtdRow}")
                ->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);
        }

        for ($i = $row; $i <= $endTtdRow; $i++) {
            $sheet->getRowDimension($i)->setRowHeight(28);
        }

        $row = $endTtdRow + 1;

        foreach ($cols as [$start, $end, $title, $role]) {
            $sheet->mergeCells("{$start}{$row}:{$end}{$row}");
            $sheet->setCellValue("{$start}{$row}", $role);

            $sheet->getStyle("{$start}{$row}:{$end}{$row}")
                ->getFont()->setBold(true)->setSize(12);

            $sheet->getStyle("{$start}{$row}:{$end}{$row}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle("{$start}{$row}:{$end}{$row}")
                ->getBorders()->getTop()
                ->setBorderStyle(Border::BORDER_THIN);
        }

        $sheet->getRowDimension($row)->setRowHeight(30);
    }

    protected function buildInfo($sheet, int $row): int
    {
        $pb = $this->productionBatch;

        return $this->infoPairs($sheet, $row, [
            [
                'Hari',
                $this->val($pb->hari),
                'Tanggal',
                $this->date($pb->tanggal),
            ],
            [
                'Produk',
                $this->val($pb->product->name ?? null),
                'Kode Batch',
                $this->val($pb->kode_batch),
            ],
            [
                'Yield Meat',
                $this->number($pb->yield_meat),
                'Total Meat',
                $pb->total_meat !== null
                    ? $this->number($pb->total_meat) . ' Kg'
                    : '-',
            ],
        ]);
    }

    protected function verticalTable(
        $sheet,
        int $row,
        string $firstHeader,
        array $fields,
        $records,
        ?callable $headerFn = null
    ): int {
        $records = collect($records)->values();

        $headers = [$firstHeader];

        foreach ($records as $i => $record) {
            $headers[] = $headerFn
                ? $this->val($headerFn($record, $i))
                : ($records->count() > 1 ? (string) ($i + 1) : 'Nilai');
        }

        $rows = [];

        if ($records->isNotEmpty()) {
            foreach ($fields as $label => $fn) {
                $line = [$label];

                foreach ($records as $record) {
                    $line[] = $fn($record);
                }

                $rows[] = $line;
            }
        }

        return $this->table($sheet, $row, null, $headers, $rows);
    }

    protected function table(
        $sheet,
        int $row,
        ?string $title,
        array $columns,
        array $rows
    ): int {
        if ($title !== null) {
            $this->sectionTitle($sheet, $row, $title);
            $row++;
        }

        $spans = $this->distributeColumns(count($columns));

        foreach ($columns as $i => $label) {
            [$start, $end] = $spans[$i];

            if ($start !== $end) {
                $sheet->mergeCells("{$start}{$row}:{$end}{$row}");
            }

            $sheet->setCellValue("{$start}{$row}", $label);
        }

        $this->styleRow($sheet, $row, 12, true);
        $sheet->getRowDimension($row)->setRowHeight(40);
        $row++;

        if (empty($rows)) {
            $this->emptyBlockRow($sheet, $row);

            return $row + 2;
        }

        foreach ($rows as $record) {
            foreach (array_values($record) as $i => $value) {
                [$start, $end] = $spans[$i];

                if ($start !== $end) {
                    $sheet->mergeCells("{$start}{$row}:{$end}{$row}");
                }

                // Paksa teks: "1.300" kalau tidak dipaksa dibaca Excel jadi 1,3
                $sheet->setCellValueExplicit(
                    "{$start}{$row}",
                    (string) $value,
                    DataType::TYPE_STRING
                );
            }

            $this->styleRow($sheet, $row, 11, false);
            $sheet->getRowDimension($row)->setRowHeight(30);

            $row++;
        }

        return $row + 1;
    }

    protected function infoPairs($sheet, int $row, array $pairs): int
    {
        foreach ($pairs as $i => [$label1, $value1, $label2, $value2]) {
            $r = $row + $i;

            $cells = [
                ['A', 'C', $label1 . ' :'],
                ['D', 'G', $value1],
                ['H', 'J', $label2 . ' :'],
                ['K', $this->lastCol, $value2],
            ];

            foreach ($cells as [$start, $end, $value]) {
                $sheet->mergeCells("{$start}{$r}:{$end}{$r}");
                $sheet->setCellValueExplicit(
                    "{$start}{$r}",
                    (string) $value,
                    DataType::TYPE_STRING
                );

                $sheet->getStyle("{$start}{$r}:{$end}{$r}")
                    ->getFont()->setBold(true)->setSize(12);

                $sheet->getStyle("{$start}{$r}:{$end}{$r}")
                    ->getAlignment()
                    ->setHorizontal(Alignment::HORIZONTAL_LEFT)
                    ->setVertical(Alignment::VERTICAL_CENTER)
                    ->setWrapText(true);
            }

            $sheet->getRowDimension($r)->setRowHeight(28);
        }

        return $row + count($pairs) + 1;
    }

    protected function sectionTitle($sheet, int $row, string $title): void
    {
        $range = "A{$row}:{$this->lastCol}{$row}";

        $sheet->mergeCells($range);
        $sheet->setCellValue("A{$row}", $title);

        $sheet->getStyle($range)->getFont()->setBold(true)->setSize(14);

        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        $sheet->getStyle($range)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->getRowDimension($row)->setRowHeight(34);
    }

    protected function styleRow($sheet, int $row, int $size, bool $header): void
    {
        $range = "A{$row}:{$this->lastCol}{$row}";

        $sheet->getStyle($range)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->getStyle($range)->getFont()->setSize($size)->setBold($header);

        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER)
            ->setWrapText(true);

        if ($header) {
            $sheet->getStyle($range)->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E5E5E5');
        }
    }

    protected function emptyBlockRow($sheet, int $row): void
    {
        $range = "A{$row}:{$this->lastCol}{$row}";

        $sheet->mergeCells($range);
        $sheet->setCellValue("A{$row}", 'Tidak ada data');

        $sheet->getStyle($range)->getFont()->setItalic(true)->setBold(true)->setSize(12);

        $sheet->getStyle($range)->getAlignment()
            ->setHorizontal(Alignment::HORIZONTAL_CENTER)
            ->setVertical(Alignment::VERTICAL_CENTER);

        $sheet->getStyle($range)->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        $sheet->getRowDimension($row)->setRowHeight(32);
    }

    protected function distributeColumns(int $n): array
    {
        $letters = [];

        for ($i = 1; $i <= $this->totalCols; $i++) {
            $letters[] = Coordinate::stringFromColumnIndex($i);
        }

        $n = max(1, min($n, count($letters)));

        $base = intdiv(count($letters), $n);
        $extra = count($letters) % $n;
        $cursor = 0;
        $spans = [];

        for ($i = 0; $i < $n; $i++) {
            $width = $base + ($i < $extra ? 1 : 0);

            $spans[] = [$letters[$cursor], $letters[$cursor + $width - 1]];

            $cursor += $width;
        }

        return $spans;
    }

    // ------------------------------------------------------------------
    // Gambar / foto (Kartu Rute, Stamp, ED)
    // ------------------------------------------------------------------

    // Cek apakah kolom foto di production_batches terisi dan file-nya ada
    protected function hasSticker(string $field): bool
    {
        $path = $this->productionBatch->{$field};

        if (!$path) {
            return false;
        }

        return Storage::disk('public')->exists($path);
    }

    // Beberapa foto sejajar dalam satu baris, masing-masing dengan judul di atasnya.
    // $items = [['title' => 'KARTU RUTE', 'field' => 'foto_kartu_rute', 'weight' => 3], ...]
    // Lebar kolom dibagi sesuai 'weight'. Mengembalikan nomor baris berikutnya.
    // Kalau gambarnya tidak ada, kotaknya dihapus: kotak lain melebar mengisi baris,
    // dan kalau semua gambar tidak ada, bagian ini tidak ditampilkan sama sekali.
    protected function stickerRow($sheet, int $row, array $items, int $boxRows): int
    {
        $itemsAda = [];

        foreach ($items as $item) {
            if ($this->hasSticker($item['field'])) {
                $itemsAda[] = $item;
            }
        }

        $items = $itemsAda;

        if (count($items) == 0) {
            return $row;
        }

        $totalWeight = 0;

        foreach ($items as $item) {
            $totalWeight += $item['weight'];
        }

        $titleRow = $row;
        $boxStart = $row + 1;
        $boxEnd = $row + $boxRows;

        $allocated = 0;
        $colIndex = 0;
        $lastIndex = count($items) - 1;

        foreach ($items as $i => $item) {
            if ($i === $lastIndex) {
                $width = $this->totalCols - $allocated;
            } else {
                $width = (int) round(($item['weight'] / $totalWeight) * $this->totalCols);
            }

            if ($width < 1) {
                $width = 1;
            }

            $start = chr(ord('A') + $colIndex);
            $end = chr(ord('A') + $colIndex + $width - 1);

            // Judul
            $sheet->mergeCells("{$start}{$titleRow}:{$end}{$titleRow}");
            $sheet->setCellValueExplicit(
                "{$start}{$titleRow}",
                $item['title'],
                DataType::TYPE_STRING
            );

            $sheet->getStyle("{$start}{$titleRow}:{$end}{$titleRow}")
                ->getFont()->setBold(true)->setSize(13);

            $sheet->getStyle("{$start}{$titleRow}:{$end}{$titleRow}")
                ->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle("{$start}{$titleRow}:{$end}{$titleRow}")
                ->getBorders()->getAllBorders()
                ->setBorderStyle(Border::BORDER_THIN);

            $sheet->getStyle("{$start}{$titleRow}:{$end}{$titleRow}")
                ->getFill()
                ->setFillType(Fill::FILL_SOLID)
                ->getStartColor()->setRGB('E5E5E5');

            // Kotak gambar
            $this->placeStickerImage(
                $sheet,
                $boxStart,
                $boxEnd,
                $start,
                $end,
                $this->productionBatch->{$item['field']}
            );

            $colIndex += $width;
            $allocated += $width;
        }

        $sheet->getRowDimension($titleRow)->setRowHeight(34);

        return $boxEnd + 2;
    }

    protected function placeStickerImage(
        $sheet,
        int $rowStart,
        int $rowEnd,
        string $start,
        string $end,
        string $imagePath
    ): void {
        $rowHeightPt = 26;

        $sheet->mergeCells("{$start}{$rowStart}:{$end}{$rowEnd}");

        $sheet->getStyle("{$start}{$rowStart}:{$end}{$rowEnd}")
            ->getBorders()->getAllBorders()
            ->setBorderStyle(Border::BORDER_THIN);

        for ($i = $rowStart; $i <= $rowEnd; $i++) {
            $sheet->getRowDimension($i)->setRowHeight($rowHeightPt);
        }

        $fullPath = Storage::disk('public')->path($imagePath);
        $imageInfo = @getimagesize($fullPath);

        if ($imageInfo === false) {
            return;
        }

        $origWidth = $imageInfo[0];
        $origHeight = $imageInfo[1];

        $padding = 10;

        // 1 pt = 4/3 px
        $boxHeightPx = (int) round((($rowEnd - $rowStart + 1) * $rowHeightPt) * 4 / 3);

        $availableWidth = $this->columnRangeWidthPx($start, $end) - $padding;
        $availableHeight = $boxHeightPx - $padding;

        $scale = min(
            $availableWidth / $origWidth,
            $availableHeight / $origHeight
        );

        $drawWidth = (int) round($origWidth * $scale);
        $drawHeight = (int) round($origHeight * $scale);

        $offsetX = (int) max(4, ($availableWidth - $drawWidth) / 2);
        $offsetY = (int) max(4, ($availableHeight - $drawHeight) / 2);

        $drawing = new Drawing();
        $drawing->setName('Gambar');
        $drawing->setPath($fullPath);
        $drawing->setResizeProportional(false);
        $drawing->setCoordinates("{$start}{$rowStart}");
        $drawing->setOffsetX($offsetX);
        $drawing->setOffsetY($offsetY);
        $drawing->setWidth($drawWidth);
        $drawing->setHeight($drawHeight);
        $drawing->setWorksheet($sheet);
    }

    protected function columnRangeWidthPx(string $start, string $end): int
    {
        $widths = $this->columnWidths();
        $total = 0;

        for ($col = ord($start); $col <= ord($end); $col++) {
            $letter = chr($col);

            $width = 10;

            if (isset($widths[$letter])) {
                $width = $widths[$letter];
            }

            $total += (int) round(($width * 7) + 5);
        }

        return $total;
    }

    // ------------------------------------------------------------------
    // Format nilai
    // ------------------------------------------------------------------

    protected function number($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        if (!is_numeric($value)) {
            return (string) $value;
        }

        $formatted = number_format((float) $value, 3, ',', '.');

        return rtrim(rtrim($formatted, '0'), ',');
    }

    protected function val($value): string
    {
        if ($value === null || $value === '') {
            return '-';
        }

        return (string) $value;
    }

    protected function time($value): string
    {
        if (!$value) {
            return '-';
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format('H:i');
        }

        return substr((string) $value, 0, 5);
    }

    protected function date($value): string
    {
        if (!$value) {
            return '-';
        }

        if ($value instanceof DateTimeInterface) {
            return $value->format('d/m/Y');
        }

        return (string) $value;
    }
}