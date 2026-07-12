<?php

namespace App\Http\Requests;

use App\Enums\ExpenseCategory;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreExpenseRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    protected function prepareForValidation()
    {
        $this->merge([
            'amount' => $this->input('amount', 0),
            'category' => $this->input('category', ExpenseCategory::MISCELLANEOUS->value),
        ]);
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'category' => ['nullable', Rule::enum(ExpenseCategory::class)],
            'amount' => 'nullable|numeric|min:0',
            'vendor' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
        ];
    }
}
