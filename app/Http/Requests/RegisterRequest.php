<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\Validator;

class RegisterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, array<int, string>>
     */
    public function rules(): array
    {
        return [
            'full_name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
            'country' => ['required', 'string', 'max:255'],
            'address' => ['required', 'string', 'max:1000'],
            'contact_number' => ['required', 'string', 'max:20'],
            'cf-turnstile-response' => ['required', 'string'],
        ];
    }

    /**
     * Custom error messages.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'full_name.required' => 'Please enter your full name.',
            'full_name.max' => 'Full name must not exceed 255 characters.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'email.max' => 'Email must not exceed 255 characters.',
            'organization.required' => 'Please enter your organization.',
            'organization.max' => 'Organization must not exceed 255 characters.',
            'designation.required' => 'Please enter your designation or position.',
            'designation.max' => 'Designation must not exceed 255 characters.',
            'country.required' => 'Please select your country.',
            'country.max' => 'Country must not exceed 255 characters.',
            'address.required' => 'Please enter your address.',
            'address.max' => 'Address must not exceed 1000 characters.',
            'contact_number.required' => 'Please enter your contact number.',
            'contact_number.max' => 'Contact number must not exceed 20 characters.',
            'cf-turnstile-response.required' => 'Please complete the CAPTCHA verification.',
        ];
    }

    /**
     * Configure the validator instance — adds Cloudflare Turnstile verification.
     */
    public function withValidator(Validator $validator): void
    {
        $validator->after(function (Validator $validator): void {
            if ($validator->errors()->isNotEmpty()) {
                return;
            }

            $response = Http::asForm()->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
                'secret' => config('services.turnstile.secret_key'),
                'response' => $this->input('cf-turnstile-response'),
                'remoteip' => $this->ip(),
            ]);

            if (! $response->successful() || ! $response->json('success')) {
                $validator->errors()->add(
                    'cf-turnstile-response',
                    'CAPTCHA verification failed. Please try again.',
                );
            }
        });
    }
}
