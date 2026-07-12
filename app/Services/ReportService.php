<?php

namespace App\Services;

use App\Models\DailyLabourSupply;
use App\Models\PaymentRecord;
use App\Models\Expense;
use Illuminate\Support\Facades\DB;

class ReportService
{
    public function getDailyLabourReport(array $filters)
    {
        return DailyLabourSupply::with(['client', 'site'])
            ->dateRange($filters['from'] ?? null, $filters['to'] ?? null)
            ->byClient($filters['client_id'] ?? null)
            ->bySite($filters['site_id'] ?? null)
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getMonthlyLabourTrend(int $months = 6): \Illuminate\Support\Collection
    {
        $driver = DB::connection()->getDriverName();
        $monthSelect = $driver === 'sqlite' 
            ? "strftime('%Y-%m', date) as month" 
            : "DATE_FORMAT(date, '%Y-%m') as month";

        return DailyLabourSupply::select(
            DB::raw($monthSelect),
            DB::raw('SUM(skilled_count) as skilled'),
            DB::raw('SUM(semi_skilled_count) as semi_skilled'),
            DB::raw('SUM(unskilled_count) as unskilled'),
            DB::raw('SUM(total_count) as total')
        )
            ->where('date', '>=', now()->subMonths($months)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();
    }

    public function getMonthlyLabourReport(array $filters)
    {
        $driver = DB::connection()->getDriverName();
        $monthSelect = $driver === 'sqlite' 
            ? "strftime('%Y-%m', date) as month" 
            : "DATE_FORMAT(date, '%Y-%m') as month";

        return DailyLabourSupply::select(
            DB::raw($monthSelect),
            'client_id',
            DB::raw('SUM(skilled_count) as total_skilled'),
            DB::raw('SUM(semi_skilled_count) as total_semi_skilled'),
            DB::raw('SUM(unskilled_count) as total_unskilled'),
            DB::raw('SUM(other_count) as total_other'),
            DB::raw('SUM(total_count) as grand_total')
        )
            ->dateRange($filters['from'] ?? null, $filters['to'] ?? null)
            ->byClient($filters['client_id'] ?? null)
            ->groupBy('month', 'client_id')
            ->with('client')
            ->orderBy('month', 'desc')
            ->get();
    }

    public function getClientWiseLabourReport(array $filters)
    {
        return DailyLabourSupply::select(
            'client_id',
            DB::raw('SUM(skilled_count) as total_skilled'),
            DB::raw('SUM(semi_skilled_count) as total_semi_skilled'),
            DB::raw('SUM(unskilled_count) as total_unskilled'),
            DB::raw('SUM(other_count) as total_other'),
            DB::raw('SUM(total_count) as grand_total'),
            DB::raw('COUNT(DISTINCT date) as total_days')
        )
            ->dateRange($filters['from'] ?? null, $filters['to'] ?? null)
            ->groupBy('client_id')
            ->with('client')
            ->get();
    }

    public function getSiteWiseLabourReport(array $filters)
    {
        return DailyLabourSupply::select(
            'site_id',
            'client_id',
            DB::raw('SUM(total_count) as grand_total'),
            DB::raw('COUNT(DISTINCT date) as total_days')
        )
            ->dateRange($filters['from'] ?? null, $filters['to'] ?? null)
            ->byClient($filters['client_id'] ?? null)
            ->groupBy('site_id', 'client_id')
            ->with(['site', 'client'])
            ->get();
    }

    public function getPaymentReport(array $filters)
    {
        return PaymentRecord::with(['client', 'site'])
            ->dateRange($filters['from'] ?? null, $filters['to'] ?? null)
            ->byClient($filters['client_id'] ?? null)
            ->bySite($filters['site_id'] ?? null)
            ->orderBy('date', 'desc')
            ->get();
    }

    public function getExpenseReport(array $filters)
    {
        return Expense::dateRange($filters['from'] ?? null, $filters['to'] ?? null)
            ->byCategory($filters['category'] ?? null)
            ->orderBy('date', 'desc')
            ->get();
    }
}
