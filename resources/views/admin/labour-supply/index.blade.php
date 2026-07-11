@extends('layouts.admin')
@section('title', 'Labour Supply')
@section('breadcrumb', 'Operations / Labour Supply')

@section('content')
<div class="page-title-section">
    <div><h1>Labour Supply Records</h1><p class="page-subtitle">Track daily manpower deployment</p></div>
    <a href="{{ route('admin.labour-supply.create') }}" class="btn btn-admin-primary"><i class="bi bi-plus-lg"></i> Add Record</a>
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
        <button class="btn btn-admin-secondary">Filter</button>
        @if(request()->hasAny(['date_from','date_to','client_id']))<a href="{{ route('admin.labour-supply.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
        
        <div class="ms-auto d-flex gap-2">
            <a href="{{ route('admin.labour-supply.export', request()->query()) }}" class="btn btn-success"><i class="bi bi-file-earmark-spreadsheet"></i> Export Excel</a>
            <a href="{{ route('admin.labour-supply.export_pdf', request()->query()) }}" class="btn btn-danger" target="_blank"><i class="bi bi-file-earmark-pdf"></i> Export PDF</a>
        </div>
    </form>
</div>

<div class="admin-card">
    @if($supplies->count())
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th><th>Client / Site</th><th>Skilled</th><th>Semi-Skilled</th><th>Unskilled</th><th>Total</th><th>Shift</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($supplies as $supply)
                <tr>
                    <td><strong>{{ $supply->date->format('d M Y') }}</strong></td>
                    <td>
                        @if($supply->client)
                            <a href="{{ route('admin.clients.show', $supply->client) }}" class="text-decoration-none fw-semibold">{{ $supply->client->company_name }}</a>
                        @else
                            <span class="fw-semibold text-muted">-</span>
                        @endif
                        <br><small class="text-muted">{{ $supply->site?->site_name }}</small>
                    </td>
                    <td>{{ $supply->skilled_count }}</td>
                    <td>{{ $supply->semi_skilled_count }}</td>
                    <td>{{ $supply->unskilled_count }}</td>
                    <td><strong>{{ $supply->total_count }}</strong></td>
                    <td><span class="badge bg-secondary">{{ $supply->shift->label() }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.labour-supply.edit', $supply) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.labour-supply.destroy', $supply) }}" onsubmit="return confirm('Delete this record?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $supplies->links() }}</div>
    @else
    <div class="empty-state"><i class="bi bi-people"></i><h5>No Records Found</h5><p>Add a daily labour supply entry.</p><a href="{{ route('admin.labour-supply.create') }}" class="btn btn-admin-primary mt-2"><i class="bi bi-plus-lg"></i> Add Record</a></div>
    @endif
</div>
@endsection
