<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\Client;
use App\Models\Site;
use App\Models\PaymentRecord;
use App\Models\Expense;

class SearchController extends Controller
{
    public function index()
    {
        $query = request('q', '');
        if (strlen($query) < 2) {
            return response()->json([]);
        }

        $results = collect();

        $results = $results->merge(
            Client::where('company_name', 'like', "%{$query}%")
                ->orWhere('contact_person', 'like', "%{$query}%")
                ->limit(5)->get()
                ->map(fn($c) => ['type' => 'Client', 'title' => $c->company_name, 'url' => route('admin.clients.show', $c)])
        );

        $results = $results->merge(
            Site::where('site_name', 'like', "%{$query}%")
                ->limit(5)->get()
                ->map(fn($s) => ['type' => 'Site', 'title' => $s->site_name, 'url' => route('admin.sites.show', $s)])
        );

        return response()->json($results->values());
    }
}
