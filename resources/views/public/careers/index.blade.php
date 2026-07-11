@extends('layouts.public')
@section('title', 'Careers')
@section('content')
<div class="page-header"><div class="container"><h1>Careers</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Careers</li></ol></nav></div></div>
<section class="section"><div class="container"><div class="row g-5">
<div class="col-lg-7"><div class="section-heading animate-on-scroll" style="text-align:left;"><span class="section-badge">Join Us</span><h2>Current Openings</h2></div>
@forelse($careers as $career)<div class="p-4 rounded-4 border mb-3 animate-on-scroll" style="transition:all 0.3s;" onmouseover="this.style.borderColor='#F59E0B'" onmouseout="this.style.borderColor=''">
<div class="d-flex justify-content-between align-items-start flex-wrap gap-2"><div><h5 class="mb-1">{{ $career->title }}</h5><p style="color:#64748B;font-size:0.9rem;margin:0;"><i class="bi bi-geo-alt me-1"></i>{{ $career->location ?? 'Multiple Locations' }} · <i class="bi bi-briefcase me-1"></i>{{ ucfirst($career->type) }}</p></div><span class="badge rounded-pill" style="background:rgba(16,185,129,0.1);color:#10B981;">Open</span></div>
@if($career->description)<p class="mt-2 mb-0" style="color:#64748B;font-size:0.9rem;">{{ Str::limit($career->description, 150) }}</p>@endif</div>@empty
<div class="empty-state animate-on-scroll"><i class="bi bi-briefcase d-block" style="font-size:3rem;color:#94A3B8;"></i><h5>No Openings Right Now</h5><p>We don't have any openings at the moment, but feel free to send your resume for future opportunities.</p></div>@endforelse</div>
<div class="col-lg-5"><div class="p-4 rounded-4 border animate-on-scroll" style="position:sticky;top:100px;">
<h5 class="mb-3"><i class="bi bi-file-earmark-person me-2" style="color:#F59E0B;"></i>Apply Now</h5>
@if(session('success'))<div class="alert alert-success">{{ session('success') }}</div>@endif
<form method="POST" action="{{ route('careers.apply') }}" enctype="multipart/form-data">@csrf
<div class="mb-3"><label class="form-label fw-semibold">Full Name *</label><input type="text" name="name" class="form-control rounded-3" required value="{{ old('name') }}">@error('name')<small class="text-danger">{{ $message }}</small>@enderror</div>
<div class="mb-3"><label class="form-label fw-semibold">Email *</label><input type="email" name="email" class="form-control rounded-3" required value="{{ old('email') }}">@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
<div class="mb-3"><label class="form-label fw-semibold">Phone *</label><input type="tel" name="phone" class="form-control rounded-3" required value="{{ old('phone') }}">@error('phone')<small class="text-danger">{{ $message }}</small>@enderror</div>
<div class="mb-3"><label class="form-label fw-semibold">Cover Letter</label><textarea name="cover_letter" class="form-control rounded-3" rows="3">{{ old('cover_letter') }}</textarea></div>
<div class="mb-3"><label class="form-label fw-semibold">Resume (PDF/DOC) *</label><input type="file" name="resume" class="form-control rounded-3" accept=".pdf,.doc,.docx" required>@error('resume')<small class="text-danger">{{ $message }}</small>@enderror</div>
<button type="submit" class="btn btn-admin-primary w-100">Submit Application</button>
</form></div></div></div></div></section>
@endsection
