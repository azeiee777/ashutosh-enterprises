@extends('layouts.admin')
@section('title', 'Expenses')
@section('breadcrumb', 'Operations / Expenses')

@section('content')
<div class="page-title-section">
    <div><h1>Expenses</h1><p class="page-subtitle">Track office and miscellaneous expenses</p></div>
    <a href="{{ route('admin.expenses.create') }}" class="btn btn-admin-primary"><i class="bi bi-plus-lg"></i> Add Expense</a>
</div>

<div class="filter-bar">
    <form class="d-flex gap-2 flex-wrap w-100" method="GET">
        <input type="date" name="date_from" class="form-control" title="From Date" value="{{ request('date_from') }}" style="max-width:150px;">
        <input type="date" name="date_to" class="form-control" title="To Date" value="{{ request('date_to') }}" style="max-width:150px;">
        <select name="category" class="form-select" style="max-width:160px;">
            <option value="">All Categories</option>
            @foreach(\App\Enums\ExpenseCategory::cases() as $category)
                <option value="{{ $category->value }}" {{ request('category') == $category->value ? 'selected' : '' }}>{{ $category->label() }}</option>
            @endforeach
        </select>
        <button class="btn btn-admin-secondary">Filter</button>
        @if(request()->hasAny(['date_from','date_to','category']))<a href="{{ route('admin.expenses.index') }}" class="btn btn-outline-secondary">Clear</a>@endif
    </form>
</div>

<div class="admin-card">
    @if($expenses->count())
    <div class="table-responsive">
        <table class="admin-table">
            <thead>
                <tr>
                    <th>Date</th><th>Category</th><th>Amount (₹)</th><th>Vendor</th><th>Description</th><th>Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($expenses as $expense)
                <tr>
                    <td><strong>{{ $expense->date->format('d M Y') }}</strong></td>
                    <td><span class="badge bg-secondary">{{ $expense->category->label() }}</span></td>
                    <td><strong>{{ number_format($expense->amount, 2) }}</strong></td>
                    <td>{{ $expense->vendor ?? '-' }}</td>
                    <td><span title="{{ $expense->description }}">{{ Str::limit($expense->description, 40) }}</span></td>
                    <td>
                        <div class="d-flex gap-1">
                            <a href="{{ route('admin.expenses.edit', $expense) }}" class="btn btn-sm btn-outline-primary" title="Edit"><i class="bi bi-pencil"></i></a>
                            <form method="POST" action="{{ route('admin.expenses.destroy', $expense) }}" onsubmit="return confirm('Delete this expense?')">@csrf @method('DELETE')
                                <button class="btn btn-sm btn-outline-danger" title="Delete"><i class="bi bi-trash"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <div class="p-3">{{ $expenses->links() }}</div>
    @else
    <div class="empty-state"><i class="bi bi-receipt"></i><h5>No Expenses Found</h5><p>Add a new expense record.</p><a href="{{ route('admin.expenses.create') }}" class="btn btn-admin-primary mt-2"><i class="bi bi-plus-lg"></i> Add Expense</a></div>
    @endif
</div>
@endsection
