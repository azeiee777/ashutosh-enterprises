<?php

namespace App\Http\Requests;

use App\Enums\Shift;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreDailyLabourSupplyRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    protected function prepareForValidation()
    {
        $this->merge([
            'skilled_count' => $this->input('skilled_count', 0),
            'semi_skilled_count' => $this->input('semi_skilled_count', 0),
            'unskilled_count' => $this->input('unskilled_count', 0),
            'other_count' => $this->input('other_count', 0),
            'shift' => $this->input('shift', Shift::DAY->value),
        ]);
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'client_id' => 'nullable|exists:clients,id',
            'site_id' => 'nullable|exists:sites,id',
            'skilled_count' => 'nullable|integer|min:0',
            'semi_skilled_count' => 'nullable|integer|min:0',
            'unskilled_count' => 'nullable|integer|min:0',
            'other_count' => 'nullable|integer|min:0',
            'shift' => ['nullable', Rule::enum(Shift::class)],
            'remarks' => 'nullable|string|max:500',
        ];
    }
}
