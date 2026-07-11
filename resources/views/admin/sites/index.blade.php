@extends('layouts.admin')
@section('title', 'Sites')
@section('breadcrumb', 'Management / Sites')

@section('content')
<div class="page-title-section">
    <div><h1>Sites</h1><p class="page-subtitle">Manage project sites and locations</p></div>
    <a href="{{ route('admin.sites.create') }}" class="btn btn-admin-primary"><i class="bi bi-plus-lg"></i> Add Site</a>
</div>

<div class="filter-bar">
    <form class="d-flex gap-2 flex-wrap w-100" method="GET">
        <input type="text" name="search" class="form-control" placeholder="Search sites..." value="{{ request('search') }}" style="max-width:250px;">
        <select name="client_id" class="form-select" style="max-width:200px;">
            <option value="">All Clients</option>
            @foreach($clients as $client)
                <option value="{{ $client->id }}" {{ request('client_id') == $client->id ? 'selected' : '' }}>{{ $client->company_name }}</option>
            @endforeach
        </select>
        <select name="status" class="form-select" style="max-width:160px;">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="completed" {{ request('status') == 'completed' ? 'selected' : '' }}>Completed</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button class="btn btn-admin-secondary">Filter</button>
        @if(request()->hasAny(['search','client_id','status']))<a href="{{ route('admin.sites.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="admin-card">
    @if($sites->count())
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Site Name</th><th>Client</th><th>Address</th><th>Supervisor</th><th>Start Date</th><th>Status</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sites as $site)
                <tr>
                    <td><strong>{{ $site->site_name }}</strong></td>
                    <td><a href="{{ route('admin.clients.show', $site->client) }}" class="text-decoration-none">{{ $site->client->company_name }}</a></td>
                    <td><span title="{{ $site->address }}">{{ Str::limit($site->address, 30) }}</span></td>
                    <td>{{ $site->supervisor_name ?? '-' }}</td>
                    <td>{{ $site->start_date ? $site->start_date->format('d M Y') : '-' }}</td>
                    <td><span class="status-badge {{ $site->status?->value ?? 'active' }}">{{ $site->status?->label() ?? 'Active' }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.sites.edit', $site) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.sites.destroy', $site) }}" onsubmit="return confirm('Delete this site?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $sites->links() }}</div>
    @else
    <div class="empty-state"><i class="bi bi-geo-alt"></i><h5>No Sites Yet</h5><p>Add a project site to get started.</p><a href="{{ route('admin.sites.create') }}" class="btn btn-admin-primary mt-2"><i class="bi bi-plus-lg"></i> Add Site</a></div>
    @endif
</div>
@endsection
