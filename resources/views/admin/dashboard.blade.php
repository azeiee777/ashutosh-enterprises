@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
<div class="page-title-section">
    <div>
        <h1>Dashboard</h1>
        <p class="page-subtitle">Welcome back! Here's your business overview.</p>
    </div>
    <div class="d-flex gap-2">
        <a href="{{ route('admin.labour-supply.create') }}" class="btn btn-admin-primary">
            <i class="bi bi-plus-lg"></i> Add Labour Entry
        </a>
    </div>
</div>

{{-- Stat Cards --}}
<div class="row g-3 mb-4">
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-blue"><i class="bi bi-buildings"></i></div>
            <div class="stat-value">{{ number_format($stats['total_clients']) }}</div>
            <div class="stat-label">Total Clients</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-green"><i class="bi bi-geo-alt"></i></div>
            <div class="stat-value">{{ number_format($stats['active_sites']) }}</div>
            <div class="stat-label">Active Sites</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-amber"><i class="bi bi-people"></i></div>
            <div class="stat-value">{{ number_format($stats['today_labour']) }}</div>
            <div class="stat-label">Today's Labour</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-purple"><i class="bi bi-calendar-month"></i></div>
            <div class="stat-value">{{ number_format($stats['monthly_labour']) }}</div>
            <div class="stat-label">Monthly Labour</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-red"><i class="bi bi-cash"></i></div>
            <div class="stat-value">₹{{ number_format($stats['today_expenses']) }}</div>
            <div class="stat-label">Today's Expenses</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-cyan"><i class="bi bi-receipt"></i></div>
            <div class="stat-value">₹{{ number_format($stats['monthly_expenses']) }}</div>
            <div class="stat-label">Monthly Expenses</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-green"><i class="bi bi-cash-stack"></i></div>
            <div class="stat-value">₹{{ number_format($stats['total_payments']) }}</div>
            <div class="stat-label">Total Payments</div>
        </div>
    </div>
    <div class="col-6 col-lg-3">
        <div class="stat-card">
            <div class="stat-icon bg-amber"><i class="bi bi-hourglass-split"></i></div>
            <div class="stat-value">₹{{ number_format($stats['pending_payments']) }}</div>
            <div class="stat-label">Pending Payments</div>
        </div>
    </div>
</div>

{{-- Charts Row --}}
<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header">
                <h6>Labour Supply Trend</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="labourTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header">
                <h6>Labour Categories</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="labourCategoryChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row g-3 mb-4">
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header">
                <h6>Monthly Expense Trend</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="expenseTrendChart"></canvas>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header">
                <h6>Payment Distribution</h6>
            </div>
            <div class="card-body">
                <div class="chart-container">
                    <canvas id="paymentDistChart"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- Quick Actions & Recent Activity --}}
<div class="row g-3">
    <div class="col-lg-4">
        <div class="admin-card">
            <div class="card-header"><h6>Quick Actions</h6></div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-6"><a href="{{ route('admin.labour-supply.create') }}" class="quick-action-btn"><i class="bi bi-plus-circle"></i>Add Labour</a></div>
                    <div class="col-6"><a href="{{ route('admin.clients.create') }}" class="quick-action-btn"><i class="bi bi-building-add"></i>New Client</a></div>
                    <div class="col-6"><a href="{{ route('admin.payments.create') }}" class="quick-action-btn"><i class="bi bi-cash-coin"></i>Add Payment</a></div>
                    <div class="col-6"><a href="{{ route('admin.expenses.create') }}" class="quick-action-btn"><i class="bi bi-receipt-cutoff"></i>Add Expense</a></div>
                    <div class="col-6"><a href="{{ route('admin.reports.index') }}" class="quick-action-btn"><i class="bi bi-file-bar-graph"></i>Reports</a></div>
                    <div class="col-6"><a href="{{ route('admin.sites.create') }}" class="quick-action-btn"><i class="bi bi-geo-alt-fill"></i>New Site</a></div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-8">
        <div class="admin-card">
            <div class="card-header"><h6>Recent Activity</h6></div>
            <div class="card-body" style="max-height: 360px; overflow-y: auto;">
                @forelse($recentActivities as $activity)
                <div class="activity-item">
                    <div class="activity-icon"><i class="bi bi-activity"></i></div>
                    <div class="activity-content">
                        <div class="activity-text">
                            <strong>{{ $activity->user?->name ?? 'System' }}</strong> {{ $activity->description }}
                        </div>
                        <div class="activity-time">{{ $activity->created_at->diffForHumans() }}</div>
                    </div>
                </div>
                @empty
                <div class="empty-state py-4">
                    <i class="bi bi-clock-history"></i>
                    <h5>No activity yet</h5>
                    <p>Actions will appear here as you use the system.</p>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const chartColors = {
        amber: '#F59E0B',
        blue: '#3B82F6',
        green: '#10B981',
        purple: '#8B5CF6',
        red: '#EF4444',
        cyan: '#06B6D4',
    };

    const chartDefaults = {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { legend: { display: false } },
    };

    // Labour Trend
    new Chart(document.getElementById('labourTrendChart'), {
        type: 'line',
        data: {
            labels: @json($labourTrend['labels']),
            datasets: [{
                label: 'Total Labour',
                data: @json($labourTrend['data']),
                borderColor: chartColors.amber,
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                fill: true,
                tension: 0.4,
                borderWidth: 2,
                pointRadius: 4,
                pointBackgroundColor: chartColors.amber,
            }]
        },
        options: { ...chartDefaults, scales: { y: { beginAtZero: true } } }
    });

    // Expense Trend
    new Chart(document.getElementById('expenseTrendChart'), {
        type: 'bar',
        data: {
            labels: @json($expenseTrend['labels']),
            datasets: [{
                label: 'Expenses',
                data: @json($expenseTrend['data']),
                backgroundColor: chartColors.blue,
                borderRadius: 6,
                barThickness: 32,
            }]
        },
        options: { ...chartDefaults, scales: { y: { beginAtZero: true } } }
    });

    // Payment Distribution
    new Chart(document.getElementById('paymentDistChart'), {
        type: 'doughnut',
        data: {
            labels: @json($paymentDistribution['labels']),
            datasets: [{
                data: @json($paymentDistribution['data']),
                backgroundColor: Object.values(chartColors),
                borderWidth: 0,
            }]
        },
        options: { ...chartDefaults, cutout: '65%', plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 10, padding: 10, font: { size: 11 } } } } }
    });

    // Labour Categories
    new Chart(document.getElementById('labourCategoryChart'), {
        type: 'pie',
        data: {
            labels: @json($labourCategories['labels']),
            datasets: [{
                data: @json($labourCategories['data']),
                backgroundColor: [chartColors.amber, chartColors.blue, chartColors.green, chartColors.purple],
                borderWidth: 0,
            }]
        },
        options: { ...chartDefaults, plugins: { legend: { display: true, position: 'bottom', labels: { boxWidth: 10, padding: 10, font: { size: 11 } } } } }
    });
});
</script>
@endpush
