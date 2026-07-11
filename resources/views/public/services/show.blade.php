@extends('layouts.public')
@section('title', $service->title)
@section('content')
<div class="page-header"><div class="container"><h1>{{ $service->title }}</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item"><a href="{{ route('services.index') }}">Services</a></li><li class="breadcrumb-item active">{{ $service->title }}</li></ol></nav></div></div>
<section class="section"><div class="container"><div class="row g-5"><div class="col-lg-8"><div class="animate-on-scroll">{!! nl2br(e($service->description)) !!}</div></div>
<div class="col-lg-4"><div class="p-4 rounded-4 border animate-on-scroll"><h5 class="mb-3">Need This Service?</h5><p style="color:#64748B;">Contact us to discuss your requirements and get a customized quote.</p><a href="{{ route('contact') }}" class="btn btn-admin-primary w-100 mb-2"><i class="bi bi-envelope"></i> Contact Us</a><a href="tel:+917618876215" class="btn btn-admin-secondary w-100"><i class="bi bi-telephone"></i> Call Now</a></div>
@if($relatedServices->count())<div class="mt-4 animate-on-scroll"><h6>Related Services</h6>@foreach($relatedServices as $related)<a href="{{ route('services.show', $related) }}" class="d-block p-3 border rounded-3 mb-2 text-decoration-none" style="color:inherit;transition:all 0.2s;" onmouseover="this.style.borderColor='#F59E0B'" onmouseout="this.style.borderColor=''"><strong>{{ $related->title }}</strong></a>@endforeach</div>@endif</div></div></div></section>
@endsection
