@extends('layouts.admin')
@section('title', 'Clients')
@section('breadcrumb', 'Management / Clients')

@section('content')
<div class="page-title-section">
    <div><h1>Clients</h1><p class="page-subtitle">Manage your client companies</p></div>
    <a href="{{ route('admin.clients.create') }}" class="btn btn-admin-primary"><i class="bi bi-plus-lg"></i> Add Client</a>
</div>

<div class="filter-bar">
    <form class="d-flex gap-2 flex-wrap w-100" method="GET">
        <input type="text" name="search" class="form-control" placeholder="Search clients..." value="{{ request('search') }}" style="max-width:250px;">
        <select name="status" class="form-select" style="max-width:160px;" onchange="this.form.submit()">
            <option value="">All Status</option>
            <option value="active" {{ request('status') == 'active' ? 'selected' : '' }}>Active</option>
            <option value="inactive" {{ request('status') == 'inactive' ? 'selected' : '' }}>Inactive</option>
        </select>
        <button class="btn btn-admin-secondary">Filter</button>
        @if(request()->hasAny(['search','status']))<a href="{{ route('admin.clients.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="admin-card">
    @if($clients->count())
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Company</th><th>Contact Person</th><th>Mobile</th><th>Email</th><th>Status</th><th>Sites</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($clients as $client)
                <tr>
                    <td><strong>{{ $client->company_name }}</strong></td>
                    <td>{{ $client->contact_person }}</td>
                    <td>{{ $client->mobile }}</td>
                    <td>{{ $client->email ?? '-' }}</td>
                    <td><span class="status-badge {{ $client->status?->value ?? 'active' }}">{{ $client->status?->label() ?? 'Active' }}</span></td>
                    <td>{{ $client->sites_count ?? $client->sites->count() }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.clients.show', $client) }}" class="btn btn-sm btn-outline-secondary" title="View"><i class="bi bi-eye"></i></a>
                            <a href="{{ route('admin.clients.edit', $client) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Delete this client?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $clients->links() }}</div>
    @else
    <div class="empty-state"><i class="bi bi-buildings"></i><h5>No Clients Yet</h5><p>Add your first client to get started.</p><a href="{{ route('admin.clients.create') }}" class="btn btn-admin-primary mt-2"><i class="bi bi-plus-lg"></i> Add Client</a></div>
    @endif
</div>
@endsection
