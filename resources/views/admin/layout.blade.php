<!DOCTYPE html>
<html lang="fr" class="aurora">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/aurora-logo.svg') }}">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <title>@yield('title') | Aurora Marketplace</title>
    <link rel="stylesheet" href="{{ asset('assets/boxicons/css/boxicons.min.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/admin/custom/aurora.css') }}">
    @php
        try {
            $system_settings = app(\App\Services\SettingService::class)->getSettings('system_settings', true);
            if (is_string($system_settings)) {
                $system_settings = json_decode($system_settings, true) ?? [];
            }
        } catch (\Exception $e) {
            $system_settings = [];
        }
    @endphp
    @include('admin.include_css')
    @stack('styles')
    <style>
        #db-wrapper { display: flex; min-height: 100vh; }
        #page-content {
            margin-left: var(--aurora-sidebar-width);
            margin-top: var(--aurora-header-height);
            flex: 1; min-width: 0;
            display: flex; flex-direction: column;
            transition: margin-left 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }
        .container-fluid {
            flex: 1;
            padding: 20px 28px !important;
            margin-top: 0 !important;
            width: 100%;
            max-width: 100%;
        }
        .card { border-radius: var(--aurora-radius); border: 1px solid var(--aurora-border); box-shadow: var(--aurora-shadow-sm); }
        .card:hover { box-shadow: var(--aurora-shadow); }
        .btn-primary { background: var(--aurora-primary); border-color: var(--aurora-primary); }
        .btn-primary:hover { background: var(--aurora-primary-dark); border-color: var(--aurora-primary-dark); }
        .form-control, .form-select { border-radius: var(--aurora-radius-sm); border-color: var(--aurora-border); }
        .form-control:focus, .form-select:focus { border-color: var(--aurora-primary); box-shadow: 0 0 0 3px rgba(249,115,22,0.12); }
        .form-check-input:checked { background-color: var(--aurora-primary); border-color: var(--aurora-primary); }
        a { color: var(--aurora-primary); }
        .nav-tabs .nav-link.active { color: var(--aurora-primary); border-bottom-color: var(--aurora-primary); }
        @media (max-width: 1023px) {
            #page-content { margin-left: 0; }
            .container-fluid { padding: 16px !important; }
        }
    </style>
</head>
<body class="aurora">
    <div id="db-wrapper">
        <x-admin.side-bar />
        <div id="page-content">
            <x-admin.header />
            <div class="container-fluid" {{ session()->get('is_rtl') == 1 ? 'dir=rtl' : '' }}>
                @yield('content')
            </div>
        </div>
    </div>
    <x-admin.footer />
</body>
@include('admin.include_script')
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Sidebar toggle (hamburger button)
    const toggleBtn = document.getElementById('auroraToggleSidebar');
    const sidebar = document.querySelector('.aurora-sidebar');
    const pageContent = document.getElementById('page-content');
    if (toggleBtn && sidebar) {
        let collapsed = localStorage.getItem('aurora_sidebar_collapsed') === 'true';
        function applyState(c) {
            sidebar.style.transform = c ? 'translateX(-100%)' : '';
            sidebar.style.position = c ? 'fixed' : '';
            if (pageContent) pageContent.style.marginLeft = c ? '0' : '';
            localStorage.setItem('aurora_sidebar_collapsed', String(c));
        }
        applyState(collapsed);
        toggleBtn.addEventListener('click', function(e) {
            e.preventDefault();
            collapsed = !collapsed;
            applyState(collapsed);
        });
    }
    // Submenu toggle
    document.querySelectorAll('.aurora-sidebar-item.has-sub').forEach(function(item) {
        item.addEventListener('click', function(e) {
            e.preventDefault();
            const target = document.getElementById(this.dataset.target);
            if (target) {
                target.classList.toggle('open');
                const arrow = this.querySelector('.arrow');
                if (arrow) arrow.classList.toggle('rotate');
            }
        });
    });
    // Search filter
    const searchInput = document.getElementById('menuSearch');
    if (searchInput) {
        searchInput.addEventListener('keyup', function() {
            const filter = this.value.toLowerCase();
            document.querySelectorAll('.aurora-sidebar-item').forEach(function(item) {
                const text = item.textContent.toLowerCase();
                item.style.display = text.includes(filter) ? '' : 'none';
            });
            document.querySelectorAll('.aurora-sidebar-section').forEach(function(s) {
                let el = s.nextElementSibling;
                let visible = false;
                while (el && !el.classList.contains('aurora-sidebar-section')) {
                    if (el.classList.contains('aurora-sidebar-item') && el.style.display !== 'none') visible = true;
                    el = el.nextElementSibling;
                }
                s.style.display = visible ? '' : 'none';
            });
        });
    }
});
</script>
</html>
