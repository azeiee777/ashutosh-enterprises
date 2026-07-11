@extends('layouts.public')

@section('title', 'Home')
@section('meta_description', 'Ashutosh Enterprises - India\'s trusted labour supply contractor. We provide skilled, semi-skilled, and unskilled manpower for construction, factories, and warehouses.')

@section('content')
{{-- Hero Section --}}
<section class="hero-section">
    <div class="container position-relative" style="z-index: 2;">
        <div class="row align-items-center">
            <div class="col-lg-7">
                <div class="hero-badge">
                    <i class="bi bi-shield-check"></i> Trusted by 100+ Companies
                </div>
                <h1>Reliable <span class="text-accent">Workforce</span> Solutions for Every Industry</h1>
                <p class="hero-text">
                    We provide skilled, semi-skilled, and unskilled labour for construction sites, factories,
                    warehouses, and more. On time, every time — with verified, trained manpower.
                </p>
                <div class="hero-actions">
                    <a href="{{ route('contact') }}" class="btn-hero-primary">
                        Get Started <i class="bi bi-arrow-right"></i>
                    </a>
                    <a href="{{ route('services.index') }}" class="btn-hero-secondary">
                        Our Services
                    </a>
                </div>
                <div class="hero-stats">
                    <div class="stat-item">
                        <span class="stat-number counter-value" data-count="500">0</span>
                        <span class="stat-label">Workers Deployed Daily</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number counter-value" data-count="100">0</span>
                        <span class="stat-label">Happy Clients</span>
                    </div>
                    <div class="stat-item">
                        <span class="stat-number counter-value" data-count="15">0</span>
                        <span class="stat-label">Years Experience</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- Services Section --}}
<section class="section">
    <div class="container">
        <div class="section-heading animate-on-scroll">
            <span class="section-badge">What We Do</span>
            <h2>Our Services</h2>
            <p>Complete manpower solutions tailored to your industry requirements</p>
        </div>
        <div class="row g-4">
            @foreach($services as $service)
            <div class="col-lg-4 col-md-6 animate-on-scroll">
                <a href="{{ route('services.show', $service) }}" class="service-card">
                    <div class="service-icon">
                        <i class="bi {{ $service->icon ?? 'bi-people' }}"></i>
                    </div>
                    <h5>{{ $service->title }}</h5>
                    <p>{{ $service->short_description }}</p>
                </a>
            </div>
            @endforeach
        </div>
        <div class="text-center mt-4 animate-on-scroll">
            <a href="{{ route('services.index') }}" class="btn btn-outline-dark rounded-pill px-4">
                View All Services <i class="bi bi-arrow-right"></i>
            </a>
        </div>
    </div>
</section>

{{-- Stats Section --}}
<section class="stats-section">
    <div class="container">
        <div class="row g-4">
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <span class="counter-value" data-count="500">0</span><span class="stat-suffix">+</span>
                    <div class="stat-label">Workers Deployed Daily</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <span class="counter-value" data-count="100">0</span><span class="stat-suffix">+</span>
                    <div class="stat-label">Satisfied Clients</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <span class="counter-value" data-count="50">0</span><span class="stat-suffix">+</span>
                    <div class="stat-label">Active Projects</div>
                </div>
            </div>
            <div class="col-6 col-lg-3">
                <div class="stat-card">
                    <span class="counter-value" data-count="15">0</span><span class="stat-suffix">+</span>
                    <div class="stat-label">Years Experience</div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- How We Work --}}
<section class="section section-light">
    <div class="container">
        <div class="section-heading animate-on-scroll">
            <span class="section-badge">Our Process</span>
            <h2>How We Work</h2>
            <p>A simple, transparent process to get the workforce you need</p>
        </div>
        <div class="row g-4">
            @php
                $steps = [
                    ['icon' => 'bi-telephone', 'title' => 'Contact Us', 'desc' => 'Reach out with your manpower requirements. We\'re available via phone, email, or WhatsApp.'],
                    ['icon' => 'bi-clipboard-check', 'title' => 'Requirement Analysis', 'desc' => 'We analyze your specific needs including skill levels, quantity, and timeline.'],
                    ['icon' => 'bi-people-fill', 'title' => 'Deploy Workforce', 'desc' => 'Verified, trained workers are deployed to your site within the agreed timeframe.'],
                    ['icon' => 'bi-graph-up', 'title' => 'Monitor & Support', 'desc' => 'Continuous monitoring, supervision, and support throughout the engagement.'],
                ];
            @endphp
            @foreach($steps as $index => $step)
            <div class="col-md-6 col-lg-3 animate-on-scroll">
                <div class="text-center">
                    <div class="d-inline-flex align-items-center justify-content-center rounded-circle mb-3" style="width: 72px; height: 72px; background: rgba(245, 158, 11, 0.1);">
                        <i class="bi {{ $step['icon'] }}" style="font-size: 1.75rem; color: #F59E0B;"></i>
                    </div>
                    <div class="mb-2">
                        <span class="badge rounded-pill" style="background: #0F172A; font-size: 0.75rem;">Step {{ $index + 1 }}</span>
                    </div>
                    <h5 style="font-weight: 700;">{{ $step['title'] }}</h5>
                    <p style="color: #64748B; font-size: 0.95rem;">{{ $step['desc'] }}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Industries Served --}}
