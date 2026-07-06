<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Mot de passe oublié | Aurora Marketplace</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/aurora-logo.svg') }}">

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">

    <!-- Lucide Icons -->
    <script src="https://unpkg.com/lucide@latest"></script>

    <!-- Styles -->
    <link rel="stylesheet" href="{{ asset('assets/admin/custom/aurora.css') }}">

    <style>
        /* ===== AURORA FORGOT PASSWORD ===== */
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

        .au-forgot {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .au-forgot-card {
            background: #FFFFFF;
            border-radius: 20px;
            padding: 48px 40px 36px;
            box-shadow: 0 20px 60px rgba(0, 0, 0, 0.08), 0 8px 24px rgba(0, 0, 0, 0.04);
            border: 1px solid #E2E8F0;
            width: 100%;
        }

        .au-forgot-logo {
            text-align: center;
            margin-bottom: 36px;
        }
        .au-forgot-logo img {
            max-width: 180px;
            height: auto;
            display: inline-block;
        }

        .au-forgot-title {
            text-align: center;
            margin-bottom: 32px;
        }
        .au-forgot-title h1 {
            font-size: 22px;
            font-weight: 700;
            color: #1E293B;
            margin: 0 0 6px;
            line-height: 1.3;
        }
        .au-forgot-title p {
            font-size: 14px;
            color: #64748B;
            margin: 0;
            line-height: 1.5;
        }

        .au-alert {
            display: flex;
            align-items: center;
            gap: 10px;
            padding: 12px 16px;
            border-radius: 10px;
            font-size: 13px;
            margin-bottom: 20px;
            line-height: 1.4;
        }
        .au-alert-danger {
            background: #FEF2F2;
            color: #DC2626;
            border: 1px solid #FECACA;
        }
        .au-alert-success {
            background: #F0FDF4;
            color: #16A34A;
            border: 1px solid #BBF7D0;
        }
        .au-alert svg { flex-shrink: 0; width: 18px; height: 18px; }
        .au-alert.d-none { display: none !important; }

        .au-forgot-form {
            display: flex;
            flex-direction: column;
            gap: 20px;
        }

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

        .au-field-error {
            font-size: 12px;
            color: #EF4444;
            display: flex;
            align-items: center;
            gap: 4px;
            margin-top: 2px;
        }
        .au-field-error svg { width: 14px; height: 14px; flex-shrink: 0; }
        .au-field-error.d-none { display: none !important; }

        .au-phone-hint {
            font-size: 12px;
            color: #64748B;
            margin-top: 2px;
            display: flex;
            align-items: center;
            gap: 6px;
        }
        .au-phone-hint svg { width: 14px; height: 14px; color: #94A3B8; flex-shrink: 0; }

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
        .au-btn:active { transform: translateY(0); }
        .au-btn:disabled {
            opacity: 0.6;
            cursor: not-allowed;
            transform: none;
            box-shadow: none;
        }
        .au-btn svg { width: 18px; height: 18px; }

        @keyframes au-spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .au-spinner { animation: au-spin 0.8s linear infinite; }

        .au-back-link {
            text-align: center;
            margin-top: 24px;
        }
        .au-back-link a {
            font-size: 13px;
            font-weight: 500;
            color: #64748B;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 6px;
            transition: color 0.2s;
        }
        .au-back-link a:hover { color: #F97316; }
        .au-back-link a svg { width: 16px; height: 16px; }

        .au-forgot-footer {
            text-align: center;
            margin-top: 28px;
            font-size: 13px;
            color: #94A3B8;
        }
        .au-forgot-footer a {
            color: #F97316;
            text-decoration: none;
            font-weight: 500;
        }
        .au-forgot-footer a:hover { text-decoration: underline; }

        /* ===== RESPONSIVE ===== */
        @media (min-width: 1440px) {
            .au-forgot { max-width: 520px; }
            .au-forgot-card { padding: 52px 44px 40px; }
        }
        @media (min-width: 1025px) and (max-width: 1439px) {
            .au-forgot-card { padding: 44px 36px 32px; }
        }
        @media (max-width: 768px) {
            body { padding: 20px; }
            .au-forgot { max-width: 460px; }
            .au-forgot-card { padding: 36px 28px 28px; border-radius: 16px; }
            .au-forgot-logo img { max-width: 150px; }
            .au-forgot-title h1 { font-size: 20px; }
            .au-btn { padding: 12px 20px; }
        }
        @media (max-width: 425px) {
            body { padding: 16px; }
            .au-forgot-card { padding: 28px 20px 24px; border-radius: 14px; }
            .au-forgot-logo { margin-bottom: 28px; }
            .au-forgot-logo img { max-width: 130px; }
            .au-forgot-title { margin-bottom: 24px; }
            .au-forgot-title h1 { font-size: 18px; }
            .au-forgot-title p { font-size: 13px; }
            .au-forgot-form { gap: 16px; }
            .au-input { padding: 10px 14px 10px 38px; font-size: 14px; }
            .au-input.phone-input { padding-left: 86px; }
            .au-phone-prefix { left: 38px; font-size: 13px; }
            .au-btn { font-size: 14px; padding: 11px 16px; }
        }
        @media (max-width: 375px) {
            body { padding: 12px; }
            .au-forgot-card { padding: 24px 16px 20px; }
            .au-forgot-logo img { max-width: 110px; }
            .au-forgot-title h1 { font-size: 17px; }
            .au-input { padding: 10px 12px 10px 36px; font-size: 13px; }
            .au-input.phone-input { padding-left: 80px; }
            .au-phone-prefix { left: 36px; font-size: 12px; }
            .au-input-wrap .au-input-icon { left: 12px; }
            .au-input-wrap .au-input-icon svg { width: 16px; height: 16px; }
        }
        @media (max-width: 320px) {
            body { padding: 8px; }
            .au-forgot-card { padding: 20px 12px 16px; border-radius: 12px; }
            .au-forgot-logo { margin-bottom: 20px; }
            .au-forgot-logo img { max-width: 100px; }
            .au-forgot-title h1 { font-size: 16px; }
            .au-forgot-title p { font-size: 12px; }
            .au-forgot-form { gap: 14px; }
            .au-input { padding: 9px 10px 9px 32px; font-size: 13px; }
            .au-input.phone-input { padding-left: 74px; }
            .au-phone-prefix { left: 32px; font-size: 11px; }
            .au-input-wrap .au-input-icon { left: 10px; }
            .au-input-wrap .au-input-icon svg { width: 14px; height: 14px; }
            .au-btn { font-size: 13px; padding: 10px 12px; }
            .au-forgot-footer { font-size: 12px; }
        }
    </style>
</head>
<body>
    <div class="au-forgot">
        <div class="au-forgot-card">
            <!-- LOGO -->
            <div class="au-forgot-logo">
                <img src="{{ asset('assets/img/aurora-logo.svg') }}" alt="Aurora Marketplace">
            </div>

            <!-- TITLE -->
            <div class="au-forgot-title">
                <h1>Mot de passe oublié</h1>
                <p>Saisissez votre numéro de téléphone pour recevoir un lien de réinitialisation par e-mail.</p>
            </div>

            <!-- Alert -->
            <div id="auForgotAlert" class="au-alert au-alert-danger d-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span id="auForgotAlertText"></span>
            </div>

            <!-- Success -->
            <div id="auForgotSuccess" class="au-alert au-alert-success d-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                <span id="auForgotSuccessText">Un lien de réinitialisation vous a été envoyé par e-mail.</span>
            </div>

            <!-- FORM -->
            <form class="au-forgot-form" id="auForgotForm" action="{{ route('password.email') }}" method="POST" novalidate>
                @csrf

                <!-- Phone -->
                <div class="au-field">
                    <label for="auForgotPhone">
                        Téléphone <span class="required">*</span>
                    </label>
                    <div class="au-input-wrap">
                        <span class="au-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <span class="au-phone-prefix">+243</span>
                        <input type="tel" id="auForgotPhone" name="mobile"
                               class="au-input phone-input"
                               placeholder="97 65 43 21 0"
                               autocomplete="off"
                               inputmode="numeric"
                               maxlength="10"
                               required>
                    </div>
                    <div class="au-field-error d-none" id="auForgotPhoneError">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                        <span>Numéro de téléphone congolais invalide.</span>
                    </div>
                    <div class="au-phone-hint">
                        <svg xmlns="http://www.w3.org/2000/svg" width="14" height="14" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="16" x2="12" y2="12"/><line x1="12" y1="8" x2="12.01" y2="8"/></svg>
                        Format : +243 97 65 43 21 0 ou 097 65 43 21 0
                    </div>
                </div>

                <!-- Submit -->
                <button type="submit" class="au-btn" id="auForgotBtn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Recevoir un lien de réinitialisation
                </button>
            </form>

            <!-- Back to login -->
            <div class="au-back-link">
                <a href="{{ route('admin.login') }}">
                    <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="19" y1="12" x2="5" y2="12"/><polyline points="12 19 5 12 12 5"/></svg>
                    Retour à la connexion
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div class="au-forgot-footer">
            Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.home') }}">Aurora Marketplace</a>. Tous droits réservés.
        </div>
    </div>

    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script src="https://unpkg.com/lucide@latest/dist/umd/lucide.js"></script>
    <script>
        if (typeof lucide !== 'undefined') { lucide.createIcons(); }

        $(document).ready(function() {
            var $phone = $('#auForgotPhone');
            var $phoneError = $('#auForgotPhoneError');
            var $alert = $('#auForgotAlert');
            var $alertText = $('#auForgotAlertText');
            var $success = $('#auForgotSuccess');
            var $successText = $('#auForgotSuccessText');
            var $btn = $('#auForgotBtn');
            var $form = $('#auForgotForm');

            function validateCongoPhone(value) {
                var digits = value.replace(/\D/g, '');
                if (digits.length === 0) return { valid: false, normalized: '' };
                if (digits.startsWith('243') && digits.length >= 12) { digits = digits.substring(3); }
                if (digits.startsWith('0') && digits.length === 10) { digits = digits.substring(1); }
                return { valid: digits.length === 9, normalized: digits };
            }

            var phoneTimer;
            $phone.on('input', function() {
                clearTimeout(phoneTimer);
                phoneTimer = setTimeout(function() {
                    var val = $phone.val();
                    var result = validateCongoPhone(val);
                    if (result.valid || val.length === 0) {
                        $phone.removeClass('is-invalid');
                        $phoneError.addClass('d-none');
                    } else if (val.length > 0) {
                        $phone.addClass('is-invalid');
                        $phoneError.removeClass('d-none');
                    }
                }, 300);
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });

            $form.on('submit', function(e) {
                e.preventDefault();
                $('.au-input').removeClass('is-invalid');
                $('.au-field-error').addClass('d-none');
                $alert.addClass('d-none');
                $success.addClass('d-none');

                var phoneVal = $phone.val();
                var phoneResult = validateCongoPhone(phoneVal);

                if (!phoneVal.trim()) {
                    $phone.addClass('is-invalid');
                    $('#auForgotPhoneError span').text('Veuillez saisir votre numéro de téléphone.');
                    $('#auForgotPhoneError').removeClass('d-none');
                    $phone.focus();
                    return;
                }

                if (!phoneResult.valid) {
                    $phone.addClass('is-invalid');
                    $('#auForgotPhoneError span').text('Numéro de téléphone congolais invalide. Format attendu : +243 97 65 43 21 0');
                    $('#auForgotPhoneError').removeClass('d-none');
                    $phone.focus();
                    return;
                }

                var normalizedPhone = phoneResult.normalized;
                var formData = $(this).serializeArray();
                formData.push({ name: 'mobile', value: normalizedPhone });

                $btn.prop('disabled', true).html(
                    '<svg class="au-spinner" xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="2" x2="12" y2="6"/><line x1="12" y1="18" x2="12" y2="22"/><line x1="4.93" y1="4.93" x2="7.76" y2="7.76"/><line x1="16.24" y1="16.24" x2="19.07" y2="19.07"/><line x1="2" y1="12" x2="6" y2="12"/><line x1="18" y1="12" x2="22" y2="12"/><line x1="4.93" y1="19.07" x2="7.76" y2="16.24"/><line x1="16.24" y1="7.76" x2="19.07" y2="4.93"/></svg> Envoi en cours...'
                );

                $.ajax({
                    url: $form.attr('action'),
                    method: 'POST',
                    data: formData,
                    headers: { 'X-Requested-With': 'XMLHttpRequest' },
                    success: function(response) {
                        $btn.prop('disabled', false).html(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Recevoir un lien de réinitialisation'
                        );

                        if (!response.error) {
                            $successText.text(response.message || 'Un lien de réinitialisation vous a été envoyé par e-mail.');
                            $success.removeClass('d-none');
                        } else {
                            $alertText.text(response.error_message || response.message || 'Une erreur est survenue.');
                            $alert.removeClass('d-none');
                        }
                    },
                    error: function(xhr) {
                        $btn.prop('disabled', false).html(
                            '<svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg> Recevoir un lien de réinitialisation'
                        );

                        var errorMsg = 'Une erreur est survenue. Veuillez réessayer.';
                        if (xhr.responseJSON) {
                            if (xhr.responseJSON.error_message) errorMsg = xhr.responseJSON.error_message;
                            else if (xhr.responseJSON.message) errorMsg = xhr.responseJSON.message;
                            else if (xhr.responseJSON.errors) {
                                var msgs = [];
                                for (var key in xhr.responseJSON.errors) {
                                    if (xhr.responseJSON.errors.hasOwnProperty(key)) {
                                        var arr = Array.isArray(xhr.responseJSON.errors[key]) ? xhr.responseJSON.errors[key] : [xhr.responseJSON.errors[key]];
                                        arr.forEach(function(m) { msgs.push(m); });
                                    }
                                }
                                if (msgs.length) errorMsg = msgs.join('<br>');
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
