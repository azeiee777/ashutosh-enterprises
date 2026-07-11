@extends('layouts.public')
@section('title', 'Our Clients')
@section('content')
<div class="page-header"><div class="container"><h1>Our Clients</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Clients</li></ol></nav></div></div>
<section class="section"><div class="container"><div class="section-heading animate-on-scroll"><span class="section-badge">Partners</span><h2>Companies That Trust Us</h2><p>We are proud to work with leading organizations across India</p></div>
<div class="row g-4 justify-content-center">@foreach($clients as $client)<div class="col-6 col-md-4 col-lg-3 animate-on-scroll"><div class="p-4 rounded-4 border text-center h-100" style="transition:all 0.3s;" onmouseover="this.style.borderColor='#F59E0B';this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='';this.style.transform=''"><h6 class="mb-1">{{ $client->name }}</h6>@if($client->website)<a href="{{ $client->website }}" target="_blank" class="text-muted" style="font-size:0.8rem;">Visit Website</a>@endif</div></div>@endforeach</div>
@if($clients->isEmpty())<div class="empty-state animate-on-scroll"><i class="bi bi-buildings d-block" style="font-size:3rem;color:#94A3B8;"></i><h5>Coming Soon</h5><p>Our client showcase is being updated. Check back soon!</p></div>@endif</div></section>
@endsection
