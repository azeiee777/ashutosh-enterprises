<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreExpenseRequest;
use App\Models\Expense;
use App\Models\ActivityLog;

class ExpenseController extends Controller
{
    public function index()
    {
        $expenses = Expense::when(request('date_from'), fn($q, $d) => $q->where('date', '>=', $d))
            ->when(request('date_to'), fn($q, $d) => $q->where('date', '<=', $d))
            ->when(request('category'), fn($q, $c) => $q->byCategory($c))
            ->orderBy('date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.expenses.index', compact('expenses'));
    }

    public function create()
    {
        return view('admin.expenses.create');
    }

    public function store(StoreExpenseRequest $request)
    {
        $expense = Expense::create($request->validated());
        ActivityLog::log('created', "Added expense of ₹{$expense->amount}", $expense);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense added.');
    }

    public function edit(Expense $expense)
    {
        return view('admin.expenses.edit', compact('expense'));
    }

    public function update(StoreExpenseRequest $request, Expense $expense)
    {
        $expense->update($request->validated());
        ActivityLog::log('updated', "Updated expense of ₹{$expense->amount}", $expense);

        return redirect()->route('admin.expenses.index')->with('success', 'Expense updated.');
    }

    public function destroy(Expense $expense)
    {
        ActivityLog::log('deleted', "Deleted expense of ₹{$expense->amount}", $expense);
        $expense->delete();
        return redirect()->route('admin.expenses.index')->with('success', 'Expense deleted.');
    }
}
