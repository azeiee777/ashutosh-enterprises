@extends('layouts.admin')
@section('title', 'Edit Payment')
@section('breadcrumb', 'Payments / Edit')

@section('content')
<div class="page-title-section"><div><h1>Edit Payment</h1></div><a href="{{ route('admin.payments.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.payments.update', $payment) }}" class="admin-form" enctype="multipart/form-data" x-data="paymentForm()">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Date *</label><input type="date" name="date" class="form-control" required value="{{ old('date', $payment->date->format('Y-m-d')) }}"></div>
            <div class="col-md-4">
                <label class="form-label">Client *</label>
                <select name="client_id" id="clientSelect" class="form-select" required x-on:change="loadSites($event.target.value)">
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $payment->client_id) == $client->id ? 'selected' : '' }}>{{ $client->company_name }}</option>
                    @endforeach
                </select>
                @error('client_id')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-4">
                <label class="form-label">Site (Optional)</label>
                <select name="site_id" id="siteSelect" class="form-select">
                    <option value="">Select Site</option>
                    <template x-for="site in sites" :key="site.id">
                        <option :value="site.id" x-text="site.site_name" :selected="site.id == '{{ old('site_id', $payment->site_id) }}'"></option>
                    </template>
                </select>
            </div>

            <div class="col-md-4">
                <label class="form-label">Payment Head *</label>
                <select name="payment_head" class="form-select" required>
                    @foreach(\App\Enums\PaymentHead::cases() as $head)
                        <option value="{{ $head->value }}" {{ old('payment_head', $payment->payment_head->value) == $head->value ? 'selected' : '' }}>{{ $head->label() }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4"><label class="form-label">Amount (₹) *</label><input type="number" step="0.01" name="amount" class="form-control" required value="{{ old('amount', $payment->amount) }}">@error('amount')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-4">
                <label class="form-label">Payment Method *</label>
                <select name="payment_method" class="form-select" required>
                    @foreach(\App\Enums\PaymentMethod::cases() as $method)
                        <option value="{{ $method->value }}" {{ old('payment_method', $payment->payment_method->value) == $method->value ? 'selected' : '' }}>{{ $method->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-md-6"><label class="form-label">Reference Number (Cheque/Txn ID)</label><input type="text" name="reference_number" class="form-control" value="{{ old('reference_number', $payment->reference_number) }}"></div>
            <div class="col-md-6"><label class="form-label">Paid To / Received By</label><input type="text" name="paid_to" class="form-control" value="{{ old('paid_to', $payment->paid_to) }}"></div>
            
            <div class="col-12"><label class="form-label">Description</label><textarea name="description" class="form-control" rows="2">{{ old('description', $payment->description) }}</textarea></div>
            
            <div class="col-12">
                <label class="form-label">Attachment (PDF/Image)</label>
                @if($payment->attachment_path)
                    <div class="mb-2"><a href="{{ asset('storage/' . $payment->attachment_path) }}" target="_blank" class="badge bg-secondary text-decoration-none"><i class="bi bi-paperclip"></i> View Current Attachment</a></div>
                @endif
                <input type="file" name="attachment" class="form-control" accept=".pdf,.jpg,.jpeg,.png">
                <small class="text-muted">Upload a new file to replace the current one.</small>
                @error('attachment')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Update Payment</button></div>
        </div>
    </form>
</div></div>

@push('scripts')
<script>
    function paymentForm() {
        return {
            sites: [],
            init() {
                let clientId = document.getElementById('clientSelect').value;
                if(clientId) this.loadSites(clientId);
            },
            async loadSites(clientId) {
                if(!clientId) { this.sites = []; return; }
                let response = await fetch(`/admin/api/sites-by-client/${clientId}`);
                this.sites = await response.json();
            }
        }
    }
</script>
@endpush
@endsection
