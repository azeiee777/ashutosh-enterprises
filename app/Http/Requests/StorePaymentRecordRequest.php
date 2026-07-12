<?php

namespace App\Http\Requests;

use App\Enums\PaymentHead;
use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRecordRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    protected function prepareForValidation()
    {
        $this->merge([
            'amount' => $this->input('amount', 0),
            'payment_head' => $this->input('payment_head', PaymentHead::ADVANCE_FROM_CLIENT->value),
            'payment_method' => $this->input('payment_method', PaymentMethod::CASH->value),
        ]);
    }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'client_id' => 'nullable|exists:clients,id',
            'site_id' => 'nullable|exists:sites,id',
            'payment_head' => ['nullable', Rule::enum(PaymentHead::class)],
            'amount' => 'nullable|numeric|min:0',
            'payment_method' => ['nullable', Rule::enum(PaymentMethod::class)],
            'paid_to' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'reference_number' => 'nullable|string|max:100',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }
}
