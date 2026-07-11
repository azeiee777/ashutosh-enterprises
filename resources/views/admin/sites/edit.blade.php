@extends('layouts.admin')
@section('title', 'Edit Site')
@section('breadcrumb', 'Sites / Edit')

@section('content')
<div class="page-title-section"><div><h1>Edit Site</h1></div><a href="{{ route('admin.sites.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.sites.update', $site) }}" class="admin-form">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Client *</label>
                <select name="client_id" class="form-select" required>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $site->client_id) == $client->id ? 'selected' : '' }}>{{ $client->company_name }}</option>
                    @endforeach
                </select>
                @error('client_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6"><label class="form-label">Site Name *</label><input type="text" name="site_name" class="form-control" required value="{{ old('site_name', $site->site_name) }}">@error('site_name')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Supervisor Name</label><input type="text" name="supervisor_name" class="form-control" value="{{ old('supervisor_name', $site->supervisor_name) }}"></div>
            <div class="col-md-6"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" value="{{ old('start_date', $site->start_date ? $site->start_date->format('Y-m-d') : '') }}"></div>
            <div class="col-md-6"><label class="form-label">Status</label>
                <select name="status" class="form-select">
                    <option value="active" {{ $site->status?->value == 'active' ? 'selected' : '' }}>Active</option>
                    <option value="completed" {{ $site->status?->value == 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="inactive" {{ $site->status?->value == 'inactive' ? 'selected' : '' }}>Inactive</option>
                </select>
            </div>
            <div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address', $site->address) }}</textarea></div>
            <div class="col-12"><label class="form-label">Remarks</label><textarea name="remarks" class="form-control" rows="2">{{ old('remarks', $site->remarks) }}</textarea></div>
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Update Site</button></div>
        </div>
    </form>
</div></div>
@endsection
