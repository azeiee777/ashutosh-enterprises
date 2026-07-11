<?php

namespace App\Http\Requests;

use App\Enums\Shift;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDailyLabourSupplyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'site_id' => 'required|exists:sites,id',
            'skilled_count' => 'required|integer|min:0',
            'semi_skilled_count' => 'required|integer|min:0',
            'unskilled_count' => 'required|integer|min:0',
            'other_count' => 'nullable|integer|min:0',
            'shift' => ['required', Rule::enum(Shift::class)],
            'remarks' => 'nullable|string|max:500',
        ];
    }
}
