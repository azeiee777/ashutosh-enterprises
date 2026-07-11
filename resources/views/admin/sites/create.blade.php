@extends('layouts.admin')
@section('title', 'Add Site')
@section('breadcrumb', 'Sites / Add New')

@section('content')
<div class="page-title-section"><div><h1>Add New Site</h1></div><a href="{{ route('admin.sites.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.sites.store') }}" class="admin-form">@csrf
        <div class="row g-3">
            <div class="col-md-6">
                <label class="form-label">Client *</label>
                <select name="client_id" class="form-select" required>
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', request('client_id')) == $client->id ? 'selected' : '' }}>{{ $client->company_name }}</option>
                    @endforeach
                </select>
                @error('client_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-6"><label class="form-label">Site Name *</label><input type="text" name="site_name" class="form-control" required value="{{ old('site_name') }}">@error('site_name')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Supervisor Name</label><input type="text" name="supervisor_name" class="form-control" value="{{ old('supervisor_name') }}"></div>
            <div class="col-md-6"><label class="form-label">Start Date</label><input type="date" name="start_date" class="form-control" value="{{ old('start_date') }}"></div>
            <div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="completed">Completed</option><option value="inactive">Inactive</option></select></div>
            <div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
            <div class="col-12"><label class="form-label">Remarks</label><textarea name="remarks" class="form-control" rows="2">{{ old('remarks') }}</textarea></div>
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Save Site</button></div>
        </div>
    </form>
</div></div>
@endsection
