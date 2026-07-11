@extends('layouts.public')
@section('title', 'Gallery')
@section('content')
<div class="page-header"><div class="container"><h1>Gallery</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Gallery</li></ol></nav></div></div>
<section class="section"><div class="container">
<div class="text-center mb-4 animate-on-scroll"><a href="{{ route('gallery') }}" class="btn btn-sm {{ !request('category') ? 'btn-dark' : 'btn-outline-dark' }} rounded-pill mx-1">All</a>
@foreach($categories as $cat)<a href="{{ route('gallery', ['category' => $cat]) }}" class="btn btn-sm {{ request('category') == $cat ? 'btn-dark' : 'btn-outline-dark' }} rounded-pill mx-1 text-capitalize">{{ $cat }}</a>@endforeach</div>
<div class="row g-3">@forelse($images as $image)<div class="col-6 col-md-4 col-lg-3 animate-on-scroll"><div class="rounded-4 overflow-hidden border" style="aspect-ratio:1;background:#F1F5F9;display:flex;align-items:center;justify-content:center;"><div class="text-center p-3"><i class="bi bi-image" style="font-size:2rem;color:#CBD5E1;"></i><p class="mb-0 mt-1" style="font-size:0.8rem;color:#94A3B8;">{{ $image->title ?? 'Gallery Image' }}</p></div></div></div>@empty
<div class="empty-state animate-on-scroll"><i class="bi bi-images d-block" style="font-size:3rem;color:#94A3B8;"></i><h5>No Images Yet</h5><p>Gallery photos will be added soon.</p></div>@endforelse</div></div></section>
@endsection
