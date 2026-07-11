<?php
namespace App\Exports;

class PaymentExport extends BaseExport
{
    protected $lastCol = 'E';

    public function array(): array
    {
        $rows = [
            ['Ashutosh Enterprises - Payments Report', '', '', '', ''],
            ['Generated on: ' . now()->format('d M Y, h:i A'), '', '', '', ''],
            ['', '', '', '', ''],
            ['Date', 'Client', 'Payment Head', 'Amount', 'Payment Method']
        ];

        $total = 0;
        foreach ($this->data as $row) {
            $total += $row->amount;
            $rows[] = [
                $row->date->format('Y-m-d'),
                $row->client?->company_name ?? '-',
                $row->payment_head->label(),
                $row->amount,
                $row->payment_method->label()
            ];
        }

        $rows[] = ['', '', '', '', ''];
        $rows[] = ['GRAND TOTALS', '', '', $total, ''];

        $this->totalRows = count($rows);

        return $rows;
    }
}
