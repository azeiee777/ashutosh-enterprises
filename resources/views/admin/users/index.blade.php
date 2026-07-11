@extends('layouts.admin')
@section('title', 'Users')
@section('breadcrumb', 'Settings / Users')

@section('content')
<div class="page-title-section">
    <div><h1>User Management</h1><p class="page-subtitle">Manage system users and access roles</p></div>
    <a href="{{ route('admin.users.create') }}" class="btn btn-admin-primary"><i class="bi bi-plus-lg"></i> Add User</a>
</div>

<div class="filter-bar">
    <form class="d-flex gap-2 flex-wrap w-100" method="GET">
        <input type="text" name="search" class="form-control" placeholder="Search users..." value="{{ request('search') }}" style="max-width:250px;">
        <select name="role" class="form-select" style="max-width:160px;" onchange="this.form.submit()">
            <option value="">All Roles</option>
            @foreach(\App\Enums\UserRole::cases() as $role)
                <option value="{{ $role->value }}" {{ request('role') == $role->value ? 'selected' : '' }}>{{ $role->label() }}</option>
            @endforeach
        </select>
        <button class="btn btn-admin-secondary">Filter</button>
        @if(request()->hasAny(['search','role']))<a href="{{ route('admin.users.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="admin-card">
    @if($users->count())
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>User</th><th>Email</th><th>Phone</th><th>Role</th><th>Status</th><th>Joined</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($users as $user)
                <tr>
                    <td>
                        <div class="d-flex align-items-center gap-2">
                            <div class="rounded-circle d-flex align-items-center justify-content-center text-white fw-bold" style="width:32px;height:32px;background:linear-gradient(135deg, #F59E0B, #D97706);">
                                {{ substr($user->name, 0, 1) }}
                            </div>
                            <strong>{{ $user->name }}</strong>
                        </div>
                    </td>
                    <td>{{ $user->email }}</td>
                    <td>{{ $user->phone ?? '-' }}</td>
                    <td><span class="badge bg-secondary">{{ $user->role->label() }}</span></td>
                    <td>
                        @if($user->is_active)
                            <span class="status-badge active">Active</span>
                        @else
                            <span class="status-badge inactive">Inactive</span>
                        @endif
                    </td>
                    <td>{{ $user->created_at->format('d M Y') }}</td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            @if(auth()->id() !== $user->id)
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $users->links() }}</div>
    @else
    <div class="empty-state"><i class="bi bi-people"></i><h5>No Users Found</h5></div>
    @endif
</div>
@endsection
