<!-- Aurora Header -->
<div class="aurora-header">
    @php
        use App\Models\Store;
        use Illuminate\Support\Facades\Auth;
        use Illuminate\Support\Str;
        use App\Services\TranslationService;
        use App\Services\StoreService;
        use App\Services\MediaService;
        use App\Services\SettingService;
        $language_code = app(TranslationService::class)->getLanguageCode();
        $user = Auth::user();
        $settings = app(SettingService::class)->getSettings('admin_preference', true);
        if (is_string($settings)) { $settings = json_decode($settings); }
        $isPublicDisk = $user->disk == 'public' ? 1 : 0;
        $user_image = $isPublicDisk
            ? (!empty($user->image) && file_exists(public_path(config('constants.USER_IMG_PATH') . $user->image))
                ? app(MediaService::class)->getMediaImageUrl($user->image, 'USER_IMG_PATH')
                : app(MediaService::class)->getImageUrl('no-user-img.jpeg', '', '', 'image', 'NO_USER_IMAGE'))
            : $user->image;
        $store_details = fetchDetails(Store::class, ['status' => 1], '*');
        $store_count = count($store_details);
        $default_store_id = '';
        $stores = Store::where('is_default_store', 1)->where('status', 1)->get();
        if ($stores->isNotEmpty()) {
            $default_store_id = $stores[0]->id;
            $default_store_name = app(TranslationService::class)->getDynamicTranslation(Store::class, 'name', $stores[0]->id, $language_code);
            $isPublicDisk = $stores[0]->disk == 'public' ? 1 : 0;
            $default_store_image = $isPublicDisk ? asset(config('constants.STORE_IMG_PATH') . $stores[0]->image) : $stores[0]->image;
        } else {
            $default_store_id = ''; $default_store_name = ''; $default_store_image = '';
        }
        if (session('store_id') !== null && !empty(session('store_id'))) {
            $store_id = session('store_id');
        } else {
            $store_id = $default_store_id;
            session(['store_id' => $default_store_id]);
            session(['store_name' => $default_store_name]);
            session(['store_image' => $default_store_image]);
        }
        $store_name = session('store_name') !== null && !empty(session('store_name')) ? session('store_name') : '';
        if (!empty($stores) && isset($stores[0])) { $isPublicDisk = $stores[0]->disk == 'public' ? 1 : 0; } else { $isPublicDisk = 0; }
        $image = $isPublicDisk ? asset(config('constants.STORE_IMG_PATH') . session('store_image')) : session('store_image');
        $store_image = session('store_image') !== null && !empty(session('store_image')) ? $image : '';
        use App\Models\Language;
        $languages = Language::all();
    @endphp

    <!-- Left: Toggle + Store -->
    <div class="aurora-header-left">
        <button class="aurora-header-toggle" id="auroraToggleSidebar" aria-label="Toggle sidebar">
            <i class='bx bx-menu'></i>
        </button>
        @if ($store_count > 1 && optional($settings)->store_mode != 'single')
            <div class="aurora-header-store dropdown">
                <div class="aurora-header-store-trigger" data-bs-toggle="dropdown">
                    <div class="aurora-header-store-info">
                        <div class="aurora-header-store-avatar">
                            <img src="{{ app(MediaService::class)->getMediaImageUrl($store_image, 'STORE_IMG_PATH') }}" alt="">
                        </div>
                        <span class="aurora-header-store-name">{{ app(TranslationService::class)->getDynamicTranslation(Store::class, 'name', $store_id, $language_code) }}</span>
                    </div>
                    <i class='bx bx-chevron-down'></i>
                </div>
                <div class="dropdown-menu">
                    @forelse($store_details as $store)
                        <a class="dropdown-item store-switch" data-store-id="{{ $store->id }}" href="#">
                            <img src="{{ route('admin.dynamic_image', ['url' => app(MediaService::class)->getMediaImageUrl($store->image, 'STORE_IMG_PATH'), 'width' => 40, 'quality' => 90]) }}" alt="">
                            <span>{{ Str::limit(app(TranslationService::class)->getDynamicTranslation(Store::class, 'name', $store->id, $language_code), 15) }}</span>
                        </a>
                    @empty
                        <a class="dropdown-item disabled" href="#">{{ labels('admin_labels.no_stores', 'No Stores') }}</a>
                    @endforelse
                </div>
            </div>
        @else
            <div class="aurora-header-store">
                <div class="aurora-header-store-info">
                    <div class="aurora-header-store-avatar">
                        <img src="{{ app(MediaService::class)->getMediaImageUrl($store_image, 'STORE_IMG_PATH') }}" alt="">
                    </div>
                    <span class="aurora-header-store-name">{{ app(TranslationService::class)->getDynamicTranslation(Store::class, 'name', $store_id, $language_code) }}</span>
                </div>
            </div>
        @endif
    </div>

    <!-- Right: Language + Profile -->
    <div class="aurora-header-right">
        @php
            $lc = session()->get('locale') ?? 'en';
            $selected_language = fetchDetails(Language::class, ['code' => $lc], 'language');
            $selected_language = !$selected_language->isEmpty() ? $selected_language[0]->language : 'English';
        @endphp

        <!-- Language -->
        <div class="dropdown aurora-header-btn-wrap">
            <button class="aurora-header-btn" data-bs-toggle="dropdown">
                <i class='bx bx-globe'></i>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                @foreach ($languages as $language)
                    <a class="dropdown-item changeLang" data-lang-code="{{ $language->code }}" href="#">
                        {{ ucwords($language->language) }} - {{ strtoupper($language->code) }}
                    </a>
                @endforeach
            </div>
        </div>

        @if (!empty($selected_language))
            <span class="aurora-header-badge">{{ $selected_language }}</span>
        @endif

        <!-- Profile -->
        <div class="dropdown">
            <button class="aurora-header-profile" data-bs-toggle="dropdown">
                <img src="{{ app(MediaService::class)->getMediaImageUrl($user_image) }}" alt="{{ $user->username }}">
                <div class="info">
                    <div class="name">{{ $user->username }}</div>
                    <div class="role">Admin</div>
                </div>
            </button>
            <div class="dropdown-menu dropdown-menu-end">
                <a class="dropdown-item" href="/admin/account/{{ auth()->user()->id }}">
                    <i class='bx bx-user-circle'></i>
                    <span>{{ labels('admin_labels.profile', 'Profile') }}</span>
                </a>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item text-danger" href="{{ route('admin.logout') }}">
                    <i class='bx bx-log-in-circle'></i>
                    <span>{{ labels('admin_labels.logout', 'Logout') }}</span>
                </a>
            </div>
        </div>
    </div>
</div>

@php
    $store_id_h = app(StoreService::class)->getStoreId();
    $store_details_h = fetchDetails(Store::class, ['id' => $store_id_h], ['primary_color', 'secondary_color', 'hover_color', 'active_color']);
    $primary_colour = $store_details_h[0]->primary_color ?? '#B52046';
    $secondary_color = $store_details_h[0]->secondary_color ?? '#201A1A';
    $hover_color = $store_details_h[0]->hover_color ?? '#911A38';
    $active_color = $store_details_h[0]->active_color ?? '#6D132A';
    $background_opacity_color = $primary_colour . '10';
@endphp
<style>
    * { --primary-theme-color: <?=$primary_colour ?>; --background_opacity_color: <?=$background_opacity_color ?>; --secondary-theme-color: <?=$secondary_color ?>; --hover-color: <?=$hover_color ?>; --active-color: <?=$active_color ?>; }
</style>
