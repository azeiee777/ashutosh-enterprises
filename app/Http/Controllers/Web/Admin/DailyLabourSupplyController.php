<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreDailyLabourSupplyRequest;
use App\Models\DailyLabourSupply;
use App\Models\Client;
use App\Models\Site;
use App\Models\ActivityLog;

class DailyLabourSupplyController extends Controller
{
    public function index()
    {
        $supplies = DailyLabourSupply::with(['client', 'site'])
            ->when(request('date_from'), fn($q, $d) => $q->whereDate('date', '>=', $d))
            ->when(request('date_to'), fn($q, $d) => $q->whereDate('date', '<=', $d))
            ->when(request('client_id'), fn($q, $c) => $q->byClient($c))
            ->when(request('site_id'), fn($q, $s) => $q->bySite($s))
            ->orderBy('date', 'desc')
            ->paginate(20)
            ->withQueryString();

        $clients = Client::orderBy('company_name')->get();
        return view('admin.labour-supply.index', compact('supplies', 'clients'));
    }

    public function exportPdf()
    {
        $data = DailyLabourSupply::with(['client', 'site'])
            ->when(request('date_from'), fn($q, $d) => $q->whereDate('date', '>=', $d))
            ->when(request('date_to'), fn($q, $d) => $q->whereDate('date', '<=', $d))
            ->when(request('client_id'), fn($q, $c) => $q->byClient($c))
            ->when(request('site_id'), fn($q, $s) => $q->bySite($s))
            ->orderBy('date', 'desc')
            ->get();

        $type = 'daily_labour';
        $filters = request()->only(['date_from', 'date_to', 'client_id', 'site_id']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf', compact('data', 'type', 'filters'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("labour_supply_" . date('Ymd_His') . ".pdf");
    }

    public function export()
    {
        $data = DailyLabourSupply::with(['client', 'site'])
            ->when(request('date_from'), fn($q, $d) => $q->whereDate('date', '>=', $d))
            ->when(request('date_to'), fn($q, $d) => $q->whereDate('date', '<=', $d))
            ->when(request('client_id'), fn($q, $c) => $q->byClient($c))
            ->when(request('site_id'), fn($q, $s) => $q->bySite($s))
            ->orderBy('date', 'desc')
            ->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\LabourSupplyExport($data), 
            "labour_supply_" . date('Ymd_His') . ".xlsx"
        );
    }

    public function create()
    {
        $clients = Client::active()->orderBy('company_name')->get();
        $sites = Site::active()->orderBy('site_name')->get();
        return view('admin.labour-supply.create', compact('clients', 'sites'));
    }

    public function store(StoreDailyLabourSupplyRequest $request)
    {
        $supply = DailyLabourSupply::create($request->validated());
        ActivityLog::log('created', "Added labour supply record for " . $supply->date->format('d M Y'), $supply);

        return redirect()->route('admin.labour-supply.index')->with('success', 'Labour supply record added.');
    }

    public function edit(DailyLabourSupply $labourSupply)
    {
        $clients = Client::active()->orderBy('company_name')->get();
        $sites = Site::active()->orderBy('site_name')->get();
        return view('admin.labour-supply.edit', compact('labourSupply', 'clients', 'sites'));
    }

    public function update(StoreDailyLabourSupplyRequest $request, DailyLabourSupply $labourSupply)
    {
        $labourSupply->update($request->validated());
        ActivityLog::log('updated', "Updated labour supply for " . $labourSupply->date->format('d M Y'), $labourSupply);

        return redirect()->route('admin.labour-supply.index')->with('success', 'Labour supply record updated.');
    }

    public function destroy(DailyLabourSupply $labourSupply)
    {
        ActivityLog::log('deleted', "Deleted labour supply for " . $labourSupply->date->format('d M Y'), $labourSupply);
        $labourSupply->delete();
        return redirect()->route('admin.labour-supply.index')->with('success', 'Record deleted.');
    }
}
