@extends('layouts.admin')
@section('title', 'Add Expense')
@section('breadcrumb', 'Expenses / Add New')

@section('content')
<div class="page-title-section"><div><h1>Add Expense</h1></div><a href="{{ route('admin.expenses.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.expenses.store') }}" class="admin-form">@csrf
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Date *</label><input type="date" name="date" class="form-control" required value="{{ old('date', date('Y-m-d')) }}"></div>
            <div class="col-md-4">
                <label class="form-label">Category (Optional)</label>
                <select name="category" class="form-select">
                    <option value="">Select Category</option>
                    @foreach(\App\Enums\ExpenseCategory::cases() as $category)
                        <option value="{{ $category->value }}" {{ old('category') == $category->value ? 'selected' : '' }}>{{ $category->label() }}</option>
                    @endforeach
                </select>
                @error('category')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-4"><label class="form-label">Amount (₹) (Optional)</label><input type="number" step="0.01" name="amount" class="form-control" value="{{ old('amount', 0) }}">@error('amount')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Vendor</label><input type="text" name="vendor" class="form-control" value="{{ old('vendor') }}"></div>
            <div class="col-md-6"><label class="form-label">Description</label><input type="text" name="description" class="form-control" value="{{ old('description') }}"></div>
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Save Expense</button></div>
        </div>
    </form>
</div></div>
@endsection
