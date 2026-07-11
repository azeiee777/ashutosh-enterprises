<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Site;
use App\Models\Client;
use App\Models\ActivityLog;
use Illuminate\Http\Request;

class SiteController extends Controller
{
    public function index()
    {
        $sites = Site::with('client')
            ->when(request('search'), fn($q, $s) => $q->search($s))
            ->when(request('client_id'), fn($q, $c) => $q->byClient($c))
            ->when(request('status'), fn($q, $s) => $q->where('status', $s))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $clients = Client::orderBy('company_name')->get();
        return view('admin.sites.index', compact('sites', 'clients'));
    }

    public function create()
    {
        $clients = Client::active()->orderBy('company_name')->get();
        return view('admin.sites.create', compact('clients'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'site_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'supervisor_name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'status' => 'nullable|string',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $site = Site::create($validated);
        ActivityLog::log('created', "Created site: {$site->site_name}", $site);

        return redirect()->route('admin.sites.index')->with('success', 'Site created successfully.');
    }

    public function show(Site $site)
    {
        $site->load(['client', 'dailyLabourSupplies' => fn($q) => $q->latest('date')->limit(10)]);
        return view('admin.sites.show', compact('site'));
    }

    public function edit(Site $site)
    {
        $clients = Client::active()->orderBy('company_name')->get();
        return view('admin.sites.edit', compact('site', 'clients'));
    }

    public function update(Request $request, Site $site)
    {
        $validated = $request->validate([
            'client_id' => 'required|exists:clients,id',
            'site_name' => 'required|string|max:255',
            'address' => 'nullable|string|max:500',
            'supervisor_name' => 'nullable|string|max:255',
            'start_date' => 'nullable|date',
            'status' => 'nullable|string',
            'remarks' => 'nullable|string|max:1000',
        ]);

        $site->update($validated);
        ActivityLog::log('updated', "Updated site: {$site->site_name}", $site);

        return redirect()->route('admin.sites.index')->with('success', 'Site updated successfully.');
    }

    public function destroy(Site $site)
    {
        ActivityLog::log('deleted', "Deleted site: {$site->site_name}", $site);
        $site->delete();
        return redirect()->route('admin.sites.index')->with('success', 'Site deleted successfully.');
    }
}
