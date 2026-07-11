<?php

namespace App\Http\Requests;

use App\Enums\Status;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateClientRequest extends FormRequest
{
    public function authorize(): bool { return true; }

    public function rules(): array
    {
        return [
            'company_name' => 'required|string|max:255',
            'contact_person' => 'required|string|max:255',
            'mobile' => 'required|string|max:20',
            'email' => 'nullable|email|max:255',
            'gst' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'status' => ['nullable', Rule::enum(Status::class)],
            'notes' => 'nullable|string|max:1000',
        ];
    }
}
