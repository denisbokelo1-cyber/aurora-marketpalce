<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    @if ($system_settings != null)
        <link rel="icon" type="image/png" href="{{ app(\App\Services\MediaService::class)->getMediaImageUrl($system_settings['favicon']) }}">
    @endif
    <title>{{ labels('panel_labels.login', 'Login') }} | {{ $system_settings['app_name'] }}</title>

    <!-- Fonts & Styles -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('assets/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/custom/aurora.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/custom/custom.css') }}">

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background: linear-gradient(135deg, #F8FAFC 0%, #F1F5F9 100%);
            min-height: 100vh;
            margin: 0;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-wrapper {
            width: 100%;
            max-width: 500px;
            padding: 24px;
        }
        .login-card {
            background: #fff;
            border-radius: 20px;
            padding: 48px 40px 36px;
            box-shadow: 0 20px 60px rgba(0,0,0,0.08);
            border: 1px solid #E2E8F0;
        }
        .login-logo { text-align: center; margin-bottom: 36px; }
        .login-logo img { max-width: 160px; height: auto; }
        .login-title { text-align: center; margin-bottom: 32px; }
        .login-title h1 { font-size: 22px; font-weight: 700; color: #1E293B; margin: 0 0 6px; }
        .login-title p { font-size: 14px; color: #64748B; margin: 0; }
        .login-form { display: flex; flex-direction: column; gap: 20px; }
        .login-form .form-group { display: flex; flex-direction: column; gap: 6px; }
        .login-form label { font-size: 13px; font-weight: 600; color: #1E293B; }
        .login-form .form-control {
            padding: 11px 16px;
            border: 1.5px solid #E2E8F0;
            border-radius: 10px;
            font-size: 14px;
            font-family: 'Inter', sans-serif;
            outline: none;
            transition: all 0.2s;
            background: #F8FAFC;
            color: #1E293B;
        }
        .login-form .form-control:focus {
            border-color: #F97316;
            box-shadow: 0 0 0 3px rgba(249,115,22,0.12);
            background: #fff;
        }
        .login-btn {
            padding: 13px 20px;
            background: #F97316;
            color: #fff;
            border: none;
            border-radius: 10px;
            font-size: 15px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.2s;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
        }
        .login-btn:hover { background: #EA580C; box-shadow: 0 4px 16px rgba(249,115,22,0.3); transform: translateY(-1px); }
        .forgot-link { text-align: right; margin-top: -10px; }
        .forgot-link a { font-size: 13px; color: #F97316; text-decoration: none; }
        .forgot-link a:hover { text-decoration: underline; }
        .login-footer { text-align: center; margin-top: 28px; font-size: 13px; color: #94A3B8; }
        .login-footer a { color: #F97316; text-decoration: none; }

        @media (max-width: 425px) {
            .login-wrapper { padding: 16px; }
            .login-card { padding: 28px 20px 24px; }
            .login-logo img { max-width: 130px; }
        }
    </style>
</head>
<body>
    <div class="login-wrapper">
        <div class="login-card">
            <div class="login-logo">
                <img src="{{ asset('assets/img/aurora-logo.svg') }}" alt="Aurora Marketplace">
            </div>
            <div class="login-title">
                <h1>{{ labels('panel_labels.admin_login', 'Admin Login') }}</h1>
                <p>{{ labels('panel_labels.enter_details_to_sign_in', 'Connectez-vous à votre compte administrateur') }}</p>
            </div>

            @if(session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="alert alert-danger">
                    @foreach($errors->all() as $err)<div>{{ $err }}</div>@endforeach
                </div>
            @endif

            <form class="login-form" action="{{ route('admin.authenticate') }}" method="POST">
                @csrf
                <div class="form-group">
                    <label for="mobile">{{ labels('panel_labels.mobile', 'Téléphone') }}<span class="text-danger">*</span></label>
                    <input type="tel" class="form-control" id="mobile" name="mobile"
                           placeholder="+243 97 65 43 21 0" autocomplete="off">
                </div>
                <div>
                    <label for="password">{{ labels('panel_labels.password', 'Mot de passe') }}<span class="text-danger">*</span></label>
                    <input type="password" class="form-control" name="password" id="password"
                           placeholder="Entrez votre mot de passe" autocomplete="current-password">
                </div>
                <div class="forgot-link">
                    <a href="{{ route('password.request') }}">{{ labels('panel_labels.forgot_password', 'Mot de passe oublié') }}?</a>
                </div>
                <button type="submit" class="login-btn">
                    <i class="bx bx-log-in-circle"></i> {{ labels('panel_labels.sign_in', 'Se connecter') }}
                </button>
            </form>
            <div class="login-footer">
                Copyright &copy; {{ date('Y') }} <a href="{{ route('admin.home') }}">{{ $system_settings['app_name'] }}.</a> {{ labels('panel_labels.all_rights_reserved', 'Tous droits réservés.') }}
            </div>
        </div>
    </div>

    <script src="{{ asset('/assets/admin/js/jquery.min.js') }}"></script>
</body>
</html>
