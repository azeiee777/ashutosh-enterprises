@extends('layouts.admin')
@section('title', 'Edit Expense')
@section('breadcrumb', 'Expenses / Edit')

@section('content')
<div class="page-title-section"><div><h1>Edit Expense</h1></div><a href="{{ route('admin.expenses.index') }}" class="btn btn-admin-secondary"><i class="bi bi-arrow-left"></i> Back</a></div>

<div class="admin-card"><div class="card-body">
    <form method="POST" action="{{ route('admin.expenses.update', $expense) }}" class="admin-form">@csrf @method('PUT')
        <div class="row g-3">
            <div class="col-md-4"><label class="form-label">Date *</label><input type="date" name="date" class="form-control" required value="{{ old('date', $expense->date->format('Y-m-d')) }}"></div>
            <div class="col-md-4">
                <label class="form-label">Category *</label>
                <select name="category" class="form-select" required>
                    @foreach(\App\Enums\ExpenseCategory::cases() as $category)
                        <option value="{{ $category->value }}" {{ old('category', $expense->category->value) == $category->value ? 'selected' : '' }}>{{ $category->label() }}</option>
                    @endforeach
                </select>
                @error('category')<small class="text-danger">{{ $message }}</small>@enderror
            </div>
            <div class="col-md-4"><label class="form-label">Amount (₹) *</label><input type="number" step="0.01" name="amount" class="form-control" required value="{{ old('amount', $expense->amount) }}">@error('amount')<small class="text-danger">{{ $message }}</small>@enderror</div>
            <div class="col-md-6"><label class="form-label">Vendor</label><input type="text" name="vendor" class="form-control" value="{{ old('vendor', $expense->vendor) }}"></div>
            <div class="col-md-6"><label class="form-label">Description</label><input type="text" name="description" class="form-control" value="{{ old('description', $expense->description) }}"></div>
            <div class="col-12"><button type="submit" class="btn btn-admin-primary"><i class="bi bi-check-lg"></i> Update Expense</button></div>
        </div>
    </form>
</div></div>
@endsection
