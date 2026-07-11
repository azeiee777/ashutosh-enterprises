<?php

namespace App\Http\Controllers\Web\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Service;

class ServiceController extends Controller
{
    public function index()
    {
        $services = Service::active()->ordered()->get();
        return view('public.services.index', compact('services'));
    }

    public function show(Service $service)
    {
        $relatedServices = Service::active()->where('id', '!=', $service->id)->ordered()->limit(3)->get();
        return view('public.services.show', compact('service', 'relatedServices'));
    }
}
