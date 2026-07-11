<?php
namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\WithStyles;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Fill;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

abstract class BaseExport implements FromArray, WithStyles, ShouldAutoSize
{
    protected $data;
    protected $totalRows;
    protected $lastCol = 'E'; // Default for 5 columns
    
    public function __construct($data)
    {
        $this->data = $data;
    }

    public function styles(Worksheet $sheet)
    {
        $sheet->mergeCells('A1:' . $this->lastCol . '1');
        $sheet->mergeCells('A2:' . $this->lastCol . '2');
        
        // Title
        $sheet->getStyle('A1')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => Color::COLOR_WHITE], 'size' => 16],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF1E3A8A']], // Premium Dark Blue
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER, 'vertical' => Alignment::VERTICAL_CENTER],
        ]);
        $sheet->getRowDimension(1)->setRowHeight(30);

        // Subtitle
        $sheet->getStyle('A2')->applyFromArray([
            'font' => ['italic' => true, 'color' => ['argb' => 'FF1E3A8A']],
            'alignment' => ['horizontal' => Alignment::HORIZONTAL_CENTER],
        ]);

        // Table Header
        $sheet->getStyle('A4:' . $this->lastCol . '4')->applyFromArray([
            'font' => ['bold' => true, 'color' => ['argb' => 'FF111827']],
            'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FFE5E7EB']], // Gray 200
        ]);

        // Grand Totals
        if ($this->totalRows > 0) {
            $sheet->getStyle('A' . $this->totalRows . ':' . $this->lastCol . $this->totalRows)->applyFromArray([
                'font' => ['bold' => true, 'color' => ['argb' => Color::COLOR_WHITE], 'size' => 12],
                'fill' => ['fillType' => Fill::FILL_SOLID, 'startColor' => ['argb' => 'FF059669']], // Premium Emerald Green
            ]);
        }

        return [];
    }
}
