@extends('layouts.admin')
@section('title', 'Company Settings')
@section('breadcrumb', 'Settings / General')

@section('content')
<div class="page-title-section">
    <div><h1>Company Settings</h1><p class="page-subtitle">Configure application defaults and information</p></div>
</div>

<form method="POST" action="{{ route('admin.settings.update') }}" class="admin-form" enctype="multipart/form-data">@csrf @method('PUT')
<div class="row g-4">
    @foreach(['general' => 'General Settings', 'contact' => 'Contact Information', 'social' => 'Social Links', 'invoice' => 'Invoice Settings'] as $group => $label)
    @if(isset($settings[$group]))
    <div class="col-md-6">
        <div class="admin-card h-100">
            <div class="card-header"><h6>{{ $label }}</h6></div>
            <div class="card-body">
                @foreach($settings[$group] as $setting)
                @if($setting->key === 'Company_Name') @continue @endif
                <div class="mb-3">
                    <label class="form-label">{{ $setting->key }}</label>
                    @if(str_contains(strtolower($setting->key), 'logo') || str_contains(strtolower($setting->key), 'favicon'))
                        @if($setting->value)
                            <div class="mb-2"><img src="{{ asset('storage/' . $setting->value) }}" height="40" alt="{{ $setting->key }}" class="border rounded p-1 bg-light"></div>
                        @endif
                        <input type="file" name="{{ $setting->key }}" class="form-control" accept="image/*">
                    @elseif(str_contains(strtolower($setting->key), 'address'))
                        <textarea name="{{ $setting->key }}" class="form-control" rows="2">{{ $setting->value }}</textarea>
                    @else
                        <input type="text" name="{{ $setting->key }}" class="form-control" value="{{ $setting->value }}">
                    @endif
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
