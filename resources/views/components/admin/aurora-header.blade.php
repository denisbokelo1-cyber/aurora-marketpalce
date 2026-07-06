@php
    use App\Services\MediaService;
    use App\Services\SettingService;
    $user = auth()->user();
    $settings = app(SettingService::class)->getSettings('admin_preference', true);
    if (is_string($settings)) $settings = json_decode($settings);
    
    // Build user image URL
    $user_image = asset(config('constants.NO_IMAGE'));
    if ($user && !empty($user->image)) {
        if ($user->disk == 's3') {
            $user_image = $user->image;
        } else {
            $imgPath = public_path(config('constants.USER_IMG_PATH') . '/' . $user->image);
            if (file_exists($imgPath)) {
                $user_image = asset(config('constants.USER_IMG_PATH') . '/' . $user->image);
            }
        }
    }
@endphp
@push('header')
<header class="aurora-header">
    <div class="aurora-header-left">
        <button class="aurora-header-toggle" @click="sidebarOpen = !sidebarOpen">
            <i class='bx bx-menu'></i>
        </button>
        <div class="aurora-header-search">
            <i class='bx bx-search'></i>
            <input type="text" placeholder="{{ labels('admin_labels.search', 'Rechercher...') }}">
        </div>
    </div>
    <div class="aurora-header-right">
        <button class="aurora-header-btn" title="{{ labels('admin_labels.notifications', 'Notifications') }}">
            <i class='bx bx-bell'></i>
            <span class="dot" style="background: var(--aurora-danger);"></span>
        </button>
        <button class="aurora-header-btn" title="{{ labels('admin_labels.messages', 'Messages') }}">
            <i class='bx bx-message-dots'></i>
            <span class="dot" style="background: var(--aurora-primary);"></span>
        </button>
        <div class="aurora-header-profile" onclick="document.getElementById('profileDropdown').classList.toggle('show')">
            <img src="{{ $user_image }}" alt="{{ $user->username }}">
            <div class="info d-none d-sm-block">
                <div class="name">{{ $user->username }}</div>
                <div class="role">{{ labels('admin_labels.administrator', 'Administrateur') }}</div>
            </div>
            <i class='bx bx-chevron-down' style="font-size:16px;color:var(--aurora-text-muted);"></i>
        </div>
    </div>
</header>
<!-- Dropdown profil -->
<div id="profileDropdown" class="aurora-dropdown" style="display:none;position:fixed;top:60px;right:24px;background:#fff;border-radius:10px;box-shadow:var(--aurora-shadow-lg);border:1px solid var(--aurora-border);z-index:600;min-width:180px;padding:8px;">
    <a href="/admin/account/{{ auth()->user()->id }}" style="display:flex;align-items:center;gap:10px;padding:8px 14px;border-radius:8px;color:var(--aurora-text);text-decoration:none;font-size:14px;">
        <i class='bx bx-user-circle'></i> {{ labels('admin_labels.profile', 'Profile') }}
    </a>
    <a href="{{ route('admin.logout') }}" style="display:flex;align-items:center;gap:10px;padding:8px 14px;border-radius:8px;color:var(--aurora-text);text-decoration:none;font-size:14px;">
        <i class='bx bx-log-in-circle'></i> {{ labels('admin_labels.logout', 'Déconnexion') }}
    </a>
</div>
<script>
    document.addEventListener('click', function(e) {
        var dd = document.getElementById('profileDropdown');
        if (dd && !e.target.closest('.aurora-header-profile') && !e.target.closest('#profileDropdown')) {
            dd.style.display = 'none';
        }
    });
    document.querySelector('.aurora-header-profile')?.addEventListener('click', function(e) {
        e.stopPropagation();
        var dd = document.getElementById('profileDropdown');
        dd.style.display = dd.style.display === 'none' ? 'block' : 'none';
    });
</script>
@endpush
