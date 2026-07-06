<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Réinitialisation | Aurora Marketplace</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/img/aurora-logo.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://unpkg.com/lucide@latest"></script>
    <link rel="stylesheet" href="{{ asset('assets/admin/custom/aurora.css') }}">

    <style>
        * { box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
        }
        .au-rp { width: 100%; max-width: 500px; margin: 0 auto; }
        .au-rp-card {
            background: #fff; border-radius: 20px; padding: 48px 40px 36px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08); border: 1px solid #E2E8F0; width: 100%;
        }
        .au-rp-logo { text-align: center; margin-bottom: 36px; }
        .au-rp-logo img { max-width: 180px; height: auto; display: inline-block; }
        .au-rp-title { text-align: center; margin-bottom: 32px; }
        .au-rp-title h1 { font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 6px; line-height: 1.3; }
        .au-rp-title p { font-size: 14px; color: #64748B; margin: 0; line-height: 1.5; }
        .au-rp-form { display: flex; flex-direction: column; gap: 20px; }
        .au-field { display: flex; flex-direction: column; gap: 6px; }
        .au-field label { font-size: 13px; font-weight: 600; color: #1E293B; }
        .au-field label .required { color: #EF4444; }
        .au-input-wrap { position: relative; display: flex; align-items: center; }
        .au-input-wrap .au-input-icon {
            position: absolute; left: 14px; top: 50%; transform: translateY(-50%);
            color: #94A3B8; pointer-events: none; display: flex;
        }
        .au-input {
            width: 100%; padding: 11px 16px 11px 42px;
            border: 1.5px solid #E2E8F0; border-radius: 10px; font-size: 14px;
            font-family: 'Inter', sans-serif; outline: none; transition: all 0.2s ease;
            background: #F8FAFC; color: #1E293B; line-height: 1.5;
        }
        .au-input:focus { border-color: #F97316; box-shadow: 0 0 0 3px rgba(249,115,22,0.12); background: #fff; }
        .au-input.is-invalid { border-color: #EF4444 !important; background: #FEF2F2 !important; }

        .au-phone-prefix {
            position: absolute; left: 42px; top: 50%; transform: translateY(-50%);
            font-size: 14px; font-weight: 600; color: #1E293B; pointer-events: none; z-index: 2;
            padding-right: 6px; border-right: 1px solid #E2E8F0; line-height: 20px;
            display: flex; align-items: center; height: 24px;
        }
        .au-input.phone-input { padding-left: 92px; }

        .au-pwd-toggle {
            position: absolute; right: 6px; top: 50%; transform: translateY(-50%);
            background: none; border: none; cursor: pointer; color: #94A3B8;
            padding: 8px; display: flex; border-radius: 8px; transition: all 0.2s; z-index: 3;
        }
        .au-pwd-toggle:hover { color: #F97316; background: #FFF7ED; }
        .au-pwd-toggle svg { width: 20px; height: 20px; pointer-events: none; }

        .au-field-error { font-size: 12px; color: #EF4444; display: flex; align-items: center; gap: 4px; margin-top: 2px; }
        .au-field-error svg { width: 14px; height: 14px; flex-shrink: 0; }
        .au-field-error.d-none { display: none !important; }

        .au-alert { display: flex; align-items: center; gap: 10px; padding: 12px 16px; border-radius: 10px; font-size: 13px; margin-bottom: 20px; }
        .au-alert-danger { background: #FEF2F2; color: #DC2626; border: 1px solid #FECACA; }
        .au-alert-success { background: #F0FDF4; color: #16A34A; border: 1px solid #BBF7D0; }
        .au-alert svg { flex-shrink: 0; width: 18px; height: 18px; }
        .au-alert.d-none { display: none !important; }

        .au-btn {
            width: 100%; padding: 13px 24px; background: #F97316; color: #fff;
            border: none; border-radius: 10px; font-size: 15px; font-weight: 600;
            font-family: 'Inter', sans-serif; cursor: pointer; transition: all 0.2s ease;
            display: flex; align-items: center; justify-content: center; gap: 8px;
        }
        .au-btn:hover { background: #EA580C; box-shadow: 0 4px 16px rgba(249,115,22,0.3); transform: translateY(-1px); }
        .au-btn:disabled { opacity: 0.6; cursor: not-allowed; transform: none; box-shadow: none; }
        .au-btn svg { width: 18px; height: 18px; }
        @keyframes au-spin { 0% { transform: rotate(0deg); } 100% { transform: rotate(360deg); } }
        .au-spinner { animation: au-spin 0.8s linear infinite; }

        .au-rp-footer { text-align: center; margin-top: 28px; font-size: 13px; color: #94A3B8; }
        .au-rp-footer a { color: #F97316; text-decoration: none; font-weight: 500; }

        @media (max-width: 425px) {
            .au-rp-card { padding: 28px 20px 24px; }
            .au-rp-logo img { max-width: 130px; }
            .au-rp-title h1 { font-size: 18px; }
        }
        @media (max-width: 320px) {
            .au-rp-card { padding: 20px 12px 16px; }
            .au-rp-logo img { max-width: 100px; }
            .au-rp-title h1 { font-size: 16px; }
            .au-input { padding: 9px 10px 9px 32px; font-size: 13px; }
            .au-input.phone-input { padding-left: 74px; }
            .au-phone-prefix { left: 32px; font-size: 11px; }
        }
    </style>
</head>
<body>
    <div class="au-rp">
        <div class="au-rp-card">
            <div class="au-rp-logo">
                <img src="{{ asset('assets/img/aurora-logo.svg') }}" alt="Aurora Marketplace">
            </div>
            <div class="au-rp-title">
                <h1>Réinitialisation du mot de passe</h1>
                <p>Saisissez votre numéro de téléphone et votre nouveau mot de passe.</p>
            </div>

            <div id="auRpAlert" class="au-alert au-alert-danger d-none">
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><line x1="12" y1="8" x2="12" y2="12"/><line x1="12" y1="16" x2="12.01" y2="16"/></svg>
                <span id="auRpAlertText"></span>
            </div>

            <form class="au-rp-form" action="{{ route('admin.password.update') }}" method="POST" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <div class="au-field">
                    <label for="rpPhone">Téléphone <span class="required">*</span></label>
                    <div class="au-input-wrap">
                        <span class="au-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 16.92v3a2 2 0 0 1-2.18 2 19.79 19.79 0 0 1-8.63-3.07 19.5 19.5 0 0 1-6-6 19.79 19.79 0 0 1-3.07-8.67A2 2 0 0 1 4.11 2h3a2 2 0 0 1 2 1.72 12.84 12.84 0 0 0 .7 2.81 2 2 0 0 1-.45 2.11L8.09 9.91a16 16 0 0 0 6 6l1.27-1.27a2 2 0 0 1 2.11-.45 12.84 12.84 0 0 0 2.81.7A2 2 0 0 1 22 16.92z"/></svg>
                        </span>
                        <span class="au-phone-prefix">+243</span>
                        <input type="tel" id="rpPhone" name="mobile" class="au-input phone-input"
                               placeholder="97 65 43 21 0" inputmode="numeric" maxlength="10" required>
                    </div>
                </div>

                <div class="au-field">
                    <label for="rpPassword">Nouveau mot de passe <span class="required">*</span></label>
                    <div class="au-input-wrap">
                        <span class="au-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="rpPassword" name="password" class="au-input"
                               placeholder="Nouveau mot de passe" required>
                        <button type="button" class="au-pwd-toggle rp-pwd-toggle" data-target="rpPassword">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <div class="au-field">
                    <label for="rpPasswordConfirm">Confirmer le mot de passe <span class="required">*</span></label>
                    <div class="au-input-wrap">
                        <span class="au-input-icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="11" width="18" height="11" rx="2" ry="2"/><path d="M7 11V7a5 5 0 0 1 10 0v4"/></svg>
                        </span>
                        <input type="password" id="rpPasswordConfirm" name="password_confirmation" class="au-input"
                               placeholder="Confirmer le mot de passe" required>
                        <button type="button" class="au-pwd-toggle rp-pwd-toggle" data-target="rpPasswordConfirm">
                            <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/></svg>
                        </button>
                    </div>
                </div>

                <button type="submit" class="au-btn">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><polyline points="22 4 12 14.01 9 11.01"/></svg>
                    Réinitialiser le mot de passe
                </button>
            </form>

            <div class="au-rp-footer">
                Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.home') }}">Aurora Marketplace</a>. Tous droits réservés.
            </div>
        </div>
    </div>

    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            $('.rp-pwd-toggle').on('click', function() {
                var target = $('#' + $(this).data('target'));
                var isPassword = target.attr('type') === 'password';
                target.attr('type', isPassword ? 'text' : 'password');
                $(this).find('svg').html(isPassword
                    ? '<path d="M17.94 17.94A10.07 10.07 0 0 1 12 20c-7 0-11-8-11-8a18.45 18.45 0 0 1 5.06-5.94M9.9 4.24A9.12 9.12 0 0 1 12 4c7 0 11 8 11 8a18.5 18.5 0 0 1-2.16 3.19m-6.72-1.07a3 3 0 1 1-4.24-4.24"/><line x1="1" y1="1" x2="23" y2="23"/>'
                    : '<path d="M1 12s4-8 11-8 11 8 11 8-4 8-11 8-11-8-11-8z"/><circle cx="12" cy="12" r="3"/>'
                );
            });

            $('#rpPhone').on('input', function() {
                $(this).val($(this).val().replace(/[^0-9]/g, ''));
            });
        });
    </script>
</body>
</html>
