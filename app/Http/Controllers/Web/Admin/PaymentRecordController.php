<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePaymentRecordRequest;
use App\Models\PaymentRecord;
use App\Models\Client;
use App\Models\Site;
use App\Models\ActivityLog;

class PaymentRecordController extends Controller
{
    public function index()
    {
        $payments = PaymentRecord::with(['client', 'site'])
            ->when(request('date_from'), fn($q, $d) => $q->where('date', '>=', $d))
            ->when(request('date_to'), fn($q, $d) => $q->where('date', '<=', $d))
            ->when(request('client_id'), fn($q, $c) => $q->byClient($c))
            ->when(request('payment_head'), fn($q, $h) => $q->byHead($h))
            ->orderBy('date', 'desc')
            ->paginate(20)
            ->withQueryString();

        $clients = Client::orderBy('company_name')->get();
        return view('admin.payments.index', compact('payments', 'clients'));
    }

    public function create()
    {
        $clients = Client::active()->orderBy('company_name')->get();
        $sites = Site::active()->orderBy('site_name')->get();
        return view('admin.payments.create', compact('clients', 'sites'));
    }

    public function store(StorePaymentRecordRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('attachments', 'public');
        }

        $payment = PaymentRecord::create($data);
        ActivityLog::log('created', "Added payment of ₹{$payment->amount}", $payment);

        return redirect()->route('admin.payments.index')->with('success', 'Payment record added.');
    }

    public function edit(PaymentRecord $payment)
    {
        $clients = Client::active()->orderBy('company_name')->get();
        $sites = Site::active()->orderBy('site_name')->get();
        return view('admin.payments.edit', compact('payment', 'clients', 'sites'));
    }

    public function update(StorePaymentRecordRequest $request, PaymentRecord $payment)
    {
        $data = $request->validated();
        if ($request->hasFile('attachment')) {
            $data['attachment_path'] = $request->file('attachment')->store('attachments', 'public');
        }

        $payment->update($data);
        ActivityLog::log('updated', "Updated payment of ₹{$payment->amount}", $payment);

        return redirect()->route('admin.payments.index')->with('success', 'Payment record updated.');
    }

    public function destroy(PaymentRecord $payment)
    {
        ActivityLog::log('deleted', "Deleted payment of ₹{$payment->amount}", $payment);
        $payment->delete();
        return redirect()->route('admin.payments.index')->with('success', 'Payment deleted.');
    }
}
