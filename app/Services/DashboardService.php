<?php

namespace App\Services;

use App\Models\Client;
use App\Models\DailyLabourSupply;
use App\Models\Expense;
use App\Models\PaymentRecord;
use App\Models\Site;
use App\Models\ActivityLog;
use Illuminate\Support\Facades\DB;

class DashboardService
{
    public function getStats(): array
    {
        return [
            'total_clients' => Client::count(),
            'active_sites' => Site::where('status', 'active')->count(),
            'today_labour' => DailyLabourSupply::today()->sum('total_count'),
            'monthly_labour' => DailyLabourSupply::thisMonth()->sum('total_count'),
            'today_expenses' => Expense::today()->sum('amount'),
            'monthly_expenses' => Expense::thisMonth()->sum('amount'),
            'total_payments' => PaymentRecord::sum('amount'),
            'pending_payments' => PaymentRecord::where('payment_head', 'advance')->sum('amount'),
        ];
    }

    public function getLabourTrend(int $months = 6): array
    {
        $data = DailyLabourSupply::select(
            DB::raw("strftime('%Y-%m', date) as month"),
            DB::raw('SUM(total_count) as total')
        )
            ->where('date', '>=', now()->subMonths($months)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $data->pluck('month')->map(fn($m) => \Carbon\Carbon::parse($m . '-01')->format('M Y'))->toArray(),
            'data' => $data->pluck('total')->toArray(),
        ];
    }

    public function getExpenseTrend(int $months = 6): array
    {
        $data = Expense::select(
            DB::raw("strftime('%Y-%m', date) as month"),
            DB::raw('SUM(amount) as total')
        )
            ->where('date', '>=', now()->subMonths($months)->startOfMonth())
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return [
            'labels' => $data->pluck('month')->map(fn($m) => \Carbon\Carbon::parse($m . '-01')->format('M Y'))->toArray(),
            'data' => $data->pluck('total')->toArray(),
        ];
    }

    public function getPaymentDistribution(): array
    {
        $data = PaymentRecord::select('payment_head', DB::raw('SUM(amount) as total'))
            ->groupBy('payment_head')
            ->get();

        return [
            'labels' => $data->pluck('payment_head')->map(fn($h) => $h instanceof \App\Enums\PaymentHead ? $h->label() : (\App\Enums\PaymentHead::tryFrom($h)?->label() ?? $h))->toArray(),
            'data' => $data->pluck('total')->toArray(),
        ];
    }

    public function getLabourCategoryDistribution(): array
    {
        return [
            'labels' => ['Skilled', 'Semi Skilled', 'Unskilled', 'Other'],
            'data' => [
                DailyLabourSupply::thisMonth()->sum('skilled_count'),
                DailyLabourSupply::thisMonth()->sum('semi_skilled_count'),
                DailyLabourSupply::thisMonth()->sum('unskilled_count'),
                DailyLabourSupply::thisMonth()->sum('other_count'),
            ],
        ];
    }

    public function getRecentActivities(int $limit = 10): \Illuminate\Database\Eloquent\Collection
    {
        return ActivityLog::with('user')
            ->latest()
            ->limit($limit)
            ->get();
    }
}
