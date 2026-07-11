<?php
namespace App\Exports;

class ExpenseExport extends BaseExport
{
    protected $lastCol = 'E';

    public function array(): array
    {
        $rows = [
            ['Ashutosh Enterprises - Expenses Report', '', '', '', ''],
            ['Generated on: ' . now()->format('d M Y, h:i A'), '', '', '', ''],
            ['', '', '', '', ''],
            ['Date', 'Category', 'Vendor', 'Description', 'Amount']
        ];

        $total = 0;
        foreach ($this->data as $row) {
            $total += $row->amount;
            $rows[] = [
                $row->date->format('Y-m-d'),
                $row->category->label(),
                $row->vendor ?? '-',
                $row->description ?? '-',
                $row->amount
            ];
        }

        $rows[] = ['', '', '', '', ''];
        $rows[] = ['GRAND TOTALS', '', '', '', $total];

        $this->totalRows = count($rows);

        return $rows;
    }
}
