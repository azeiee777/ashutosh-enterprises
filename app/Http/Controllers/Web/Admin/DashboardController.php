<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Services\DashboardService;

class DashboardController extends Controller
{
    public function __construct(protected DashboardService $dashboardService) {}

    public function index()
    {
        $stats = $this->dashboardService->getStats();
        $labourTrend = $this->dashboardService->getLabourTrend();
        $expenseTrend = $this->dashboardService->getExpenseTrend();
        $paymentDistribution = $this->dashboardService->getPaymentDistribution();
        $labourCategories = $this->dashboardService->getLabourCategoryDistribution();
        $recentActivities = $this->dashboardService->getRecentActivities();

        return view('admin.dashboard', compact(
            'stats', 'labourTrend', 'expenseTrend',
            'paymentDistribution', 'labourCategories', 'recentActivities'
        ));
    }
}
