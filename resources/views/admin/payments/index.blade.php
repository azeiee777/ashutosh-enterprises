@extends('layouts.admin')
@section('title', 'Payments')
@section('breadcrumb', 'Operations / Payments')

@section('content')
<div class="page-title-section">
    <div><h1>Payment Records</h1><p class="page-subtitle">Track incoming and outgoing payments</p></div>
    <a href="{{ route('admin.payments.create') }}" class="btn btn-admin-primary"><i class="bi bi-plus-lg"></i> Add Payment</a>
</div>

<div class="filter-bar">
    <form class="d-flex gap-2 flex-wrap w-100" method="GET">
        <input type="date" name="date_from" class="form-control" title="From Date" value="{{ request('date_from') }}" style="max-width:150px;">
        <input type="date" name="date_to" class="form-control" title="To Date" value="{{ request('date_to') }}" style="max-width:150px;">
        <select name="client_id" class="form-select" style="max-width:200px;">
            <option value="">All Clients</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->company_name }}</option>
            @endforeach
        </select>
        <select name="payment_head" class="form-select" style="max-width:160px;">
            <option value="">All Heads</option>
            @foreach(\App\Enums\PaymentHead::cases() as $head)
                <option value="{{ $head->value }}" {{ request('payment_head') == $head->value ? 'selected' : '' }}>{{ $head->label() }}</option>
            @endforeach
        </select>
        <button class="btn btn-admin-secondary">Filter</button>
        @if(request()->hasAny(['date_from','date_to','client_id','payment_head']))<a href="{{ route('admin.payments.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
        
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('admin.payments.export', request()->query()) }}" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet"></i> Export Excel</a>
            <a href="{{ route('admin.payments.export_pdf', request()->query()) }}" class="btn btn-danger" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
        </div>
    </form>
</div>

<div class="admin-card">
    @if($payments->count())
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th><th>Client / Site</th><th>Head</th><th>Amount (₹)</th><th>Method</th><th>Ref No.</th><th>Attachment</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($payments as $payment)
                <tr>
                    <td><strong>{{ $payment->date->format('d M Y') }}</strong></td>
                    <td>
                        @if($payment->client)
                            <a href="{{ route('admin.clients.show', $payment->client) }}" class="text-decoration-none">{{ $payment->client->company_name }}</a>
                        @else
                            <span class="text-muted">-</span>
                        @endif
                        <br><small class="text-muted">{{ $payment->site?->site_name ?? 'N/A' }}</small>
                    </td>
                    <td><span class="badge {{ $payment->payment_head->value == 'advance' ? 'bg-warning text-dark' : 'bg-success' }}">{{ $payment->payment_head->label() }}</span></td>
                    <td><strong>{{ number_format($payment->amount, 2) }}</strong></td>
                    <td>{{ $payment->payment_method->label() }}</td>
                    <td>{{ $payment->reference_number ?? '-' }}</td>
                    <td>
                        @if($payment->attachment_path)
                            <a href="{{ asset('storage/' . $payment->attachment_path) }}" target="_blank" class="btn btn-sm btn-outline-secondary" title="View Attachment"><i class="bi bi-paperclip"></i> View</a>
                        @else
                            -
                        @endif
                    </td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.payments.edit', $payment) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.payments.destroy', $payment) }}" onsubmit="return confirm('Delete this record?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $payments->links() }}</div>
    @else
    <div class="empty-state"><i class="bi bi-cash-stack"></i><h5>No Payments Found</h5><p>Add a payment record.</p><a href="{{ route('admin.payments.create') }}" class="btn btn-admin-primary mt-2"><i class="bi bi-plus-lg"></i> Add Payment</a></div>
    @endif
</div>
@endsection
