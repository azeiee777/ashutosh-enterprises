<?php

namespace App\Http\Controllers\Web\PublicSite;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreContactMessageRequest;
use App\Models\ContactMessage;

class ContactController extends Controller
{
    public function index()
    {
        return view('public.contact');
    }

    public function store(StoreContactMessageRequest $request)
    {
        ContactMessage::create($request->validated());
        return back()->with('success', 'Thank you for your message! We will get back to you shortly.');
    }
}
