@extends('layouts.guest')

@section('title', 'Participant Registration')

@section('content')
<div class="auth-header" style="display: flex; align-items: center; justify-content: space-between; gap: 1rem; margin-bottom: 2rem;">
    <img src="{{ asset('storage/Office_of_Civil_Defense_OCD_Philippines.svg-1.png') }}" alt="OCD Logo" style="width: 70px; height: auto;">
    <div style="flex-grow: 1; text-align: center;">
        <h1 style="font-size: 1.5rem; margin-bottom: 0.25rem; color: var(--primary);">Participant Registration</h1>
        <p style="color: var(--text-muted); margin: 0;">Register for access to the system</p>
    </div>
    <img src="{{ asset('storage/bagong-pilipinas-dark.png') }}" alt="Bagong Pilipinas Logo" style="width: 100px; height: auto; padding: 5px; border-radius: 6px;">
</div>

<form method="POST" action="{{ route('register') }}">
    @csrf

    <!-- Section 1: Personal -->
    <div class="form-section-title">
        <span></span> Personal Information
    </div>
    
    <div class="form-group">
        <label class="form-label" for="full_name">Full Name <span style="color: var(--danger);">*</span></label>
        <input type="text" name="full_name" id="full_name" class="form-input @error('full_name') input-error @enderror" value="{{ old('full_name') }}" placeholder="e.g. Juan Dela Cruz" required autofocus>
        @error('full_name')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="email">Email Address <span style="color: var(--danger);">*</span></label>
        <input type="email" name="email" id="email" class="form-input @error('email') input-error @enderror" value="{{ old('email') }}" placeholder="e.g. juan.delacruz@example.com" required>
        @error('email')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

     <div class="form-group">
        <label class="form-label" for="contact_number">Contact Number <span style="color: var(--danger);">*</span></label>
        <input type="tel" name="contact_number" id="contact_number" class="form-input @error('contact_number') input-error @enderror" value="{{ old('contact_number') }}" required>
        @error('contact_number')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>



    <!-- Section:2 Location & Contact Section-->
     <div class="form-section-title">
        <span></span> Location & Contact Information
    </div>
    <div class="form-group">
        <label class="form-label" for="country">Country of Origin <span style="color: var(--danger);">*</span></label>
        <select name="country" id="country" class="form-select @error('country') input-error @enderror" required>
            <option value="">Select country...</option>
            <optgroup label="ASEAN Countries">
                <option value="Brunei" data-iso="bn">Brunei</option>
                <option value="Cambodia" data-iso="kh">Cambodia</option>
                <option value="Indonesia" data-iso="id">Indonesia</option>
                <option value="Laos" data-iso="la">Laos</option>
                <option value="Malaysia" data-iso="my">Malaysia</option>
                <option value="Myanmar" data-iso="mm">Myanmar</option>
                <option value="Philippines" data-iso="ph" {{ old('country', 'Philippines') == 'Philippines' ? 'selected' : '' }}>Philippines</option>
                <option value="Singapore" data-iso="sg">Singapore</option>
                <option value="Thailand" data-iso="th">Thailand</option>
                <option value="Timor-Leste" data-iso="tl">Timor-Leste</option>
            </optgroup>
            <optgroup label="Other Countries">
                <option value="United States" data-iso="us" {{ old('country') == 'United States' ? 'selected' : '' }}>United States</option>
                <option value="United Kingdom" data-iso="gb" {{ old('country') == 'United Kingdom' ? 'selected' : '' }}>United Kingdom</option>
                <option value="Australia" data-iso="au" {{ old('country') == 'Australia' ? 'selected' : '' }}>Australia</option>
                <option value="Canada" data-iso="ca" {{ old('country') == 'Canada' ? 'selected' : '' }}>Canada</option>
                <option value="Japan" data-iso="jp" {{ old('country') == 'Japan' ? 'selected' : '' }}>Japan</option>
                <option value="Other">Other</option>
            </optgroup>
        </select>
        @error('country')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="address">Address <span style="color: var(--danger);">*</span></label>
        <input type="text" name="address" id="address" class="form-input @error('address') input-error @enderror" value="{{ old('address') }}" placeholder="e.g. 123 Main St., Brgy. San Jose, Manila" required>
        @error('address')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>


    <!-- Section 3: Professional -->
    <div class="form-section-title">
        <span></span> Professional Information
    </div>

    <div class="form-group">
        <label class="form-label" for="organization">Organization <span style="color: var(--danger);">*</span></label>
        <input type="text" name="organization" id="organization" class="form-input @error('organization') input-error @enderror" value="{{ old('organization') }}" placeholder="e.g. Office of Civil Defense" required>
        @error('organization')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>

    <div class="form-group">
        <label class="form-label" for="designation">Designation / Position <span style="color: var(--danger);">*</span></label>
        <input type="text" name="designation" id="designation" class="form-input @error('designation') input-error @enderror" value="{{ old('designation') }}" placeholder="e.g. IT Officer / Director" required>
        @error('designation')
            <div class="form-error">{{ $message }}</div>
        @enderror
    </div>



    <!-- Cloudflare Turnstile -->
    <div class="turnstile-container" id="captcha-container" style="display: none;">
        <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
    </div>
    @error('cf-turnstile-response')
        <div class="form-error" style="text-align: center; margin-bottom: 1rem;">{{ $message }}</div>
    @enderror

    <div class="form-group" style="margin-top: 2rem;">
        <button type="submit" class="btn btn-primary btn-block"> Create Registration</button>
    </div>
