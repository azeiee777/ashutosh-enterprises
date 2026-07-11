@extends('layouts.public')
@section('title', 'Services')
@section('content')
<div class="page-header"><div class="container"><h1>Our Services</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Services</li></ol></nav></div></div>
<section class="section"><div class="container"><div class="section-heading animate-on-scroll"><span class="section-badge">What We Offer</span><h2>Complete Manpower Solutions</h2><p>From skilled technicians to general labour, we cover all your workforce needs</p></div>
<div class="row g-4">@foreach($services as $service)<div class="col-lg-4 col-md-6 animate-on-scroll"><a href="{{ route('services.show', $service) }}" class="service-card"><div class="service-icon"><i class="bi {{ $service->icon ?? 'bi-people' }}"></i></div><h5>{{ $service->title }}</h5><p>{{ $service->short_description }}</p><span style="color:#F59E0B;font-weight:600;font-size:0.9rem;">Learn More <i class="bi bi-arrow-right"></i></span></a></div>@endforeach</div></div></section>
@endsection
