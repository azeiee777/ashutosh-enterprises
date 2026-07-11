<?php

namespace App\Http\Controllers\Web\PublicSite;

use App\Http\Controllers\Controller;
use App\Models\Career;
use App\Models\CareerApplication;
use Illuminate\Http\Request;

class CareerController extends Controller
{
    public function index()
    {
        $careers = Career::active()->latest()->get();
        return view('public.careers.index', compact('careers'));
    }

    public function apply(Request $request)
    {
        $validated = $request->validate([
            'career_id' => 'nullable|exists:careers,id',
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'required|string|max:20',
            'cover_letter' => 'nullable|string|max:2000',
            'resume' => 'required|file|mimes:pdf,doc,docx|max:5120',
        ]);

        $resumePath = $request->file('resume')->store('resumes', 'public');

        CareerApplication::create([
            ...$validated,
            'resume_path' => $resumePath,
        ]);

        return back()->with('success', 'Application submitted successfully! We will contact you soon.');
    }
}
