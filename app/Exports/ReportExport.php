<?php
namespace App\Exports;

class ReportExport extends BaseExport
{
    protected $type;

    public function __construct($data, $type)
    {
        parent::__construct($data);
        $this->type = $type;
        $this->lastCol = $this->getLastColForType($type);
    }

    private function getLastColForType($type)
    {
        $cols = [
            'daily_labour' => 'G',
            'monthly_labour' => 'F',
            'client_wise_labour' => 'F',
            'site_wise_labour' => 'D',
            'payment' => 'E',
            'expense' => 'E',
        ];
        return $cols[$type] ?? 'E';
    }

    private function getColCount()
    {
        return ord($this->lastCol) - ord('A') + 1;
    }

    public function array(): array
    {
        $title = 'Ashutosh Enterprises - ' . ucwords(str_replace('_', ' ', $this->type)) . ' Report';
        $rows = [
            array_pad([$title], $this->getColCount(), ''),
            array_pad(['Generated on: ' . now()->format('d M Y, h:i A')], $this->getColCount(), ''),
            array_fill(0, $this->getColCount(), '')
        ];

        if ($this->type == 'daily_labour') {
            $rows[] = ['Date', 'Client', 'Site', 'Skilled', 'Semi-Skilled', 'Unskilled', 'Total'];
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
            $rows[] = array_fill(0, $this->getColCount(), '');
            $rows[] = ['GRAND TOTALS', '', '', $totals['S'], $totals['SS'], $totals['US'], $totals['T']];
            
        } elseif ($this->type == 'monthly_labour') {
            $rows[] = ['Month', 'Client', 'Total Skilled', 'Total Semi-Skilled', 'Total Unskilled', 'Grand Total'];
            $totals = ['S' => 0, 'SS' => 0, 'US' => 0, 'T' => 0];
            foreach ($this->data as $row) {
                $totals['S'] += $row->total_skilled;
                $totals['SS'] += $row->total_semi_skilled;
                $totals['US'] += $row->total_unskilled;
                $totals['T'] += $row->grand_total;
                $rows[] = [
                    \Carbon\Carbon::parse($row->month.'-01')->format('M Y'),
                    $row->client?->company_name ?? '-',
                    $row->total_skilled,
                    $row->total_semi_skilled,
                    $row->total_unskilled,
                    $row->grand_total
                ];
            }
            $rows[] = array_fill(0, $this->getColCount(), '');
            $rows[] = ['GRAND TOTALS', '', $totals['S'], $totals['SS'], $totals['US'], $totals['T']];
            
        } elseif ($this->type == 'client_wise_labour') {
            $rows[] = ['Client', 'Total Days', 'Total Skilled', 'Total Semi-Skilled', 'Total Unskilled', 'Grand Total'];
            $totals = ['D' => 0, 'S' => 0, 'SS' => 0, 'US' => 0, 'T' => 0];
            foreach ($this->data as $row) {
                $totals['D'] += $row->total_days;
                $totals['S'] += $row->total_skilled;
                $totals['SS'] += $row->total_semi_skilled;
                $totals['US'] += $row->total_unskilled;
                $totals['T'] += $row->grand_total;
                $rows[] = [
                    $row->client?->company_name ?? '-',
                    $row->total_days,
                    $row->total_skilled,
                    $row->total_semi_skilled,
                    $row->total_unskilled,
                    $row->grand_total
                ];
            }
            $rows[] = array_fill(0, $this->getColCount(), '');
            $rows[] = ['GRAND TOTALS', $totals['D'], $totals['S'], $totals['SS'], $totals['US'], $totals['T']];
            
        } elseif ($this->type == 'site_wise_labour') {
            $rows[] = ['Site', 'Client', 'Total Days', 'Grand Total'];
            $totals = ['D' => 0, 'T' => 0];
            foreach ($this->data as $row) {
                $totals['D'] += $row->total_days;
                $totals['T'] += $row->grand_total;
                $rows[] = [
                    $row->site?->site_name ?? '-',
                    $row->client?->company_name ?? '-',
                    $row->total_days,
                    $row->grand_total
                ];
            }
            $rows[] = array_fill(0, $this->getColCount(), '');
            $rows[] = ['GRAND TOTALS', '', $totals['D'], $totals['T']];
            
        } elseif ($this->type == 'payment') {
            $rows[] = ['Date', 'Client', 'Payment Head', 'Amount', 'Payment Method'];
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
            $rows[] = array_fill(0, $this->getColCount(), '');
            $rows[] = ['GRAND TOTALS', '', '', $total, ''];
            
        } elseif ($this->type == 'expense') {
            $rows[] = ['Date', 'Category', 'Vendor', 'Description', 'Amount'];
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
            $rows[] = array_fill(0, $this->getColCount(), '');
            $rows[] = ['GRAND TOTALS', '', '', '', $total];
        }

        $this->totalRows = count($rows);
        return $rows;
    }
}
