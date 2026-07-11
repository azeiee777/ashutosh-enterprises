<?php

namespace App\Http\Controllers\Web\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\Testimonial;
use App\Models\Faq;
use App\Models\FeaturedClient;
use App\Models\CompanySetting;

class HomeController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->limit(6)->get();
        $testimonials = Testimonial::active()->ordered()->limit(5)->get();
        $faqs = Faq::active()->ordered()->limit(8)->get();
        $featuredClients = FeaturedClient::active()->ordered()->get();

        return view('public.home', compact('services', 'testimonials', 'faqs', 'featuredClients'));
    }
}
