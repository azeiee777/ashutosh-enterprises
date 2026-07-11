@extends('layouts.admin')
@section('title', $client->company_name)
@section('breadcrumb', 'Clients / ' . $client->company_name)
@section('content')
<div class="page-title-section"><div><h1>{{ $client->company_name }}</h1><p class="page-subtitle"><span class="status-badge {{ $client->status?->value ?? 'active' }}">{{ $client->status?->label() ?? 'Active' }}</span></p></div>
<div class="d-flex gap-2"><a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-admin-primary"><i class="bi bi-pencil"></i> Edit</a><a href="{{ route('admin.clients.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div></div>

<div class="row g-3">
    <div class="col-lg-4">
        <div class="admin-card"><div class="card-header"><h6>Client Details</h6></div><div class="card-body">
            <div class="mb-3"><small class="text-muted d-block">Contact Person</small><strong>{{ $client->contact_person }}</strong></div>
            <div class="mb-3"><small class="text-muted d-block">Mobile</small><a href="tel:{{ $client->mobile }}">{{ $client->mobile }}</a></div>
            @if($client->email)<div class="mb-3"><small class="text-muted d-block">Email</small><a href="mailto:{{ $client->email }}">{{ $client->email }}</a></div>@endif
            @if($client->gst)<div class="mb-3"><small class="text-muted d-block">GST</small>{{ $client->gst }}</div>@endif
            @if($client->address)<div class="mb-3"><small class="text-muted d-block">Address</small>{{ $client->address }}</div>@endif
            @if($client->notes)<div class="mb-3"><small class="text-muted d-block">Notes</small>{{ $client->notes }}</div>@endif
        </div></div>
    </div>
    <div class="col-lg-8">
        <div class="admin-card mb-3"><div class="card-header"><h6>Sites ({{ $client->sites->count() }})</h6><a href="{{ route('admin.sites.create', ['client_id' => $client->id]) }}" class="btn btn-sm btn-admin-primary"><i class="bi bi-plus"></i> Add Site</a></div>
        <div class="card-body">@forelse($client->sites as $site)<div class="d-flex justify-content-between align-items-center py-2 border-bottom"><div><strong>{{ $site->site_name }}</strong><br><small class="text-muted">{{ $site->address ?? 'No address' }}</small></div><span class="status-badge {{ $site->status?->value ?? 'active' }}">{{ $site->status?->label() ?? 'Active' }}</span></div>@empty<p class="text-muted mb-0">No sites added yet.</p>@endforelse</div></div>

        <div class="admin-card"><div class="card-header"><h6>Recent Labour Supply</h6></div>
        <div class="card-body">@forelse($client->dailyLabourSupplies as $supply)<div class="d-flex justify-content-between py-2 border-bottom"><div><strong>{{ $supply->date->format('d M Y') }}</strong> · {{ $supply->site?->site_name }}<br><small class="text-muted">S: {{ $supply->skilled_count }} · SS: {{ $supply->semi_skilled_count }} · US: {{ $supply->unskilled_count }}</small></div><strong>{{ $supply->total_count }} workers</strong></div>@empty<p class="text-muted mb-0">No records yet.</p>@endforelse</div></div>
    </div>
</div>
@endsection
