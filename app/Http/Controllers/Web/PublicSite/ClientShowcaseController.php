<?php

namespace App\Http\Controllers\Web\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\FeaturedClient;

class ClientShowcaseController extends Controller
{
    public function index()
    {
        $clients = FeaturedClient::active()->ordered()->get();
        return view('public.clients', compact('clients'));
    }
}
