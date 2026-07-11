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

        return view('admin.reports.index', compact('clients', 'data', 'type', 'filters'));
    }
}
