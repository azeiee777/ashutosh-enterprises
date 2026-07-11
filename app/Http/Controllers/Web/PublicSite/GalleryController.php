<?php

namespace App\Http\Controllers\Web\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\GalleryImage;

class GalleryController extends Controller
{
    public function index()
    {
        $categories = GalleryImage::active()->distinct()->pluck('category');
        $images = GalleryImage::active()->ordered()
            ->when(request('category'), fn($q, $c) => $q->byCategory($c))
            ->get();

        return view('public.gallery', compact('images', 'categories'));
    }
}
