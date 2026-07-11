<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="@yield('meta_description', 'Ashutosh Enterprises - Leading Labour Supply Contractor providing skilled, semi-skilled and unskilled manpower solutions for construction, factories, and warehouses across India.')">
    <meta name="keywords" content="labour supply, manpower contractor, construction labour, skilled workers, factory workers, warehouse staff">
    <meta name="author" content="Ashutosh Enterprises">
    <title>@yield('title', 'Ashutosh Enterprises') | Labour Supply Contractor</title>

    <!-- Favicon -->
    <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 32 32'%3E%3Crect width='32' height='32' rx='8' fill='%23F59E0B'/%3E%3Ctext x='50%25' y='55%25' dominant-baseline='middle' text-anchor='middle' fill='%230F172A' font-family='Arial' font-weight='bold' font-size='18'%3EA%3C/text%3E%3C/svg%3E">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">

    @vite(['resources/scss/public.scss', 'resources/js/app.js'])

    @stack('styles')
</head>
<body>
    {{-- Navbar --}}
    <nav class="navbar navbar-expand-lg navbar-public" id="mainNavbar">
        <div class="container">
            <a class="navbar-brand" href="{{ route('home') }}">
                Ashutosh<span>.</span>
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('home') ? 'active' : '' }}" href="{{ route('home') }}">Home</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('about') ? 'active' : '' }}" href="{{ route('about') }}">About</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('services.*') ? 'active' : '' }}" href="{{ route('services.index') }}">Services</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('clients.showcase') ? 'active' : '' }}" href="{{ route('clients.showcase') }}">Clients</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" href="{{ route('gallery') }}">Gallery</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('careers.*') ? 'active' : '' }}" href="{{ route('careers.index') }}">Careers</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" href="{{ route('contact') }}">Contact</a>
                    </li>
                </ul>
                <a href="{{ route('login') }}" class="btn btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </a>
            </div>
        </div>
    </nav>

    {{-- Main Content --}}
    <main>
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="footer">
        <div class="container">
            <div class="row g-4">
                <div class="col-lg-4">
                    <h5>Ashutosh Enterprises</h5>
                    <p style="font-size: 0.95rem; line-height: 1.7; margin-bottom: 1.5rem;">
                        Leading labour supply contractor providing reliable manpower solutions for construction,
                        manufacturing, and warehousing industries across India.
                    </p>
                    <div class="social-links">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-linkedin"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter-x"></i></a>
                    </div>
                </div>
                <div class="col-lg-2 col-md-6">
                    <h5>Quick Links</h5>
                    <ul class="footer-links">
                        <li><a href="{{ route('home') }}">Home</a></li>
                        <li><a href="{{ route('about') }}">About Us</a></li>
                        <li><a href="{{ route('services.index') }}">Services</a></li>
                        <li><a href="{{ route('gallery') }}">Gallery</a></li>
                        <li><a href="{{ route('careers.index') }}">Careers</a></li>
                        <li><a href="{{ route('contact') }}">Contact</a></li>
                    </ul>
                </div>
                <div class="col-lg-3 col-md-6">
                    <h5>Our Services</h5>
                    <ul class="footer-links">
                        <li><a href="#">Skilled Labour</a></li>
                        <li><a href="#">Construction Labour</a></li>
                        <li><a href="#">Factory Workers</a></li>
                        <li><a href="#">Warehouse Staff</a></li>
                        <li><a href="#">Housekeeping</a></li>
                        <li><a href="#">Packaging Labour</a></li>
                    </ul>
                </div>
                <div class="col-lg-3">
                    <h5>Contact Us</h5>
                    <div class="footer-contact-item">
                        <i class="bi bi-geo-alt"></i>
                        <span>123 Business Park, Industrial Area,<br>New Delhi, India - 110001</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-telephone"></i>
                        <span>+91 76188 76215<br>+91 11-4567-8900</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-envelope"></i>
                        <span>info@ashutoshenterprises.com</span>
                    </div>
                    <div class="footer-contact-item">
                        <i class="bi bi-clock"></i>
                        <span>Mon - Sat: 9:00 AM - 6:00 PM</span>
                    </div>
                </div>
            </div>
            <div class="footer-bottom">
                <p class="mb-0">&copy; {{ date('Y') }} Ashutosh Enterprises. All Rights Reserved.</p>
            </div>
        </div>
    </footer>

    {{-- WhatsApp Button --}}
    <a href="https://wa.me/917618876215" target="_blank" class="whatsapp-btn" title="Chat on WhatsApp">
        <i class="bi bi-whatsapp"></i>
    </a>

    @stack('scripts')
</body>
</html>
