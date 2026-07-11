@extends('layouts.admin')
@section('title', 'Reports')
@section('breadcrumb', 'Analytics / Reports')

@section('content')
<div class="page-title-section">
    <div><h1>Reports</h1><p class="page-subtitle">Generate business insights</p></div>
</div>

<div class="admin-card mb-4"><div class="card-body">
    <form method="POST" action="{{ route('admin.reports.generate') }}" class="admin-form">@csrf
        <div class="row g-3 align-items-end">
            <div class="col-md-3">
                <label class="form-label">Report Type</label>
                <select name="report_type" class="form-select" required>
                    <option value="daily_labour" {{ (isset($type) && $type == 'daily_labour') ? 'selected' : '' }}>Daily Labour Report</option>
                    <option value="monthly_labour" {{ (isset($type) && $type == 'monthly_labour') ? 'selected' : '' }}>Monthly Labour Report</option>
                    <option value="client_wise_labour" {{ (isset($type) && $type == 'client_wise_labour') ? 'selected' : '' }}>Client-wise Labour Report</option>
                    <option value="site_wise_labour" {{ (isset($type) && $type == 'site_wise_labour') ? 'selected' : '' }}>Site-wise Labour Report</option>
                    <option value="payment" {{ (isset($type) && $type == 'payment') ? 'selected' : '' }}>Payment Report</option>
                    <option value="expense" {{ (isset($type) && $type == 'expense') ? 'selected' : '' }}>Expense Report</option>
                </select>
            </div>
            <div class="col-md-2">
                <label class="form-label">From Date</label>
                <input type="date" name="from" class="form-control" value="{{ $filters['from'] ?? date('Y-m-01') }}">
            </div>
            <div class="col-md-2">
                <label class="form-label">To Date</label>
                <input type="date" name="to" class="form-control" value="{{ $filters['to'] ?? date('Y-m-d') }}">
            </div>
            <div class="col-md-3">
                <label class="form-label">Client (Optional)</label>
                <select name="client_id" class="form-select">
                    <option value="">All Clients</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ (isset($filters['client_id']) && $filters['client_id'] == $client->id) ? 'selected' : '' }}>{{ $client->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-2">
                <button type="submit" class="btn btn-admin-primary w-100"><i class="bi bi-file-earmark-bar-graph"></i> Generate</button>
            </div>
        </div>
    </form>
</div></div>

@if(isset($data))
<div class="admin-card">
    <div class="card-header">
        <h6>Report Results: {{ ucwords(str_replace('_', ' ', $type)) }}</h6>
        <button type="button" class="btn btn-sm btn-outline-secondary" onclick="window.print()"><i class="bi bi-printer"></i> Print</button>
    </div>
    
    @if($data->count())
        <div class="table-responsive">
            <table class="admin-table">
                @if($type == 'daily_labour')
                    <thead><tr><th>Date</th><th>Client</th><th>Site</th><th>S</th><th>SS</th><th>US</th><th>Total</th></tr></thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr><td>{{ $row->date->format('d M Y') }}</td><td>{{ $row->client->company_name }}</td><td>{{ $row->site?->site_name ?? '-' }}</td><td>{{ $row->skilled_count }}</td><td>{{ $row->semi_skilled_count }}</td><td>{{ $row->unskilled_count }}</td><td><strong>{{ $row->total_count }}</strong></td></tr>
                        @endforeach
                    </tbody>
                @elseif($type == 'monthly_labour')
                    <thead><tr><th>Month</th><th>Client</th><th>Total S</th><th>Total SS</th><th>Total US</th><th>Grand Total</th></tr></thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr><td>{{ \Carbon\Carbon::parse($row->month.'-01')->format('M Y') }}</td><td>{{ $row->client->company_name }}</td><td>{{ $row->total_skilled }}</td><td>{{ $row->total_semi_skilled }}</td><td>{{ $row->total_unskilled }}</td><td><strong>{{ $row->grand_total }}</strong></td></tr>
                        @endforeach
                    </tbody>
                @elseif($type == 'client_wise_labour')
                    <thead><tr><th>Client</th><th>Total Days</th><th>Total S</th><th>Total SS</th><th>Total US</th><th>Grand Total</th></tr></thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr><td>{{ $row->client->company_name }}</td><td>{{ $row->total_days }}</td><td>{{ $row->total_skilled }}</td><td>{{ $row->total_semi_skilled }}</td><td>{{ $row->total_unskilled }}</td><td><strong>{{ $row->grand_total }}</strong></td></tr>
                        @endforeach
                    </tbody>
                @elseif($type == 'payment')
                    <thead><tr><th>Date</th><th>Client</th><th>Head</th><th>Amount</th><th>Method</th></tr></thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr><td>{{ $row->date->format('d M Y') }}</td><td>{{ $row->client->company_name }}</td><td>{{ $row->payment_head->label() }}</td><td>₹{{ number_format($row->amount, 2) }}</td><td>{{ $row->payment_method->label() }}</td></tr>
                        @endforeach
                    </tbody>
                @elseif($type == 'expense')
                    <thead><tr><th>Date</th><th>Category</th><th>Vendor</th><th>Description</th><th>Amount</th></tr></thead>
                    <tbody>
                        @foreach($data as $row)
                        <tr><td>{{ $row->date->format('d M Y') }}</td><td>{{ $row->category->label() }}</td><td>{{ $row->vendor ?? '-' }}</td><td>{{ $row->description ?? '-' }}</td><td>₹{{ number_format($row->amount, 2) }}</td></tr>
                        @endforeach
                    </tbody>
                @endif
            </table>
        </div>
    @else
        <div class="empty-state py-5"><i class="bi bi-inbox text-muted"></i><h6>No data found for the selected criteria.</h6></div>
    @endif
</div>
@endif
@endsection
