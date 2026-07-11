<?php

namespace App\Http\Controllers\Web\PublicSite;

use App\Http\Controllers\Controller;

class AboutController extends Controller
{
    public function index()
    {
        return view('public.about');
    }
}
