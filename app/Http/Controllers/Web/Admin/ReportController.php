<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Services\ReportService;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function __construct(protected ReportService $reportService) {}

    public function index()
    {
        $clients = Client::orderBy('company_name')->get();
        return view('admin.reports.index', compact('clients'));
    }

    public function generate(Request $request)
    {
        $filters = $request->only(['from', 'to', 'client_id', 'site_id', 'category']);
        $type = $request->get('report_type', 'daily_labour');
        $clients = Client::orderBy('company_name')->get();

        $data = match ($type) {
            'daily_labour' => $this->reportService->getDailyLabourReport($filters),
            'monthly_labour' => $this->reportService->getMonthlyLabourReport($filters),
            'client_wise_labour' => $this->reportService->getClientWiseLabourReport($filters),
            'site_wise_labour' => $this->reportService->getSiteWiseLabourReport($filters),
            'payment' => $this->reportService->getPaymentReport($filters),
            'expense' => $this->reportService->getExpenseReport($filters),
            default => collect(),
        };

        $chartData = null;
        if ($data->count() > 0) {
            if ($type == 'daily_labour') {
                // Group by date to sum up multiple sites per day
                $grouped = $data->groupBy(fn($item) => $item->date->format('d M'));
                $chartData = [
                    'labels' => $grouped->keys()->toArray(),
                    'datasets' => [
                        [
                            'label' => 'Total Labour Deployment',
                            'data' => $grouped->map(fn($group) => $group->sum('total_count'))->values()->toArray(),
                            'backgroundColor' => '#4f46e5',
                            'borderRadius' => 4,
                        ]
                    ]
                ];
            } elseif ($type == 'monthly_labour') {
                $grouped = $data->groupBy('month');
                $chartData = [
                    'labels' => $grouped->keys()->map(fn($m) => \Carbon\Carbon::parse($m.'-01')->format('M Y'))->toArray(),
                    'datasets' => [
                        [
                            'label' => 'Monthly Labour Deployment',
                            'data' => $grouped->map(fn($group) => $group->sum('grand_total'))->values()->toArray(),
                            'backgroundColor' => '#3b82f6',
                            'borderRadius' => 4,
                        ]
                    ]
                ];
            } elseif ($type == 'client_wise_labour') {
                $chartData = [
                    'labels' => $data->map(fn($row) => $row->client?->company_name ?? 'Unknown')->toArray(),
                    'datasets' => [
                        [
                            'label' => 'Labour per Client',
                            'data' => $data->pluck('grand_total')->toArray(),
                            'backgroundColor' => '#10b981',
                            'borderRadius' => 4,
                        ]
                    ]
                ];
            } elseif ($type == 'expense') {
                $grouped = $data->groupBy(fn($item) => $item->category->label());
                $chartData = [
                    'labels' => $grouped->keys()->toArray(),
                    'datasets' => [
                        [
                            'label' => 'Expenses by Category',
                            'data' => $grouped->map(fn($group) => $group->sum('amount'))->values()->toArray(),
                            'backgroundColor' => ['#ef4444', '#f59e0b', '#10b981', '#3b82f6', '#8b5cf6', '#ec4899', '#64748b'],
                        ]
                    ]
                ];
            }
        }

        return view('admin.reports.index', compact('clients', 'data', 'type', 'filters', 'chartData'));
    }

    public function exportPdf(Request $request)
    {
        $filters = $request->only(['from', 'to', 'client_id', 'site_id', 'category']);
        $type = $request->get('report_type', 'daily_labour');

        $data = match ($type) {
            'daily_labour' => $this->reportService->getDailyLabourReport($filters),
            'monthly_labour' => $this->reportService->getMonthlyLabourReport($filters),
            'client_wise_labour' => $this->reportService->getClientWiseLabourReport($filters),
            'site_wise_labour' => $this->reportService->getSiteWiseLabourReport($filters),
            'payment' => $this->reportService->getPaymentReport($filters),
            'expense' => $this->reportService->getExpenseReport($filters),
            default => collect(),
        };

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf', compact('data', 'type', 'filters'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("report_{$type}_" . date('Ymd_His') . ".pdf");
    }

    public function export(Request $request)
    {
        $filters = $request->only(['from', 'to', 'client_id', 'site_id', 'category']);
        $type = $request->get('report_type', 'daily_labour');

        $data = match ($type) {
            'daily_labour' => $this->reportService->getDailyLabourReport($filters),
            'monthly_labour' => $this->reportService->getMonthlyLabourReport($filters),
            'client_wise_labour' => $this->reportService->getClientWiseLabourReport($filters),
            'site_wise_labour' => $this->reportService->getSiteWiseLabourReport($filters),
            'payment' => $this->reportService->getPaymentReport($filters),
            'expense' => $this->reportService->getExpenseReport($filters),
            default => collect(),
        };

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ReportExport($data, $type), 
            "report_{$type}_" . date('Ymd_His') . ".xlsx"
        );
    }
}
