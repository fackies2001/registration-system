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
            'salutation' => ['required', 'string', 'max:50'],
            'first_name' => ['required', 'string', 'max:255'],
            'middle_name' => ['nullable', 'string', 'max:255'],
            'last_name' => ['required', 'string', 'max:255'],
            'suffix' => ['nullable', 'string', 'max:50'],
            'sex' => ['required', 'string', 'in:Male,Female,Other'],
            'nationality' => ['required', 'string', 'max:255'],
            'place_of_birth' => ['required', 'string', 'max:255'],
            'date_of_birth' => ['required', 'date', 'before:today'],
            'participant_type' => ['required', 'string', 'max:255'],
            'ministry_agency' => ['required', 'string', 'max:255'],
            'office_subunit' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'unique:users,email', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'designation' => ['required', 'string', 'max:255'],
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
            'salutation.required' => 'Please select your salutation.',
            'first_name.required' => 'Please enter your first name.',
            'last_name.required' => 'Please enter your last name.',
            'sex.required' => 'Please select your sex.',
            'nationality.required' => 'Please enter your nationality.',
            'place_of_birth.required' => 'Please enter your place of birth.',
            'date_of_birth.required' => 'Please enter your date of birth.',
            'participant_type.required' => 'Please select your participant type.',
            'ministry_agency.required' => 'Please select your ministry or agency.',
            'office_subunit.required' => 'Please enter your office or sub-unit.',
            'email.required' => 'Please enter your email address.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email address is already registered.',
            'organization.required' => 'Please enter your organization.',
            'designation.required' => 'Please enter your designation or position.',
            'address.required' => 'Please enter your address.',
            'contact_number.required' => 'Please enter your contact number.',
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

            $httpRequest = Http::asForm();
            
            // Disable SSL verification on local environment to prevent cURL 60 errors
            if (app()->environment('local')) {
                $httpRequest->withoutVerifying();
            }

            $response = $httpRequest->post('https://challenges.cloudflare.com/turnstile/v0/siteverify', [
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