</form>

<div class="auth-footer">
    Already registered? <a href="{{ route('login') }}">Request Login Link</a>
</div>

@endsection

@section('head')
<script src="https://challenges.cloudflare.com/turnstile/v0/api.js" async defer></script>
<!-- Tom Select CSS & JS -->
<link href="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/css/tom-select.css" rel="stylesheet">
<script src="https://cdn.jsdelivr.net/npm/tom-select@2.2.2/dist/js/tom-select.complete.min.js"></script>
<!-- Flag Icons -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/lipis/flag-icons@7.0.0/css/flag-icons.min.css" />
<!-- IntlTelInput -->
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/css/intlTelInput.css">
<script src="https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/intlTelInput.min.js"></script>

<style>
    /* Custom Tom Select Styling to match our UI */
    .ts-control {
        padding: 0.75rem 1rem;
        font-size: 1rem;
        line-height: 1.5;
        color: var(--text);
        background-color: var(--surface);
        border: 1px solid var(--border);
        border-radius: var(--radius-md);
        box-shadow: none;
    }
    .ts-control.focus {
        border-color: var(--accent);
        box-shadow: 0 0 0 3px rgba(59, 130, 246, 0.2);
    }
    .ts-dropdown {
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
    }
    .country-option {
        display: flex;
        align-items: center;
        gap: 10px;
    }
    .fi {
        border-radius: 2px;
    }
    /* Hide the original select error since TomSelect handles UI */
    .input-error + .ts-control {
        border-color: var(--danger);
    }
    
    /* IntlTelInput Custom Styles */
    .iti {
        width: 100%;
        display: block;
    }
    .iti__country-list {
        color: var(--text);
        border-radius: var(--radius-md);
        box-shadow: var(--shadow-md);
        border: 1px solid var(--border);
    }
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    new TomSelect('#country', {
        searchField: ['text'],
        render: {
            option: function(data, escape) {
                var iso = data.$option ? data.$option.getAttribute('data-iso') : null;
                var flagHTML = iso ? `<span class="fi fi-${iso}"></span> ` : '';
                return `<div class="country-option">${flagHTML} <span>${escape(data.text)}</span></div>`;
            },
            item: function(data, escape) {
                var iso = data.$option ? data.$option.getAttribute('data-iso') : null;
                var flagHTML = iso ? `<span class="fi fi-${iso}"></span> ` : '';
                return `<div class="country-option">${flagHTML} <span>${escape(data.text)}</span></div>`;
            }
        }
    });

    // Contact Number IntlTelInput
    var phoneInput = document.querySelector("#contact_number");
    var iti = window.intlTelInput(phoneInput, {
        utilsScript: "https://cdn.jsdelivr.net/npm/intl-tel-input@18.2.1/build/js/utils.js",
        initialCountry: "ph",
        separateDialCode: true,
        autoInsertDialCode: true,
    });

    // Prevent letters in contact number
    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // On form submit, get the full number with country code
    document.querySelector('form').addEventListener('submit', function(e) {
        if (phoneInput.value.trim() !== '') {
            phoneInput.value = iti.getNumber();
        }
    });

    // CAPTCHA Reveal Logic
    var formInputs = document.querySelectorAll('input[required], select[required]');
    var captchaContainer = document.getElementById('captcha-container');
    var submitBtn = document.querySelector('button[type="submit"]');
    
    // Initially disable submit button
    submitBtn.disabled = true;
    submitBtn.style.opacity = '0.5';

    function checkFormFilled() {
        var allFilled = true;
        formInputs.forEach(function(input) {
            if (input.type !== 'hidden' && input.value.trim() === '') {
                allFilled = false;
            }
        });
        
        if (allFilled) {
            captchaContainer.style.display = 'block';
            submitBtn.disabled = false;
            submitBtn.style.opacity = '1';
        } else {
            captchaContainer.style.display = 'none';
            submitBtn.disabled = true;
            submitBtn.style.opacity = '0.5';
        }
    }

    formInputs.forEach(function(input) {
        input.addEventListener('input', checkFormFilled);
        input.addEventListener('change', checkFormFilled);
    });
    
    // Check on initial load
    checkFormFilled();
});
</script>
@endsection
