@extends('layouts.admin')
@section('title', 'Edit User')
@section('breadcrumb', 'Users / Edit')

@section('content')
<div class="page-title-section"><div><h1>Edit User</h1></div><a href="{{ route('admin.users.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="admin-form">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name', $user->name) }}">@error('name')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Email Address *</label><input type="email" name="email" class="form-control" required value="{{ old('email', $user->email) }}">@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone', $user->phone) }}"></div>
            <div class="col-md-6">
                <label class="form-label">Role *</label>
                <select name="role" class="form-select" required>
                    @foreach(\App\Enums\UserRole::cases() as $role)
                        <option value="{{ $role->value }}" {{ old('role', $user->role->value) == $role->value ? 'selected' : '' }}>{{ $role->label() }}</option>
                    @endforeach
                </select>
                @error('role')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6"><label class="form-label">New Password (leave blank to keep current)</label><input type="password" name="password" class="form-control" minlength="8">@error('password')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6 mt-md-4 pt-md-2">
                <div class="form-check form-switch">
                    <input class="form-check-input" type="checkbox" role="switch" name="is_active" id="isActive" value="1" {{ old('is_active', $user->is_active) ? 'checked' : '' }}>
                    <label class="form-check-label ms-2" for="isActive">Account is Active</label>
                </div>
            </div>
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Update User</button></div>
        </div>
    </form>
</div></div>
@endsection
