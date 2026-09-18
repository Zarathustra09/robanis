<?php

namespace App\Http\Requests;

use App\Support\Offerings;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreLeadRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email:rfc', 'max:190'],
            'company' => ['nullable', 'string', 'max:160'],
            'tier_interest' => ['nullable', 'string', Rule::in(Offerings::tierSlugs())],
            'message' => ['required', 'string', 'max:2000'],
            'source_page' => ['nullable', 'string', 'max:255'],
            // Honeypot — left blank by real visitors, ignored by the controller either way.
            'website' => ['nullable', 'string'],
        ];
    }

    /**
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tell us your name.',
            'email.required' => 'An email address is required so we can reply.',
            'email.email' => 'That email address doesn\'t look right.',
            'message.required' => 'Let us know what you need.',
            'message.max' => 'Keep the message under 2,000 characters.',
        ];
    }

    /**
     * Send a failed submit back to the contact page, regardless of referer.
     */
    protected function getRedirectUrl(): string
    {
        return route('contact');
    }
}
