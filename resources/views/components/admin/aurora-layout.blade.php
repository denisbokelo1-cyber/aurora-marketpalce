<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/aurora-logo.svg') }}">
    <title>@yield('title', 'Dashboard') | Aurora Marketplace</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    
    <!-- Boxicons -->
    <link rel="stylesheet" href="{{ asset('assets/boxicons/css/boxicons.min.css') }}">

    <!-- Aurora Theme CSS -->
    <link rel="stylesheet" href="{{ asset('assets/admin/custom/aurora.css') }}">

    <!-- Legacy CSS (for backward compat with existing pages) -->
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
</head>
<body class="aurora">
    <div class="aurora-wrapper" x-data="{ sidebarOpen: false }">
        <!-- Mobile overlay -->
        <div class="aurora-overlay" :class="{ 'show': sidebarOpen }" @click="sidebarOpen = false"></div>

        <!-- Sidebar -->
        @include('components.admin.side-bar')

        <!-- Main area -->
        <div id="page-content" style="flex: 1; min-width: 0; display: flex; flex-direction: column;">
            <!-- Header -->
            @include('components.admin.header')

            <!-- Content -->
            <main class="aurora-main">
                @yield('content')
            </main>
        </div>
    </div>

    <!-- Toast Notifications -->
    @include('components.admin.toast')

    <!-- Scripts -->
    <script src="{{ asset('assets/admin/js/jquery.min.js') }}"></script>
    
    <!-- Alpine.js for reactivity -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    
    <!-- ApexCharts -->
    <script src="{{ asset('assets/js/plugins/apexcharts.js') }}"></script>

    @include('admin.include_script')
    
    @stack('scripts')

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Sidebar submenu toggle
            document.querySelectorAll('.aurora-sidebar-item.has-submenu').forEach(function(item) {
                item.addEventListener('click', function(e) {
                    e.preventDefault();
                    var submenu = this.nextElementSibling;
                    var arrow = this.querySelector('.arrow');
                    if (submenu && submenu.classList.contains('aurora-sidebar-submenu')) {
                        submenu.classList.toggle('open');
                        if (arrow) arrow.classList.toggle('open');
                    }
                });
            });
        });
    </script>
</body>
</html>
