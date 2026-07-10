@extends('layouts.guest')

@section('title', 'Participant Registration')

@section('content')
<div class="auth-header" style="display: flex; align-items: center; justify-content: space-between; gap: 1.5rem; margin-bottom: 2rem;">
    <img src="{{ asset('storage/Office_of_Civil_Defense_OCD_Philippines.svg-1.png') }}" alt="OCD Logo" style="width: 90px; height: auto;">
    <div style="flex-grow: 1; text-align: center;">
        <h1 style="font-size: 1.4rem; margin-bottom: 0.5rem; color: var(--primary); line-height: 1.3;">Registration for ASEAN Ministerial Conference on Disaster Resilience (AMCDR)</h1>
        <p style="color: var(--text-muted); margin: 0; font-size: 0.95rem; text-align: justify; line-height: 1.5;"></p>
    </div>
    <img src="{{ asset('storage/asean-logo.png') }}" alt="ASEAN Logo" style="width: 140px; height: auto;">
</div>

<div class="step-indicator">
    <div class="step-item active" id="step-marker-1">1</div>
    <div class="step-item" id="step-marker-2">2</div>
    <div class="step-item" id="step-marker-3">3</div>
</div>

<form method="POST" action="{{ route('register') }}" id="registrationForm">
    @csrf

    <!-- STEP 1: Personal Information -->
    <div class="step-content active" id="step1">
        <div class="form-section-title">
            <span></span> Personal Information
        </div>

        <div class="form-group">
            <label class="form-label" style="margin-bottom: 0.5rem; display:block;">Salutation: <span style="color: var(--danger);">*</span></label>
            <div style="display: flex; gap: 1.5rem; flex-wrap: wrap;">
                @foreach(['Mr.', 'Ms.', 'Mrs.', 'Dr.', 'Prof.'] as $salutation)
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="radio" name="salutation" value="{{ $salutation }}" required {{ old('salutation') == $salutation ? 'checked' : '' }}>
                    {{ $salutation }}
                </label>
                @endforeach
                <label style="display: flex; align-items: center; gap: 0.5rem; cursor: pointer;">
                    <input type="radio" name="salutation" value="Other" id="salutationOtherRadio" required {{ old('salutation') == 'Other' ? 'checked' : '' }}>
                    Other
                </label>
            </div>
            <input type="text" id="salutationOtherInput" class="form-input" placeholder="Please specify..." style="display:none; margin-top: 0.5rem;">
            @error('salutation') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="detail-grid">
            <div class="form-group">
                <label class="form-label" for="first_name">First Name (as on Passport) <span style="color: var(--danger);">*</span></label>
                <input type="text" name="first_name" id="first_name" class="form-input @error('first_name') input-error @enderror" value="{{ old('first_name') }}" required>
                @error('first_name') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="middle_name">Middle Name (as on Passport)</label>
                <input type="text" name="middle_name" id="middle_name" class="form-input @error('middle_name') input-error @enderror" value="{{ old('middle_name') }}">
                @error('middle_name') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="detail-grid">
            <div class="form-group">
                <label class="form-label" for="last_name">Last Name (as on Passport) <span style="color: var(--danger);">*</span></label>
                <input type="text" name="last_name" id="last_name" class="form-input @error('last_name') input-error @enderror" value="{{ old('last_name') }}" required>
                @error('last_name') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="suffix">Suffix</label>
                <input type="text" name="suffix" id="suffix" class="form-input @error('suffix') input-error @enderror" value="{{ old('suffix') }}" placeholder="e.g. Jr., Sr., III">
                @error('suffix') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="detail-grid">
            <div class="form-group">
                <label class="form-label" for="sex">Sex <span style="color: var(--danger);">*</span></label>
                <select name="sex" id="sex" class="form-select @error('sex') input-error @enderror" required>
                    <option value="">Select sex...</option>
                    <option value="Male" {{ old('sex') == 'Male' ? 'selected' : '' }}>Male</option>
                    <option value="Female" {{ old('sex') == 'Female' ? 'selected' : '' }}>Female</option>
                </select>
                @error('sex') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="date_of_birth">Date of Birth <span style="color: var(--danger);">*</span></label>
                <input type="date" name="date_of_birth" id="date_of_birth" class="form-input @error('date_of_birth') input-error @enderror" value="{{ old('date_of_birth') }}" required>
                @error('date_of_birth') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="place_of_birth">Place of Birth <span style="color: var(--danger);">*</span></label>
            <input type="text" name="place_of_birth" id="place_of_birth" class="form-input @error('place_of_birth') input-error @enderror" value="{{ old('place_of_birth') }}" required>
            @error('place_of_birth') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions" style="justify-content: flex-end;">
            <button type="button" class="btn btn-primary btn-next">Next Step &rarr;</button>
        </div>
    </div>

    <!-- STEP 2: Contact & Location -->
    <div class="step-content" id="step2">
        <div class="form-section-title">
            <span></span> Location & Contact Information
        </div>

        <div class="detail-grid">
            <div class="form-group">
                <label class="form-label" for="email">Email Address <span style="color: var(--danger);">*</span></label>
                <input type="email" name="email" id="email" class="form-input @error('email') input-error @enderror" value="{{ old('email') }}" placeholder="e.g. juan.delacruz@example.com" required>
                @error('email') <div class="form-error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label class="form-label" for="contact_number">Contact Number <span style="color: var(--danger);">*</span></label>
                <input type="tel" name="contact_number" id="contact_number" class="form-input @error('contact_number') input-error @enderror" value="{{ old('contact_number') }}" required>
                @error('contact_number') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="nationality">Nationality <span style="color: var(--danger);">*</span></label>
            <select name="nationality" id="nationality" class="form-select @error('nationality') input-error @enderror" required>
                <option value="">Select nationality...</option>
                <option value="Filipino" {{ old('nationality', 'Filipino') == 'Filipino' ? 'selected' : '' }}>Filipino</option>
                <option value="Indonesian" {{ old('nationality') == 'Indonesian' ? 'selected' : '' }}>Indonesian</option>
                <option value="Malaysian" {{ old('nationality') == 'Malaysian' ? 'selected' : '' }}>Malaysian</option>
                <option value="Singaporean" {{ old('nationality') == 'Singaporean' ? 'selected' : '' }}>Singaporean</option>
                <option value="Thai" {{ old('nationality') == 'Thai' ? 'selected' : '' }}>Thai</option>
                <option value="Vietnamese" {{ old('nationality') == 'Vietnamese' ? 'selected' : '' }}>Vietnamese</option>
                <option value="Bruneian" {{ old('nationality') == 'Bruneian' ? 'selected' : '' }}>Bruneian</option>
                <option value="Cambodian" {{ old('nationality') == 'Cambodian' ? 'selected' : '' }}>Cambodian</option>
                <option value="Laotian" {{ old('nationality') == 'Laotian' ? 'selected' : '' }}>Laotian</option>
                <option value="Myanmar" {{ old('nationality') == 'Myanmar' ? 'selected' : '' }}>Myanmar</option>
                <option value="Other">Other</option>
            </select>
            @error('nationality') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-group">
            <label class="form-label" for="address">Complete Home Address <span style="color: var(--danger);">*</span></label>
            <input type="text" name="address" id="address" class="form-input @error('address') input-error @enderror" value="{{ old('address') }}" placeholder="e.g. 123 Main St., Brgy. San Jose, Manila" required>
            @error('address') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <div class="form-actions">
            <button type="button" class="btn btn-outline btn-prev">&larr; Previous</button>
            <button type="button" class="btn btn-primary btn-next">Next Step &rarr;</button>
        </div>
    </div>

    <!-- STEP 3: Professional Information -->
    <div class="step-content" id="step3">
        <div class="form-section-title">
            <span></span> Professional Information
        </div>

        <div class="detail-grid">
            <div class="form-group">
                <label class="form-label" for="participant_type">Participant Type <span style="color: var(--danger);">*</span></label>
                <select name="participant_type" id="participant_type" class="form-select @error('participant_type') input-error @enderror" required>
                    <option value="">Select type...</option>
                    @foreach([
                        'Foreign Minister', 'Minister\'s Spouse', 'ASEAN Secretary-General', 'SOM Leader',
                        'ASEAN Deputy Secretary-General for APSC', 'Permanent Representative to ASEAN', 'AMS Official Media',
                        'Delegate (MoD - Substantive Support)', 'Simultaneous Interpreter (Mod - Substantive Support)',
                        'Whispering Interpreter (Mod - Substantive Support)', 'Rapporteur (Mod - Substantive Support)',
                        'Security Officer (Mod - Substantive Support)', 'Medical Officer (Mod - Substantive Support)',
                        'Protocol Officer (Mod - Substantive Support)', 'Admin Support (Mod - Substantive Support)',
                        'Embassy Staff (Mod - Substantive Support)', 'Driver (Mod - Substantive Support)'
                    ] as $type)
                        <option value="{{ $type }}" {{ old('participant_type') == $type ? 'selected' : '' }}>{{ $type }}</option>
                    @endforeach
                </select>
                @error('participant_type') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="ministry_agency">Ministry / Department / Agency <span style="color: var(--danger);">*</span></label>
                <select name="ministry_agency" id="ministry_agency" class="form-select @error('ministry_agency') input-error @enderror" required>
                    <option value="">Select agency...</option>
                    @foreach([
                        'Agrarian Reform', 'Agriculture', 'Budget and Management', 'Central Bank', 'Education', 'Energy',
                        'Environment and Natural Resources', 'Finance', 'Foreign Affairs', 'Health', 'Human Settlements and Urban Development',
                        'Information and Communications Technology', 'Interior and Local Government', 'Justice', 'Labor and Employment',
                        'Migrant Workers', 'National Defense', 'Public Works and Highways', 'Science and Technology',
                        'Social Workers and Development', 'Tourism', 'Trade', 'Transportation', 'Office of the President', 'Senate'
                    ] as $agency)
                        <option value="{{ $agency }}" {{ old('ministry_agency') == $agency ? 'selected' : '' }}>{{ $agency }}</option>
                    @endforeach
                    <option value="Other">Other</option>
                </select>
                <input type="text" id="ministry_agency_other" class="form-input" placeholder="Please specify..." style="display:none; margin-top: 0.5rem;">
                @error('ministry_agency') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="detail-grid">
            <div class="form-group">
                <label class="form-label" for="office_subunit">Office / Sub-unit <span style="color: var(--danger);">*</span></label>
                <input type="text" name="office_subunit" id="office_subunit" class="form-input @error('office_subunit') input-error @enderror" value="{{ old('office_subunit') }}" required>
                @error('office_subunit') <div class="form-error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label class="form-label" for="organization">Organization <span style="color: var(--danger);">*</span></label>
                <input type="text" name="organization" id="organization" class="form-input @error('organization') input-error @enderror" value="{{ old('organization') }}" required>
                @error('organization') <div class="form-error">{{ $message }}</div> @enderror
            </div>
        </div>

        <div class="form-group">
            <label class="form-label" for="designation">Designation / Position <span style="color: var(--danger);">*</span></label>
            <input type="text" name="designation" id="designation" class="form-input @error('designation') input-error @enderror" value="{{ old('designation') }}" required>
            @error('designation') <div class="form-error">{{ $message }}</div> @enderror
        </div>

        <!-- Cloudflare Turnstile -->
        <div class="turnstile-container" id="captcha-container" style="display: none; margin-top: 1.5rem;">
            <div class="cf-turnstile" data-sitekey="{{ config('services.turnstile.site_key') }}"></div>
        </div>
        @error('cf-turnstile-response')
            <div class="form-error" style="text-align: center; margin-bottom: 1rem;">{{ $message }}</div>
        @enderror

        <div class="form-actions">
            <button type="button" class="btn btn-outline btn-prev">&larr; Previous</button>
            <button type="submit" class="btn btn-primary btn-submit" disabled style="opacity: 0.5;">Create Registration</button>
        </div>
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

    // TomSelect implementations
    new TomSelect('#nationality', { searchField: ['text'] });
    new TomSelect('#participant_type', { searchField: ['text'] });
    var ministrySelect = new TomSelect('#ministry_agency', { searchField: ['text'] });

    // Handle "Other" for Ministry
    var ministryOtherInput = document.getElementById('ministry_agency_other');
    ministrySelect.on('change', function(value) {
        if (value === 'Other') {
            ministryOtherInput.style.display = 'block';
            ministryOtherInput.required = true;
            ministryOtherInput.name = 'ministry_agency'; // Override name
            document.getElementById('ministry_agency').name = '';
        } else {
            ministryOtherInput.style.display = 'none';
            ministryOtherInput.required = false;
            ministryOtherInput.name = '';
            document.getElementById('ministry_agency').name = 'ministry_agency';
        }
    });

    // Handle "Other" for Salutation
    var salutationRadios = document.querySelectorAll('input[name="salutation"]');
    var salutationOtherRadio = document.getElementById('salutationOtherRadio');
    var salutationOtherInput = document.getElementById('salutationOtherInput');
    
    salutationRadios.forEach(function(radio) {
        radio.addEventListener('change', function() {
            if (salutationOtherRadio.checked) {
                salutationOtherInput.style.display = 'block';
                salutationOtherInput.required = true;
                // Sync values on submit or change
            } else {
                salutationOtherInput.style.display = 'none';
                salutationOtherInput.required = false;
            }
        });
    });

    salutationOtherInput.addEventListener('input', function() {
        if (salutationOtherRadio.checked) {
            salutationOtherRadio.value = this.value;
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

    phoneInput.addEventListener('input', function() {
        this.value = this.value.replace(/[^0-9]/g, '');
    });

    // Multi-Step Logic
    let currentStep = 1;
    const totalSteps = 3;

    function showStep(step) {
        // Hide all steps
        document.querySelectorAll('.step-content').forEach(el => el.classList.remove('active'));
        // Show current step
        document.getElementById(`step${step}`).classList.add('active');

        // Update markers
        document.querySelectorAll('.step-item').forEach((el, index) => {
            el.classList.remove('active', 'completed');
            if (index + 1 === step) {
                el.classList.add('active');
            } else if (index + 1 < step) {
                el.classList.add('completed');
            }
        });
    }

    function validateStep(step) {
        const currentContent = document.getElementById(`step${step}`);
        const inputs = currentContent.querySelectorAll('input[required], select[required]');
        let isValid = true;

        inputs.forEach(input => {
            if (!input.checkValidity()) {
                input.reportValidity();
                isValid = false;
            }
        });

        return isValid;
    }

    // Next buttons
    document.querySelectorAll('.btn-next').forEach(btn => {
        btn.addEventListener('click', () => {
            if (validateStep(currentStep)) {
                currentStep++;
                showStep(currentStep);
            }
        });
    });

    // Previous buttons
    document.querySelectorAll('.btn-prev').forEach(btn => {
        btn.addEventListener('click', () => {
            currentStep--;
            showStep(currentStep);
        });
    });

    // CAPTCHA Reveal Logic
    var formInputs = document.querySelectorAll('#registrationForm input[required], #registrationForm select[required]');
    var captchaContainer = document.getElementById('captcha-container');
    var submitBtn = document.querySelector('.btn-submit');

    function checkFormFilled() {
        // Only run this check if we are on the last step
        if (currentStep !== 3) return;

        var allFilled = true;
        const step3Inputs = document.getElementById('step3').querySelectorAll('input[required], select[required]');
        
        step3Inputs.forEach(function(input) {
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

    // Handle form submit
    document.querySelector('form').addEventListener('submit', function(e) {
        if (!validateStep(1) || !validateStep(2) || !validateStep(3)) {
            e.preventDefault();
            alert('Please complete all required fields.');
            return;
        }
        if (phoneInput.value.trim() !== '') {
            phoneInput.value = iti.getNumber();
        }
    });

    // Observer for step changes to trigger captcha check
    const observer = new MutationObserver((mutations) => {
        mutations.forEach((mutation) => {
            if (mutation.target.classList.contains('active') && mutation.target.id === 'step3') {
                checkFormFilled();
            }
        });
    });
    observer.observe(document.getElementById('step3'), { attributes: true, attributeFilter: ['class'] });

});
</script>
@endsection
