@extends('layouts.admin')
@section('title', 'Company Settings')
@section('breadcrumb', 'Settings / General')

@section('content')
<div class="page-title-section">
    <div><h1>Company Settings</h1><p class="page-subtitle">Configure application defaults and information</p></div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" class="admin-form">@csrf @method('PUT')
<div class="row g-4">
    @foreach(['general' => 'General Settings', 'contact' => 'Contact Information', 'social' => 'Social Links', 'invoice' => 'Invoice Settings'] as $group => $label)
    @if(isset($settings[$group]))
    <div class="col-md-6">
        <div class="admin-card h-100">
            <div class="card-header"><h6>{{ $label }}</h6></div>
            <div class="card-body">
                @foreach($settings[$group] as $setting)
                <div class="mb-3">
                    <label class="form-label">{{ $setting->key }}</label>
                    <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                </div>
                @endforeach
            </div>
        </div>
    </div>
    @endif
    @endforeach
</div>

<div class="mt-4 pb-5">
    <button type="submit" class="btn btn-admin-primary px-4 py-2"><i class="bi bi-save"></i> Save All Settings</button>
</div>
</form>
@endsection
