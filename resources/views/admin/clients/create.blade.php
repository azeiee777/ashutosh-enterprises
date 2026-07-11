@extends('layouts.admin')
@section('title', 'Add Client')
@section('breadcrumb', 'Clients / Add New')

@section('content')
<div class="page-title-section"><div><h1>Add New Client</h1></div><a href="{{ route('admin.clients.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.clients.store') }}" class="admin-form">@csrf
        <div class="row g-3">
            <div class="col-md-6"><label class="form-label">Company Name *</label><input type="text" name="company_name" class="form-control" required value="{{ old('company_name') }}">@error('company_name')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Contact Person *</label><input type="text" name="contact_person" class="form-control" required value="{{ old('contact_person') }}">@error('contact_person')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Mobile *</label><input type="text" name="mobile" class="form-control" required value="{{ old('mobile') }}">@error('mobile')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Email</label><input type="email" name="email" class="form-control" value="{{ old('email') }}">@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">GST Number</label><input type="text" name="gst" class="form-control" value="{{ old('gst') }}"></div>
            <div class="col-md-6"><label class="form-label">Status</label><select name="status" class="form-select"><option value="active">Active</option><option value="inactive">Inactive</option></select></div>
            <div class="col-12"><label class="form-label">Address</label><textarea name="address" class="form-control" rows="2">{{ old('address') }}</textarea></div>
            <div class="col-12"><label class="form-label">Notes</label><textarea name="notes" class="form-control" rows="2">{{ old('notes') }}</textarea></div>
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Save Client</button></div>
        </div>
    </form>
</div></div>
@endsection
