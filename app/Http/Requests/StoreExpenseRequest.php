<?php

namespace App\Http\Requests;

use App\Enums\ExpenseCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'category' => ['required', Rule::enum(ExpenseCategory::class)],
            'amount' => 'required|numeric|min:0.01',
            'vendor' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
