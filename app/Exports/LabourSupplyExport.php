<?php
namespace App\Exports;

class LabourSupplyExport extends BaseExport
{
    protected $lastCol = 'G';

    public function array(): array
    {
        $rows = [
            ['Ashutosh Enterprises - Daily Labour Supply Report', '', '', '', '', '', ''],
            ['Generated on: ' . now()->format('d M Y, h:i A'), '', '', '', '', '', ''],
            ['', '', '', '', '', '', ''],
            ['Date', 'Client', 'Site', 'Skilled', 'Semi-Skilled', 'Unskilled', 'Total']
        ];

        $totals = ['S' => 0, 'SS' => 0, 'US' => 0, 'T' => 0];
        foreach ($this->data as $row) {
            $totals['S'] += $row->skilled_count;
            $totals['SS'] += $row->semi_skilled_count;
            $totals['US'] += $row->unskilled_count;
            $totals['T'] += $row->total_count;
            
            $rows[] = [
                $row->date->format('Y-m-d'),
                $row->client?->company_name ?? '-',
                $row->site?->site_name ?? '-',
                $row->skilled_count,
                $row->semi_skilled_count,
                $row->unskilled_count,
                $row->total_count
            ];
        }

        $rows[] = ['', '', '', '', '', '', ''];
        $rows[] = ['GRAND TOTALS', '', '', $totals['S'], $totals['SS'], $totals['US'], $totals['T']];

        $this->totalRows = count($rows);

        return $rows;
    }
}
