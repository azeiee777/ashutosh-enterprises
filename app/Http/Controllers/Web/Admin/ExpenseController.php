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
        $expenses = Expense::when(request('date_from'), fn($q, $d) => $q->whereDate('date', '>=', $d))
            ->when(request('date_to'), fn($q, $d) => $q->whereDate('date', '<=', $d))
            ->when(request('category'), fn($q, $c) => $q->byCategory($c))
            ->orderBy('date', 'desc')
            ->paginate(20)
            ->withQueryString();

        return view('admin.expenses.index', compact('expenses'));
    }

    public function exportPdf()
    {
        $data = Expense::when(request('date_from'), fn($q, $d) => $q->whereDate('date', '>=', $d))
            ->when(request('date_to'), fn($q, $d) => $q->whereDate('date', '<=', $d))
            ->when(request('category'), fn($q, $c) => $q->byCategory($c))
            ->orderBy('date', 'desc')
            ->get();

        $type = 'expense';
        $filters = request()->only(['date_from', 'date_to', 'category']);

        $pdf = \Barryvdh\DomPDF\Facade\Pdf::loadView('admin.reports.pdf', compact('data', 'type', 'filters'))
            ->setPaper('a4', 'landscape');

        return $pdf->download("expenses_" . date('Ymd_His') . ".pdf");
    }

    public function export()
    {
        $data = Expense::when(request('date_from'), fn($q, $d) => $q->whereDate('date', '>=', $d))
            ->when(request('date_to'), fn($q, $d) => $q->whereDate('date', '<=', $d))
            ->when(request('category'), fn($q, $c) => $q->byCategory($c))
            ->orderBy('date', 'desc')
            ->get();

        return \Maatwebsite\Excel\Facades\Excel::download(
            new \App\Exports\ExpenseExport($data), 
            "expenses_" . date('Ymd_His') . ".xlsx"
        );
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
