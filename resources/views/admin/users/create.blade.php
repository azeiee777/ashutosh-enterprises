@extends('layouts.admin')
@section('title', 'Add User')
@section('breadcrumb', 'Users / Add New')

@section('content')
<div class="page-title-section"><div><h1>Add New User</h1></div><a href="{{ route('admin.users.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.users.store') }}" class="admin-form">@csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Full Name *</label><input type="text" name="name" class="form-control" required value="{{ old('name') }}">@error('name')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Email Address *</label><input type="email" name="email" class="form-control" required value="{{ old('email') }}">@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Phone</label><input type="text" name="phone" class="form-control" value="{{ old('phone') }}"></div>
            <div class="col-md-6">
                <label class="form-label">Role *</label>
                <select name="role" class="form-select" required>
                    @foreach(\App\Enums\UserRole::cases() as $role)
                        <option value="{{ $role->value }}" {{ old('role') == $role->value ? 'selected' : '' }}>{{ $role->label() }}</option>
                    @endforeach
                </select>
                @error('role')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6"><label class="form-label">Password *</label><input type="password" name="password" class="form-control" required minlength="8">@error('password')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Save User</button></div>
        </div>
    </form>
</div></div>
@endsection