<section class="section">
    <div class="container">
        <div class="section-heading animate-on-scroll">
            <span class="section-badge">Industries</span>
            <h2>Industries We Serve</h2>
            <p>Providing manpower across diverse sectors</p>
        </div>
        <div class="row g-3 justify-content-center">
            @php
                $industries = [
                    ['icon' => 'bi-building', 'name' => 'Construction'],
                    ['icon' => 'bi-gear', 'name' => 'Manufacturing'],
                    ['icon' => 'bi-box-seam', 'name' => 'Warehousing'],
                    ['icon' => 'bi-truck', 'name' => 'Logistics'],
                    ['icon' => 'bi-hospital', 'name' => 'Healthcare'],
                    ['icon' => 'bi-shop', 'name' => 'Retail'],
                    ['icon' => 'bi-cup-hot', 'name' => 'Hospitality'],
                    ['icon' => 'bi-lightning', 'name' => 'Energy'],
                ];
            @endphp
            @foreach($industries as $industry)
            <div class="col-6 col-md-4 col-lg-3 animate-on-scroll">
                <div class="text-center p-4 rounded-4 border" style="transition: all 0.3s;" onmouseover="this.style.borderColor='#F59E0B';this.style.transform='translateY(-3px)'" onmouseout="this.style.borderColor='';this.style.transform=''">
                    <i class="bi {{ $industry['icon'] }} d-block mb-2" style="font-size: 2rem; color: #F59E0B;"></i>
                    <strong style="font-size: 0.95rem;">{{ $industry['name'] }}</strong>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Featured Clients --}}
@if($featuredClients->count())
<section class="section section-light">
    <div class="container">
        <div class="section-heading animate-on-scroll">
            <span class="section-badge">Our Clients</span>
            <h2>Trusted By Leading Companies</h2>
        </div>
        <div class="row g-4 align-items-center justify-content-center animate-on-scroll">
            @foreach($featuredClients as $client)
            <div class="col-4 col-md-3 col-lg-2 text-center">
                <div class="p-3 rounded-3 bg-white border" style="opacity: 0.7; transition: opacity 0.3s;" onmouseover="this.style.opacity='1'" onmouseout="this.style.opacity='0.7'">
                    <strong style="color: #64748B; font-size: 0.85rem;">{{ $client->name }}</strong>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- Testimonials --}}
@if($testimonials->count())
<section class="section">
    <div class="container">
        <div class="section-heading animate-on-scroll">
            <span class="section-badge">Testimonials</span>
            <h2>What Our Clients Say</h2>
            <p>Real feedback from companies we work with</p>
        </div>
        <div class="row g-4">
            @foreach($testimonials->take(3) as $testimonial)
            <div class="col-lg-4 animate-on-scroll">
                <div class="testimonial-card">
                    <div class="stars">
                        @for($i = 0; $i < $testimonial->rating; $i++)
                            <i class="bi bi-star-fill"></i>
                        @endfor
                    </div>
                    <p class="testimonial-text">"{{ $testimonial->content }}"</p>
                    <div class="testimonial-author">
                        <div class="author-avatar">{{ substr($testimonial->client_name, 0, 1) }}</div>
                        <div>
                            <p class="author-name">{{ $testimonial->client_name }}</p>
                            <span class="author-company">{{ $testimonial->company }}</span>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
@endif

{{-- FAQ --}}
@if($faqs->count())
<section class="section section-light">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-8">
                <div class="section-heading animate-on-scroll">
                    <span class="section-badge">FAQ</span>
                    <h2>Frequently Asked Questions</h2>
                </div>
                <div class="accordion faq-accordion animate-on-scroll" id="faqAccordion">
                    @foreach($faqs as $index => $faq)
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button {{ $index > 0 ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $index }}">
                                {{ $faq->question }}
                            </button>
                        </h2>
                        <div id="faq{{ $index }}" class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}" data-bs-parent="#faqAccordion">
                            <div class="accordion-body">{{ $faq->answer }}</div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
@endif

{{-- CTA Section --}}
<section class="cta-section">
    <div class="container position-relative" style="z-index: 2;">
        <h2 class="animate-on-scroll">Ready to Get Started?</h2>
        <p class="animate-on-scroll">Tell us your manpower requirements and we'll provide the right workforce within 24 hours.</p>
        <div class="animate-on-scroll">
            <a href="{{ route('contact') }}" class="btn-hero-primary me-3">
                Contact Us <i class="bi bi-arrow-right"></i>
            </a>
            <a href="tel:+919876543210" class="btn-hero-secondary">
                <i class="bi bi-telephone"></i> Call Now
            </a>
        </div>
    </div>
</section>
@endsection
