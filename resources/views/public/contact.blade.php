@extends('layouts.public')
@section('title', 'Contact Us')
@section('content')
<div class="page-header"><div class="container"><h1>Contact Us</h1><nav aria-label="breadcrumb"><ol class="breadcrumb"><li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li><li class="breadcrumb-item active">Contact</li></ol></nav></div></div>
<section class="section"><div class="container">
<div class="row g-4 mb-5">
    <div class="col-md-6 col-lg-3 animate-on-scroll"><div class="contact-info-card h-100"><i class="bi bi-geo-alt d-block"></i><h6>Address</h6><p>123 Business Park, Industrial Area, New Delhi - 110001</p></div></div>
    <div class="col-md-6 col-lg-3 animate-on-scroll"><div class="contact-info-card h-100"><i class="bi bi-telephone d-block"></i><h6>Phone</h6><p><a href="tel:+917618876215" style="color:inherit;">+91 76188 76215</a><br><a href="tel:+911145678900" style="color:inherit;">+91 11-4567-8900</a></p></div></div>
    <div class="col-md-6 col-lg-3 animate-on-scroll"><div class="contact-info-card h-100"><i class="bi bi-envelope d-block"></i><h6>Email</h6><p><a href="mailto:info@ashutoshenterprises.com" style="color:inherit;">info@ashutoshenterprises.com</a></p></div></div>
    <div class="col-md-6 col-lg-3 animate-on-scroll"><div class="contact-info-card h-100"><i class="bi bi-clock d-block"></i><h6>Business Hours</h6><p>Mon - Sat<br>9:00 AM - 6:00 PM</p></div></div>
</div>

<div class="row g-5">
    <div class="col-lg-7 animate-on-scroll">
        <h3 class="mb-4">Send Us a Message</h3>
        @if(session('success'))<div class="alert alert-success rounded-3">{{ session('success') }}</div>@endif
        <form method="POST" action="{{ route('contact.store') }}">@csrf
            <div class="row g-3">
                <div class="col-md-6"><label class="form-label fw-semibold">Full Name *</label><input type="text" name="name" class="form-control rounded-3 py-2" required value="{{ old('name') }}">@error('name')<small class="text-danger">{{ $message }}</small>@enderror</div>
                <div class="col-md-6"><label class="form-label fw-semibold">Email *</label><input type="email" name="email" class="form-control rounded-3 py-2" required value="{{ old('email') }}">@error('email')<small class="text-danger">{{ $message }}</small>@enderror</div>
                <div class="col-md-6"><label class="form-label fw-semibold">Phone</label><input type="tel" name="phone" class="form-control rounded-3 py-2" value="{{ old('phone') }}"></div>
                <div class="col-md-6"><label class="form-label fw-semibold">Subject</label><input type="text" name="subject" class="form-control rounded-3 py-2" value="{{ old('subject') }}"></div>
                <div class="col-12"><label class="form-label fw-semibold">Message *</label><textarea name="message" class="form-control rounded-3" rows="5" required>{{ old('message') }}</textarea>@error('message')<small class="text-danger">{{ $message }}</small>@enderror</div>
                <div class="col-12"><button type="submit" class="btn btn-admin-primary px-5 py-2">Send Message <i class="bi bi-send ms-1"></i></button></div>
            </div>
        </form>
    </div>
    <div class="col-lg-5 animate-on-scroll">
        <h3 class="mb-4">Find Us</h3>
        <div class="rounded-4 overflow-hidden border mb-4" style="height:300px;">
            <iframe src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d224346.54004697942!2d77.06889999999999!3d28.527280050000003!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x390cfd5b347eb62d%3A0x52c2b7494e204dce!2sNew%20Delhi%2C%20Delhi!5e0!3m2!1sen!2sin!4v1" width="100%" height="100%" style="border:0;" allowfullscreen loading="lazy"></iframe>
        </div>
        <div class="d-flex gap-2">
            <a href="https://wa.me/917618876215" target="_blank" class="btn btn-success rounded-pill flex-fill"><i class="bi bi-whatsapp me-1"></i> WhatsApp</a>
            <a href="tel:+917618876215" class="btn btn-dark rounded-pill flex-fill"><i class="bi bi-telephone me-1"></i> Call Now</a>
        </div>
    </div>
</div></div></section>
@endsection
