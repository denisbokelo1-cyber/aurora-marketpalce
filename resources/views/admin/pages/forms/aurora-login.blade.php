<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Connexion | Aurora Marketplace</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/aurora-logo.svg') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/custom/aurora.css') }}">

    <style>
        /* ===== AURORA LOGIN - COMPLETE REDESIGN ===== */

        * { box-sizing: border-box; }

        body {
            font-family: 'Inter', -apple-system, BlinkMacSystemFont, 'Segoe UI', sans-serif;
            background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }

        /* ===== LOGIN CONTAINER ===== */
        .au-login {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        /* ===== LOGIN CARD ===== */
        .au-login-card {
            background: #FFFFFF;
            border-radius: 20px;
            padding: 48px 40px 36px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 8px 24px rgba(0, 0, 0, 0.04);
            border: 1px solid #E2E8F0;
            width: 100%;
        }

        /* ===== LOGO ===== */
        .au-login-logo {
            text-align: center;
            margin-bottom: 36px;
        }
        .au-login-logo img {
            max-width: 180px;
            height: auto;
            display: inline-block;
        }

        /* ===== TITLE & DESCRIPTION ===== */
        .au-login-title {
            text-align: center;
            margin-bottom: 32px;
        }
        .au-login-title h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1E293B;
            margin: 0 0 6px;
            line-height: 1.3;
        }
        .au-login-title p {
            font-size: 14px;
            color: #64748B;
            margin: 0;
            line-height: 1.5;
        }

        /* ===== ALERT ===== */
        .au-login-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.4;
        }
        .au-login-alert-danger {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
        }
        .au-login-alert-success {
            background: #F0FDF4;
            color: #16A34A;
            border: 1px solid #BBF7D0;
        }
        .au-login-alert svg { flex-shrink: 0; width: 18px; height: 18px; }
        .au-login-alert.d-none { display: none !important; }

        /* ===== FORM ===== */
        .au-login-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

        /* ===== FIELD ===== */
        .au-field {
            display: flex;
            flex-direction: column;
            gap: 6px;
        }
        .au-field label {
            font-size: 13px;
            font-weight: 600;
            color: #1E293B;
            display: flex;
            align-items: center;
            gap: 4px;
        }
        .au-field label .required { color: #EF4444; }

        /* ===== INPUT WRAPPER ===== */
        .au-input-wrap {
            position: relative;
            display: flex;
            align-items: center;
        }
        .au-input-wrap .au-input-icon {
            position: absolute;
            left: 14px;
            top: 50%;
            transform: translateY(-50%);
            color: #94A3B8;
            pointer-events: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 20px;
            height: 20px;
        }
        .au-input-wrap .au-input-icon svg {
            width: 18px;
            height: 18px;
        }

        /* ===== PHONE PREFIX ===== */
        .au-phone-prefix {
            position: absolute;
            left: 42px;
            top: 50%;
            transform: translateY(-50%);
            font-size: 14px;
            font-weight: 600;
            color: #1E293B;
            pointer-events: none;
            z-index: 2;
            background: transparent;
            padding-right: 6px;
            border-right: 1px solid #E2E8F0;
            line-height: 20px;
            display: flex;
            align-items: center;
            height: 24px;
        }

        /* ===== INPUT ===== */
        .au-input {
            width: 100%;
            padding: 11px 16px 11px 42px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.2s ease;
            background: #F8FAFC;
            color: #1E293B;
            line-height: 1.5;
        }
        .au-input:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249, 115, 22, 0.12);
            background: #FFFFFF;
        }
        .au-input::placeholder {
            color: #94A3B8;
            opacity: 1;
        }
        .au-input.is-invalid {
            border-color: #EF4444 !important;
            background: #FEF2F2 !important;
        }
        .au-input.is-invalid:focus {
            box-shadow: 0 0 0 3px rgba(239, 68, 68, 0.12) !important;
        }
        .au-input.phone-input {
            padding-left: 92px;
        }

        /* ===== ERROR MESSAGE ===== */
        .au-field-error {
            font-size: 12px;
            color: #EF4444;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px;
        }
        .au-field-error svg {
            width: 14px;
            height: 14px;
            flex-shrink: 0;
        }
        .au-field-error.d-none { display: none !important; }

        /* ===== PASSWORD TOGGLE ===== */
        .au-pwd-toggle {
            position: absolute;
            right: 6px;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            cursor: pointer;
            color: #94A3B8;
            padding: 8px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 8px;
            transition: all 0.2s;
            z-index: 3;
        }
        .au-pwd-toggle:hover {
            color: #F97316;
            background: #FFF7ED;
        }
        .au-pwd-toggle svg {
            width: 20px;
            height: 20px;
            pointer-events: none;
        }

        /* ===== FORGOT LINK ===== */
        .au-forgot {
            text-align: right;
            margin-top: -10px;
        }
        .au-forgot a {
            font-size: 13px;
            font-weight: 500;
            color: #F97316;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        .au-forgot a:hover {
            color: #EA580C;
            text-decoration: underline;
        }
        .au-forgot a svg {
            width: 16px;
            height: 16px;
        }

        /* ===== SUBMIT BUTTON ===== */
        .au-btn {
            width: 100%;
            padding: 13px 24px;
            background: #F97316;
            color: #FFFFFF;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            font-family: 'Inter', sans-serif;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            line-height: 1.5;
        }
        .au-btn:hover {
            background: #EA580C;
            box-shadow: 0 4px 16px rgba(249, 115, 22, 0.3);
            transform: translateY(-1px);
        }
        .au-btn:active {
            transform: translateY(0);
        }
        .au-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .au-btn svg {
            width: 18px;
            height: 18px;
        }

        /* ===== SPINNER ===== */
        @keyframes au-spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .au-spinner {
            animation: au-spin 0.8s linear infinite;
        }

        /* ===== FOOTER ===== */
        .au-login-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 13px;
            color: #94A3B8;
        }
        .au-login-footer a {
            color: #F97316;
            text-decoration: none;
            font-weight: 500;
        }
        .au-login-footer a:hover { text-decoration: underline; }

        /* ===== SESSION MESSAGES ===== */
        .au-session-msg {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
        }
        .au-session-msg.error {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
        }
        .au-session-msg.success {
            background: #F0FDF4;
            color: #16A34A;
            border: 1px solid #BBF7D0;
        }

        /* ================================================
                   RESPONSIVE BREAKPOINTS
                   ================================================ */

        /* 1440px - Desktop large */
        @media (min-width: 1440px) {
            .au-login { max-width: 520px; }
            .au-login-card { padding: 52px 44px 40px; }
        }

        /* 1024px - Desktop standard */
        @media (min-width: 1025px) and (max-width: 1439px) {
            .au-login-card { padding: 44px 36px 32px; }
        }

        /* 768px - Tablet */
        @media (max-width: 768px) {
            body { padding: 20px; }
            .au-login { max-width: 460px; }
            .au-login-card { padding: 36px 28px 28px; border-radius: 16px; }
            .au-login-logo img { max-width: 150px; }
            .au-login-title h1 { font-size: 20px; }
            .au-btn { padding: 12px 20px; }
        }

        /* 425px - Mobile large */
        @media (max-width: 425px) {
            body { padding: 16px; }
            .au-login-card { padding: 28px 20px 24px; border-radius: 14px; }
            .au-login-logo { margin-bottom: 28px; }
            .au-login-logo img { max-width: 130px; }
            .au-login-title { margin-bottom: 24px; }
            .au-login-title h1 { font-size: 18px; }
            .au-login-title p { font-size: 13px; }
            .au-login-form { gap: 16px; }
            .au-input { padding: 10px 14px 10px 38px; font-size: 14px; }
            .au-input.phone-input { padding-left: 86px; }
            .au-phone-prefix { left: 38px; font-size: 13px; }
            .au-btn { font-size: 14px; padding: 11px 16px; }
        }

        /* 375px - Mobile medium */
        @media (max-width: 375px) {
            body { padding: 12px; }
            .au-login-card { padding: 24px 16px 20px; }
            .au-login-logo img { max-width: 110px; }
            .au-login-title h1 { font-size: 17px; }
            .au-input { padding: 10px 12px 10px 36px; font-size: 13px; }
            .au-input.phone-input { padding-left: 80px; }
            .au-phone-prefix { left: 36px; font-size: 12px; }
            .au-input-wrap .au-input-icon { left: 12px; }
            .au-input-wrap .au-input-icon svg { width: 16px; height: 16px; }
        }

        /* 320px - Mobile small */
        @media (max-width: 320px) {
            body { padding: 8px; }
            .au-login-card { padding: 20px 12px 16px; border-radius: 12px; }
            .au-login-logo { margin-bottom: 20px; }
            .au-login-logo img { max-width: 100px; }
            .au-login-title h1 { font-size: 16px; }
            .au-login-title p { font-size: 12px; }
            .au-login-form { gap: 14px; }
            .au-input { padding: 9px 10px 9px 32px; font-size: 13px; }
            .au-input.phone-input { padding-left: 74px; }
            .au-phone-prefix { left: 32px; font-size: 11px; }
            .au-input-wrap .au-input-icon { left: 10px; }
            .au-input-wrap .au-input-icon svg { width: 14px; height: 14px; }
            .au-btn { font-size: 13px; padding: 10px 12px; }
            .au-login-footer { font-size: 12px; }
        }

        /* ===== CONGO PHONE VALIDATION HELPER ===== */
        .au-phone-hint {
            font-size: 12px;
            color: #64748B;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .au-phone-hint svg { width: 14px; height: 14px; color: #94A3B8; flex-shrink: 0; }

        /* ===== ALL MODIFICATION CHECK HIDE ===== */
        .au-demo-only { display: none !important; }
    </style>
</head>
<body>
    <div class="au-login">
        <div class="au-login-card">
            <!-- LOGO -->
            <div class="au-login-logo">
                <img src="{{ asset('assets/img/aurora-logo.svg') }}" alt="Aurora Marketplace">
            </div>

            <!-- TITLE -->
            <div class="au-login-title">
                <h1>Connexion Administrateur</h1>
                <p>Accédez à votre tableau de bord Aurora Marketplace</p>
            </div>

            <!-- Session Error -->
            @if(session('error'))
                <div class="au-session-msg error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>{{ session('error') }}</span>
                </div>
            @endif

            <!-- Validation Errors -->
            @if($errors->any())
                <div class="au-session-msg error">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                    <span>
                        @foreach($errors->all() as $err)
                            {{ $err }}@if(!$loop->last)<br>@endif
                        @endforeach
                    </span>
                </div>
            @endif

            <!-- AJAX Alert -->
            <div id="auLoginAlert" class="au-login-alert au-login-alert-danger d-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span id="auLoginAlertText">Numéro de téléphone ou mot de passe incorrect.</span>
            </div>

            <!-- FORM -->
            <form class="au-login-form" id="auLoginForm" action="{{ route('admin.authenticate') }}" method="POST" novalidate>
                @csrf

                <!-- Phone Field -->
                <div class="au-field">
                    <label for="auPhoneInput">
                        Téléphone <span class="required">*</span>
                    </label>
                    <div class="au-input-wrap">
                        <span class="au-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <span class="au-phone-prefix">+243</span>
                        <input type="tel" id="auPhoneInput" name="mobile"
                               class="au-input phone-input"
                               placeholder="97 65 43 21 0"
                               autocomplete="off"
                               inputmode="numeric"
                               maxlength="10"
                               required>
                    </div>
                    <div class="au-field-error d-none" id="auPhoneError">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>Numéro de téléphone congolais invalide (9 chiffres après +243).</span>
                    </div>
                    <div class="au-phone-hint">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Format : +243 97 65 43 21 0 ou 097 65 43 21 0
                    </div>
                </div>

                <!-- Password Field -->
                <div class="au-field">
                    <label for="auPasswordInput">
                        Mot de passe <span class="required">*</span>
                    </label>
                    <div class="au-input-wrap">
                        <span class="au-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="auPasswordInput" name="password"
                               class="au-input"
                               placeholder="Entrez votre mot de passe"
                               autocomplete="current-password"
                               required>
                        <button type="button" class="au-pwd-toggle" id="auPwdToggle" aria-label="Afficher le mot de passe">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" id="auEyeIcon"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                    <div class="au-field-error d-none" id="auPasswordError">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>Le mot de passe est obligatoire.</span>
                    </div>
                </div>

                <!-- Forgot password -->
                <div class="au-forgot">
                    <a href="{{ route('password.request') }}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="M12 16v-4"/><path d="M12 8h.01"/></svg>
                        Mot de passe oublié ?
                    </a>
                </div>

                <!-- Submit -->
                <button type="submit" class="au-btn" id="auLoginBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg>
                    Se connecter
                </button>
            </form>

            <!-- Footer -->
            <div class="au-login-footer">
                Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.home') }}">Aurora Marketplace</a>. Tous droits réservés.
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        // Init Lucide icons
        if (typeof lucide !== 'undefined') {
            lucide.createIcons();
        }

        $(document).ready(function() {
            var $phoneInput = $('#auPhoneInput');
            var $phoneError = $('#auPhoneError');
            var $passwordInput = $('#auPasswordInput');
            var $passwordError = $('#auPasswordError');
            var $alert = $('#auLoginAlert');
            var $alertText = $('#auLoginAlertText');
            var $btn = $('#auLoginBtn');
            var $form = $('#auLoginForm');
            var $eyeIcon = $('#auEyeIcon');

            // ===== CONGOLESE PHONE VALIDATION =====
            function validateCongoPhone(value) {
                // Strip all non-digits
                var digits = value.replace(/\D/g, '');

                // If empty, no error yet (required will be checked on submit)
                if (digits.length === 0) return { valid: false, normalized: '' };

                // Handle full number with +243 prefix
                if (digits.startsWith('243') && digits.length >= 12) {
                    digits = digits.substring(3);
                }
                // Handle local format with leading 0
                if (digits.startsWith('0') && digits.length === 10) {
                    digits = digits.substring(1);
                }

                // Valid Congolese numbers have exactly 9 digits after +243
                // and start with 8, 9, or 0 (for the 0xx format)
                var isValid = digits.length === 9;

                return { valid: isValid, normalized: digits };
            }

            // ===== REAL-TIME VALIDATION =====
            function validatePhoneInput(showError) {
                var val = $phoneInput.val();
                var result = validateCongoPhone(val);

                if (result.valid) {
                    $phoneInput.removeClass('is-invalid');
                    $phoneError.addClass('d-none');
                    // Store normalized number (digits only, without prefix)
                    $phoneInput.data('normalized', result.normalized);
                    return true;
                } else {
                    if (showError && val.length > 0) {
                        $phoneInput.addClass('is-invalid');
                        $phoneError.removeClass('d-none');
                    } else {
                        $phoneInput.removeClass('is-invalid');
                        $phoneError.addClass('d-none');
                    }
                    return false;
                }
            }

            // Validate on input (with debounce, only show after typing)
            var phoneTimer;
            $phoneInput.on('input', function() {
                clearTimeout(phoneTimer);
                phoneTimer = setTimeout(function() {
                    validatePhoneInput(true);
                }, 300);

                // Auto-format: strip non-digits
                var raw = $(this).val().replace(/[^0-9]/g, '');
                $(this).val(raw);
            });

            // ===== PASSWORD TOGGLE =====
            $('#auPwdToggle').on('click', function() {
                var isPassword = $passwordInput.attr('type') === 'password';
                $passwordInput.attr('type', isPassword ? 'text' : 'password');

                // Toggle eye icon
                if (isPassword) {
                    $eyeIcon.html('<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>');
                } else {
                    $eyeIcon.html('<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>');
                }
                $(this).attr('aria-label', isPassword ? 'Masquer' : 'Afficher');
            });

            // ===== FORM SUBMIT =====
            $form.on('submit', function(e) {
                e.preventDefault();

                // Reset UI
                $('.au-input').removeClass('is-invalid');
                $('.au-field-error').addClass('d-none');
                $alert.addClass('d-none');

                // Validate phone
                var phoneVal = $phoneInput.val();
                var phoneResult = validateCongoPhone(phoneVal);

                if (!phoneVal.trim()) {
                    $phoneInput.addClass('is-invalid');
                    $('#auPhoneError span').text('Veuillez saisir votre numéro de téléphone.');
                    $('#auPhoneError').removeClass('d-none');
                    $phoneInput.focus();
                    return;
                }

                if (!phoneResult.valid) {
                    $phoneInput.addClass('is-invalid');
                    $('#auPhoneError span').text('Numéro de téléphone congolais invalide. Format attendu : +243 97 65 43 21 0');
                    $('#auPhoneError').removeClass('d-none');
                    $phoneInput.focus();
                    return;
                }

                // Validate password
                var pwdVal = $passwordInput.val();
                if (!pwdVal.trim()) {
                    $passwordInput.addClass('is-invalid');
                    $passwordError.removeClass('d-none');
                    $passwordInput.focus();
                    return;
                }

                // Prepare data: send normalized phone
                var normalizedPhone = phoneResult.normalized;
                var formData = $(this).serializeArray();
                formData.push({ name: 'country_code', value: '243' });
                formData.push({ name: 'mobile', value: normalizedPhone });

                // Disable button
                $btn.prop('disabled', true).html(
                    '<svg class="au-spinner" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg> Connexion en cours...'
                );

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(response) {
                        if (response.location) {
                            window.location.href = response.location;
                        }
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M15 3h4a2 2 0 0 1 2 2v14a2 2 0 0 1-2 2h-4"/><polyline points="10 17 15 12 10 7"/><line x1="15" y1="12" x2="3" y2="12"/></svg> Se connecter'
                        );

                        var errorMsg = 'Numéro de téléphone ou mot de passe incorrect.';

                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.errors) {
                                var errors = xhr.responseJSON.errors;
                                var msgs = [];
                                for (var key in errors) {
                                    if (errors.hasOwnProperty(key)) {
                                        var arr = Array.isArray(errors[key]) ? errors[key] : [errors[key]];
                                        arr.forEach(function(m) { msgs.push(m); });
                                    }
                                }
                                if (msgs.length) errorMsg = msgs.join('<br>');

                                // Show inline field errors
                                var fieldMap = { 'mobile': '#auPhoneInput', 'password': '#auPasswordInput' };
                                for (var key in errors) {
                                    if (fieldMap[key]) {
                                        var inp = $(fieldMap[key]);
                                        inp.addClass('is-invalid');
                                        var firstMsg = Array.isArray(errors[key]) ? errors[key][0] : errors[key];
                                        var errDiv = key === 'mobile' ? $('#auPhoneError') : $('#auPasswordError');
                                        if (errDiv.length) {
                                            errDiv.find('span').text(firstMsg);
                                            errDiv.removeClass('d-none');
                                        }
                                    }
                                }
                            } else if (xhr.responseJSON.message) {
                                errorMsg = xhr.responseJSON.message;
                            }
                        }

                        $alertText.html(errorMsg);
                        $alert.removeClass('d-none');
                    }
                });
            });
        });
    </script>
</body>
</html>
