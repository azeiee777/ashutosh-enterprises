@extends('layouts.admin')
@section('title', 'Edit Labour Supply')
@section('breadcrumb', 'Labour Supply / Edit')

@section('content')
<div class="page-title-section"><div><h1>Edit Labour Record</h1></div><a href="{{ route('admin.labour-supply.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.labour-supply.update', $labourSupply) }}" class="admin-form" x-data="labourForm()">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Date *</label><input type="date" name="date" class="form-control" required value="{{ old('date', $labourSupply->date->format('Y-m-d')) }}"></div>
            <div class="col-md-4">
                <label class="form-label">Client *</label>
                <select name="client_id" id="clientSelect" class="form-select" required x-on:change="loadSites($event.target.value)">
                    <option value="">Select Client</option>
                    @foreach($clients as $client)
                        <option value="{{ $client->id }}" {{ old('client_id', $labourSupply->client_id) == $client->id ? 'selected' : '' }}>{{ $client->company_name }}</option>
                    @endforeach
                </select>
            </div>
            <div class="col-md-4">
                <label class="form-label">Site *</label>
                <select name="site_id" id="siteSelect" class="form-select" required>
                    <option value="">Select Site</option>
                    <template x-for="site in sites" :key="site.id">
                        <option :value="site.id" x-text="site.site_name" :selected="site.id == '{{ old('site_id', $labourSupply->site_id) }}'"></option>
                    </template>
                </select>
            </div>

            <div class="col-12 mt-4"><h6 class="border-bottom pb-2">Manpower Details</h6></div>
            <div class="col-md-3"><label class="form-label">Skilled Count *</label><input type="number" name="skilled_count" class="form-control" min="0" required value="{{ old('skilled_count', $labourSupply->skilled_count) }}" x-model.number="skilled" @input="calculateTotal"></div>
            <div class="col-md-3"><label class="form-label">Semi-Skilled Count *</label><input type="number" name="semi_skilled_count" class="form-control" min="0" required value="{{ old('semi_skilled_count', $labourSupply->semi_skilled_count) }}" x-model.number="semi" @input="calculateTotal"></div>
            <div class="col-md-3"><label class="form-label">Unskilled Count *</label><input type="number" name="unskilled_count" class="form-control" min="0" required value="{{ old('unskilled_count', $labourSupply->unskilled_count) }}" x-model.number="unskilled" @input="calculateTotal"></div>
            <div class="col-md-3"><label class="form-label">Other Count</label><input type="number" name="other_count" class="form-control" min="0" value="{{ old('other_count', $labourSupply->other_count) }}" x-model.number="other" @input="calculateTotal"></div>
            
            <div class="col-md-6 mt-3">
                <div class="p-3 rounded bg-light border text-center">
                    <span class="text-muted d-block mb-1">Total Workers</span>
                    <strong class="fs-4 text-primary" x-text="total">0</strong>
                </div>
            </div>
            <div class="col-md-6 mt-3">
                <label class="form-label">Shift *</label>
                <select name="shift" class="form-select" required>
                    @foreach(\App\Enums\Shift::cases() as $shift)
                        <option value="{{ $shift->value }}" {{ old('shift', $labourSupply->shift->value) == $shift->value ? 'selected' : '' }}>{{ $shift->label() }}</option>
                    @endforeach
                </select>
            </div>

            <div class="col-12"><label class="form-label">Remarks</label><textarea name="remarks" class="form-control" rows="2">{{ old('remarks', $labourSupply->remarks) }}</textarea></div>
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Update Record</button></div>
        </div>
    </form>
</div></div>

@push('scripts')
<script>
    function labourForm() {
        return {
            sites: [],
            skilled: {{ old('skilled_count', $labourSupply->skilled_count) }},
            semi: {{ old('semi_skilled_count', $labourSupply->semi_skilled_count) }},
            unskilled: {{ old('unskilled_count', $labourSupply->unskilled_count) }},
            other: {{ old('other_count', $labourSupply->other_count) }},
            total: 0,
            
            init() {
                this.calculateTotal();
                let clientId = document.getElementById('clientSelect').value;
                if(clientId) this.loadSites(clientId);
            },
            
            calculateTotal() {
                this.total = (parseInt(this.skilled)||0) + (parseInt(this.semi)||0) + (parseInt(this.unskilled)||0) + (parseInt(this.other)||0);
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
