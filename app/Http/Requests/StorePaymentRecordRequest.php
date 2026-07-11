<?php

namespace App\Http\Requests;

use App\Enums\PaymentHead;
use App\Enums\PaymentMethod;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StorePaymentRecordRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'date' => 'required|date',
            'client_id' => 'required|exists:clients,id',
            'site_id' => 'nullable|exists:sites,id',
            'payment_head' => ['required', Rule::enum(PaymentHead::class)],
            'amount' => 'required|numeric|min:0.01',
            'payment_method' => ['required', Rule::enum(PaymentMethod::class)],
            'paid_to' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:1000',
            'reference_number' => 'nullable|string|max:100',
            'attachment' => 'nullable|file|mimes:pdf,jpg,jpeg,png|max:5120',
        ];
    }
}
