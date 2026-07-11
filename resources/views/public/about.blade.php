@extends('layouts.public')
@section('title', 'About Us')
@section('content')
<div class="page-header">
    <div class="container">
        <h1>About Us</h1>
        <nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">About</li></ol></nav>
    </div>
</div>

<section class="section">
    <div class="container">
        <div class="row align-items-center g-5">
            <div class="col-lg-6 animate-on-scroll">
                <span class="section-badge" style="text-align:left;display:inline-block;">Our Story</span>
                <h2 style="font-size:2.25rem;font-weight:800;">Building India's Workforce, One Project at a Time</h2>
                <p style="color:#64748B;line-height:1.8;font-size:1.05rem;">Ashutosh Enterprises has been a trusted name in the labour supply industry for over 15 years. Founded with a vision to bridge the gap between businesses and reliable workforce, we have grown to become one of India's leading manpower contractors.</p>
                <p style="color:#64748B;line-height:1.8;font-size:1.05rem;">We serve construction, manufacturing, warehousing, and hospitality sectors with verified, trained, and dependable workers. Our commitment to quality, safety, and timely delivery sets us apart.</p>
            </div>
            <div class="col-lg-6 animate-on-scroll">
                <div class="row g-3">
                    <div class="col-6"><div class="p-4 rounded-4 text-center" style="background:rgba(245,158,11,0.08);"><h3 style="color:#F59E0B;font-weight:800;">15+</h3><p class="mb-0" style="font-weight:600;">Years Experience</p></div></div>
                    <div class="col-6"><div class="p-4 rounded-4 text-center" style="background:rgba(59,130,246,0.08);"><h3 style="color:#3B82F6;font-weight:800;">500+</h3><p class="mb-0" style="font-weight:600;">Daily Workers</p></div></div>
                    <div class="col-6"><div class="p-4 rounded-4 text-center" style="background:rgba(16,185,129,0.08);"><h3 style="color:#10B981;font-weight:800;">100+</h3><p class="mb-0" style="font-weight:600;">Happy Clients</p></div></div>
                    <div class="col-6"><div class="p-4 rounded-4 text-center" style="background:rgba(139,92,246,0.08);"><h3 style="color:#8B5CF6;font-weight:800;">50+</h3><p class="mb-0" style="font-weight:600;">Active Projects</p></div></div>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section section-light">
    <div class="container">
        <div class="section-heading animate-on-scroll"><span class="section-badge">Our Beliefs</span><h2>Mission, Vision & Values</h2></div>
        <div class="row g-4">
            <div class="col-lg-4 animate-on-scroll">
                <div class="p-4 rounded-4 bg-white border h-100">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width:56px;height:56px;background:rgba(245,158,11,0.1);"><i class="bi bi-bullseye" style="font-size:1.5rem;color:#F59E0B;"></i></div>
                    <h5>Our Mission</h5>
                    <p style="color:#64748B;">To provide reliable, skilled, and compliant manpower solutions that empower businesses to achieve their goals efficiently and safely.</p>
                </div>
            </div>
            <div class="col-lg-4 animate-on-scroll">
                <div class="p-4 rounded-4 bg-white border h-100">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width:56px;height:56px;background:rgba(59,130,246,0.1);"><i class="bi bi-eye" style="font-size:1.5rem;color:#3B82F6;"></i></div>
                    <h5>Our Vision</h5>
                    <p style="color:#64748B;">To become India's most trusted workforce partner, known for quality, reliability, and innovation in labour supply solutions.</p>
                </div>
            </div>
            <div class="col-lg-4 animate-on-scroll">
                <div class="p-4 rounded-4 bg-white border h-100">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-3 mb-3" style="width:56px;height:56px;background:rgba(16,185,129,0.1);"><i class="bi bi-heart" style="font-size:1.5rem;color:#10B981;"></i></div>
                    <h5>Core Values</h5>
                    <p style="color:#64748B;">Integrity, Reliability, Safety, Transparency, and Excellence drive everything we do. We treat every worker with dignity and every client with respect.</p>
                </div>
            </div>
        </div>
    </div>
</section>

<section class="section">
    <div class="container">
        <div class="section-heading animate-on-scroll"><span class="section-badge">Trust</span><h2>Why Customers Trust Us</h2></div>
        <div class="row g-4">
            @php $reasons = [['icon'=>'bi-shield-check','title'=>'Verified Workers','desc'=>'Every worker is verified, documented, and trained before deployment.'],['icon'=>'bi-clock','title'=>'24-Hour Deployment','desc'=>'We can deploy the right workforce within 24 hours of your request.'],['icon'=>'bi-headset','title'=>'Dedicated Support','desc'=>'Our supervisors are available on-site to ensure smooth operations.'],['icon'=>'bi-graph-up','title'=>'Scalable Solutions','desc'=>'From 10 to 1000+ workers, we scale according to your project needs.'],['icon'=>'bi-award','title'=>'Compliance Assured','desc'=>'Full compliance with labour laws, PF, ESI, and safety regulations.'],['icon'=>'bi-currency-rupee','title'=>'Competitive Pricing','desc'=>'Transparent pricing with no hidden costs. Pay only for what you use.']]; @endphp
            @foreach($reasons as $reason)
            <div class="col-md-6 col-lg-4 animate-on-scroll">
                <div class="d-flex gap-3 p-3">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-3 flex-shrink-0" style="width:48px;height:48px;background:rgba(245,158,11,0.1);"><i class="bi {{ $reason['icon'] }}" style="font-size:1.25rem;color:#F59E0B;"></i></div>
                    <div><h6 style="font-weight:700;">{{ $reason['title'] }}</h6><p style="color:#64748B;font-size:0.9rem;margin:0;">{{ $reason['desc'] }}</p></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endsection
