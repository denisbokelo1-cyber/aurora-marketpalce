@php
    $showFilter = true;
    if (($routeType == 'category' || $routeType == 'section') && count($products_listing) < 1) {
        $showFilter = false;
    }
    use App\Models\Brand;
    use App\Services\TranslationService;
    use App\Services\StoreService;
    use App\Services\MediaService;
    use App\Services\CurrencyService;
    use App\Models\Category;
    $auroraOrange = '#F57C00';
    $auroraDark = '#e65100';
@endphp
<div id="page-content">
    <!-- Breadcrumbs -->
    <div class="template-product">
        <div class="page-header text-center">
            <div class="container-fluid">
                <div class="row align-items-center">
                    <div class="col-12">
                        <div class="breadcrumbs">
                            <a wire:navigate href="{{ customUrl('/') }}">{{ labels('front_messages.home', 'Home') }}</a>
                            @if (isset($bread_crumb['right_breadcrumb']) && !empty($bread_crumb['right_breadcrumb']))
                                @foreach ($bread_crumb['right_breadcrumb'] as $right_breadcrumb)
                                    <span class="main-title fw-bold"><ion-icon class="align-text-top icon" name="chevron-forward-outline"></ion-icon>{!! $right_breadcrumb !!}</span>
                                @endforeach
                            @endif
                            <span class="main-title fw-bold"><ion-icon class="align-text-top icon" name="chevron-forward-outline"></ion-icon>{!! $bread_crumb['page_main_bread_crumb'] ?? 'Products' !!}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Hero Banner (Offers-style) -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 360px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 820px; padding: 30px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                TOUS NOS <span style="color: {{ $auroraOrange }};">PRODUITS</span>
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 650px; font-size: 1.1rem; line-height: 1.7;">
                @if ($bySearch)
                    {{ count($products_listing) }} résultat(s) pour "{{ $bySearch }}"
                @else
                    Découvrez notre vaste sélection de produits de qualité. Des milliers d'articles à portée de clic.
                @endif
            </p>
            @if (!$bySearch)
            <div class="mt-4">
                <a href="#product-grid" class="btn" style="background: {{ $auroraOrange }}; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='{{ $auroraDark }}'" onmouseout="this.style.background='{{ $auroraOrange }}'">Explorer maintenant</a>
            </div>
            @endif
        </div>
    </div>

    <div class="container-fluid" style="padding: 30px 0 50px;">

        @if (count($sub_categories) >= 1)
            <x-utility.categories.subCategories.subCategoriesSection :$sub_categories :language_code="$language_code" />
        @endif

        @if (count($products_listing) < 1 && count($sub_categories) < 1)
            @php $title = labels('front_messages.no_product_found', 'No Product Found!'); @endphp
            <x-utility.others.not-found :$title />
        @elseif (count($products_listing) >= 1)

            <!-- Mobile Filter Button -->
            <div class="d-lg-none mb-3">
                <button type="button" class="btn w-100" style="background: {{ $auroraOrange }}; color: #fff; border: none; padding: 12px; border-radius: 8px; font-size: 14px; font-weight: 600; transition: background 0.3s;" onmouseover="this.style.background='{{ $auroraDark }}'" onmouseout="this.style.background='{{ $auroraOrange }}'" onclick="document.getElementById('filter-sidebar').classList.toggle('filter-open')">
                    <ion-icon name="options-outline" style="font-size: 18px; margin-right: 6px;"></ion-icon> Filtrer
                </button>
            </div>

            <div class="row g-4">
                <!-- FILTERS SIDEBAR (25%) -->
                @if ($showFilter == true)
                    <div class="col-12 col-lg-3">
                        <div class="filterbar" id="filter-sidebar" style="background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; padding: 22px; box-shadow: 0 2px 12px rgba(0,0,0,0.04); transition: left 0.3s ease;">
                            <div class="d-flex d-lg-none justify-content-end mb-2">
                                <button type="button" onclick="document.getElementById('filter-sidebar').classList.remove('filter-open')" style="background: none; border: none; font-size: 22px; cursor: pointer; color: #333;">✕</button>
                            </div>
                            <div class="d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom: 2px solid #f5f5f5;">
                                <h3 style="font-size: 16px; font-weight: 700; color: #1a1a2e; margin: 0; letter-spacing: 0.3px;">Filtres</h3>
                            </div>

                            <!-- Price Range -->
                            @if ($min_max_price['max_price'] >= 1)
                            <div class="mb-4">
                                <h4 style="font-size: 13px; font-weight: 700; color: #1a1a2e; margin: 0 0 10px 0; text-transform: uppercase; letter-spacing: 0.5px;">Prix</h4>
                                <div id="slider-range" class="mb-3" style="height: 4px; background: #e5e5e5; border-radius: 2px; position: relative;"></div>
                                <div class="d-flex align-items-center justify-content-between gap-2">
                                    <input id="amount" type="text" disabled style="border: none; font-size: 13px; color: #555; width: 100%; background: transparent; padding: 0;" />
                                    <button class="btn btn-sm price-filter-btn" style="background: {{ $auroraOrange }}; color: #fff; border: none; padding: 5px 16px; font-size: 11px; border-radius: 4px; font-weight: 600; cursor: pointer; white-space: nowrap;">OK</button>
                                </div>
                            </div>
                            @endif

                            <!-- Current Category -->
                            @if(isset($selected_category) && $selected_category)
                            <div class="mb-4">
                                <h4 style="font-size: 13px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Catégorie</h4>
                                <p style="font-size: 13px; color: {{ $auroraOrange }}; margin: 0; font-weight: 600;">{{ $selected_category }}</p>
                            </div>
                            @endif

                            <!-- Subcategories -->
                            @if (count($sub_categories) >= 1)
                            <div class="mb-4">
                                <h4 style="font-size: 13px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Sous-catégories</h4>
                                <ul style="list-style: none; padding: 0; margin: 0; max-height: 200px; overflow-y: auto;">
                                    @foreach ($sub_categories as $sub)
                                        <li style="margin-bottom: 3px;">
                                            <a href="{{ customUrl('categories/' . $sub->slug . '/products') }}" wire:navigate style="font-size: 13px; color: #555; text-decoration: none; display: block; padding: 5px 8px; border-radius: 4px; transition: all 0.2s;" onmouseover="this.style.background='#fff5ed';this.style.color='{{ $auroraOrange }}'" onmouseout="this.style.background='transparent';this.style.color='#555'">
                                                {{ app(TranslationService::class)->getDynamicTranslation(Category::class, 'name', $sub->id, $language_code) }}
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            <!-- Brands -->
                            @if ($products_type == 'regular' && count($brands) >= 1)
                            <div class="mb-4">
                                <h4 style="font-size: 13px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Marques</h4>
                                <div style="max-height: 200px; overflow-y: auto;">
                                    @foreach ($brands as $brand)
                                        <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #444; cursor: pointer; padding: 4px 0; transition: color 0.2s;" onmouseover="this.style.color='{{ $auroraOrange }}'" onmouseout="this.style.color='#444'">
                                            <input type="checkbox" value="{{ $brand->slug }}" class="brand" {{ $brand->is_checked ? 'checked' : '' }} style="accent-color: {{ $auroraOrange }}; width: 15px; height: 15px; margin: 0;">
                                            <span>{{ app(TranslationService::class)->getDynamicTranslation(Brand::class, 'name', $brand->id, $language_code) }}</span>
                                        </label>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Availability -->
                            <div class="mb-4">
                                <h4 style="font-size: 13px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Disponibilité</h4>
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #444; cursor: pointer; padding: 4px 0;">
                                    <input type="radio" name="availability" value="in-stock" style="accent-color: {{ $auroraOrange }}; width: 15px; height: 15px; margin: 0;"> En stock
                                </label>
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #444; cursor: pointer; padding: 4px 0;">
                                    <input type="radio" name="availability" value="out-of-stock" style="accent-color: {{ $auroraOrange }}; width: 15px; height: 15px; margin: 0;"> Rupture
                                </label>
                            </div>

                            <!-- Promotions -->
                            <div class="mb-4">
                                <h4 style="font-size: 13px; font-weight: 700; color: #1a1a2e; margin: 0 0 8px 0; text-transform: uppercase; letter-spacing: 0.5px;">Promotions</h4>
                                <label style="display: flex; align-items: center; gap: 8px; font-size: 13px; color: #444; cursor: pointer; padding: 4px 0;">
                                    <input type="checkbox" style="accent-color: {{ $auroraOrange }}; width: 15px; height: 15px; margin: 0;"> En promotion
                                </label>
                            </div>

                            <!-- Actions -->
                            <div class="d-flex gap-3 mt-4 pt-4" style="border-top: 2px solid #f5f5f5;">
                                <button class="btn btn-sm product-filter-btn" style="flex: 1; background: {{ $auroraOrange }}; color: #fff; border: none; padding: 10px; font-size: 12px; font-weight: 600; border-radius: 6px; cursor: pointer; transition: all 0.3s;" onmouseover="this.style.background='{{ $auroraDark }}'" onmouseout="this.style.background='{{ $auroraOrange }}'">Appliquer</button>
                                <a wire:navigate href="{{ customUrl(url()->current()) }}" class="btn btn-sm" style="flex: 1; background: #f5f5f5; color: #555; border: none; padding: 10px; font-size: 12px; font-weight: 500; border-radius: 6px; text-align: center; text-decoration: none; transition: all 0.3s;" onmouseover="this.style.background='#eee'" onmouseout="this.style.background='#f5f5f5'">Réinitialiser</a>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- PRODUCTS COLUMN (75%) -->
                <div class="col-12 {{ $showFilter == true ? 'col-lg-9' : '' }} main-col" id="product-grid">

                    <!-- Toolbar -->
                    <div class="toolbar toolbar-wrapper shop-toolbar mb-4" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0; padding: 14px 20px; box-shadow: 0 1px 6px rgba(0,0,0,0.03);">
                        <div class="row align-items-center">
                            <div class="col-4 col-sm-2 col-md-4 col-lg-4 text-left filters-toolbar-item d-flex order-1 order-sm-0">
                                <button type="button" class="p-0 btn icon anm anm-sliders-hr d-inline-flex d-lg-none me-2" onclick="document.getElementById('filter-sidebar').classList.toggle('filter-open')" style="background: none; border: none; color: #555;">
                                    <ion-icon class="btn-filter icon fs-5" name="options-outline"></ion-icon>
                                </button>
                                <div class="filters-item d-flex align-items-center">
                                    <label class="mb-0 me-2 d-none d-lg-inline-block" style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Vue :</label>
                                    <div class="grid-options view-mode d-flex">
                                        <a class="list_view icon-mode mode-list d-block {{ $view_mode == 'list' ? 'active' : '' }}" data-col="1" data-value="list" style="border-color: {{ $view_mode == 'list' ? $auroraOrange : '#ccc' }};"></a>
                                        <a class="icon-mode mode-grid grid-2 d-block" data-col="2"></a>
                                        <a class="icon-mode mode-grid grid-3 d-md-block" data-col="3"></a>
                                        <a class="icon-mode mode-grid grid-4 d-lg-block {{ $view_mode == 'list' ? '' : 'active' }}" data-col="4" style="border-color: {{ $view_mode != 'list' ? $auroraOrange : '#ccc' }};"></a>
                                    </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-4 col-md-4 col-lg-4 text-center product-count order-0 order-md-1 mb-3 mb-sm-0">
                                <span class="toolbar-product-count" style="font-size: 13px; color: #888;">
                                    <strong style="color: #1a1a2e;">{{ count($products_listing) }}</strong> résultats sur <strong style="color: #1a1a2e;">{{ $total_products }}</strong>
                                </span>
                            </div>
                            <div class="col-8 col-sm-6 col-md-4 col-lg-4 text-right filters-toolbar-item d-flex justify-content-end order-2 order-sm-2">
                                <div class="filters-item d-flex align-items-center ms-2 ms-lg-3">
                                    <label class="mb-0 me-2 d-none d-md-inline-block" style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Afficher :</label>
                                    <select name="perPage" id="perPage" class="filters-toolbar-perPage me-2" style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 6px 10px; font-size: 12px; color: #555; background: #fafafa; cursor: pointer;">
                                        <option value="12" {{ ($perPage ?? 20) == 12 ? 'selected' : '' }}>12</option>
                                        <option value="16" {{ ($perPage ?? 20) == 16 ? 'selected' : '' }}>16</option>
                                        <option value="20" {{ ($perPage ?? 20) == 20 ? 'selected' : '' }}>20</option>
                                        <option value="24" {{ ($perPage ?? 20) == 24 ? 'selected' : '' }}>24</option>
                                    </select>
                                    <label class="mb-0 me-2 d-none d-md-inline-block" style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap;">Trier :</label>
                                    <select name="SortBy" id="SortBy" style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 6px 10px; font-size: 12px; color: #555; background: #fafafa; cursor: pointer;">
                                        <option value="" {{ $sorted_by == '' ? 'selected' : '' }}>En vedette</option>
                                        <option value="top-rated" {{ $sorted_by == 'top-rated' ? 'selected' : '' }}>Mieux notés</option>
                                        <option value="price-asc" {{ $sorted_by == 'price-asc' ? 'selected' : '' }}>Prix ↑</option>
                                        <option value="price-desc" {{ $sorted_by == 'price-desc' ? 'selected' : '' }}>Prix ↓</option>
                                        <option value="latest-products" {{ $sorted_by == 'latest-products' ? 'selected' : '' }}>Plus récent</option>
                                    </select>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Product Grid -->
                    @php $store_settings = app(StoreService::class)->getStoreSettings(); @endphp
                    <div class="grid-products grid-view-items mb-4">
                        <div class="row g-3 product-options {{ ($store_settings['products_display_style_for_web'] ?? '') == 'products_display_style_for_web_3' ? 'pro-hover3' : '' }} {{ $view_mode == 'list' ? 'list-style' : 'row-cols-lg-4 row-cols-md-3 row-cols-sm-3 row-cols-2' }}" style="margin-top: 0;">
                            @foreach ($products_listing as $details)
                                @php
                                    $store_settings = app(StoreService::class)->getStoreSettings();
                                    $component = getProductDisplayComponent($store_settings);
                                    $details = (object) $details;
                                @endphp
                                <div wire:ignore.self class="col" style="padding-top: 12px;">
                                    <div wire:key="product-{{ $details->id }}" class="aurora-product-card" style="background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; overflow: hidden; height: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                                        <x-dynamic-component :component="$component" :details="$details" />
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4 pt-3">
                        {!! $links !!}
                    </div>
                </div>
            </div>
        @endif
    </div>

    <input type="hidden" name="min-price" id="min-price" value="{{ app(CurrencyService::class)->currentCurrencyPrice($min_max_price['min_price']) }}">
    <input type="hidden" name="max-price" id="max-price" value="{{ app(CurrencyService::class)->currentCurrencyPrice($min_max_price['max_price']) }}">
    <input type="hidden" name="selected_max_price" id="selected_max_price" value="{{ app(CurrencyService::class)->currentCurrencyPrice($min_max_price['selected_max_price']) }}">
    <input type="hidden" name="selected_min_price" id="selected_min_price" value="{{ app(CurrencyService::class)->currentCurrencyPrice($min_max_price['selected_min_price']) }}">

    <style>
    /* Aurora product listing styles */
    .aurora-product-card .product-box { border: none !important; background: transparent !important; }
    .aurora-product-card .product-image { margin: 0 !important; border-radius: 12px 12px 0 0; overflow: hidden; }
    .aurora-product-card .product-details { padding: 14px; }
    .aurora-product-card .product-labels .lbl { background: {{ $auroraOrange }} !important; color: #fff; border-radius: 4px; font-size: 10px; font-weight: 700; padding: 3px 10px; text-transform: uppercase; }
    .aurora-product-card .product-labels .lbl.pr-label3 { background: {{ $auroraOrange }} !important; }
    .aurora-product-card .product-labels .lbl.pr-label4 { background: {{ $auroraDark }} !important; }
    .aurora-product-card .button-set .btn-icon:hover { background: {{ $auroraOrange }} !important; color: #fff !important; }
    .aurora-product-card .button-action .btn { background: {{ $auroraOrange }}; color: #fff; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; padding: 9px 14px; transition: all 0.3s; }
    .aurora-product-card .button-action .btn:hover { background: {{ $auroraDark }}; box-shadow: 0 3px 10px rgba(230,81,0,0.25); }
    .aurora-product-card .product-price .price { color: {{ $auroraOrange }}; font-weight: 700; }
    .aurora-product-card .product-price .old-price { color: #999; text-decoration: line-through; font-weight: 400; }
    .aurora-product-card .product-vendor { color: #999; font-size: 11px; text-transform: uppercase; letter-spacing: 0.3px; }
    .aurora-product-card .product-name a { color: #1a1a2e; font-size: 14px; font-weight: 600; }
    .aurora-product-card .product-review .icon { color: #f4a51c; }

    /* Filter sidebar mobile */
    @media (max-width: 991px) {
        #filter-sidebar {
            position: fixed !important;
            top: 0; left: -100%; width: 85%; max-width: 340px; height: 100vh;
            background: #fff; z-index: 9999;
            transition: left 0.3s ease;
            overflow-y: auto;
            box-shadow: 0 0 40px rgba(0,0,0,0.2);
            border-radius: 0 12px 12px 0 !important;
        }
        #filter-sidebar.filter-open { left: 0; }
        .aurora-product-card { margin-bottom: 0; }
    }

    /* Pagination Aurora style */
    .pagination .page-item .page-link {
        border-radius: 6px !important;
        margin: 0 3px;
        font-size: 13px;
        font-weight: 600;
        color: #555;
        border: 1px solid #eee;
        background: #fff;
        padding: 8px 14px;
        transition: all 0.2s;
    }
    .pagination .page-item.active .page-link,
    .pagination .page-item .page-link:hover {
        background: {{ $auroraOrange }} !important;
        color: #fff !important;
        border-color: {{ $auroraOrange }} !important;
    }

    /* View mode icons Aurora */
    .view-mode .icon-mode.active { border-color: {{ $auroraOrange }} !important; }
    .view-mode .icon-mode.active:before { background-color: {{ $auroraOrange }} !important; }
    .view-mode .icon-mode.active.mode-list:before { box-shadow: 0 7px 0 {{ $auroraOrange }}, 0 14px 0 {{ $auroraOrange }} !important; }
    .view-mode .icon-mode.active.grid-2:before { box-shadow: 7px 0 0 {{ $auroraOrange }} !important; }
    .view-mode .icon-mode.active.grid-3:before { box-shadow: 7px 0 0 {{ $auroraOrange }}, 14px 0 0 {{ $auroraOrange }} !important; }
    .view-mode .icon-mode.active.grid-4:before { box-shadow: 7px 0 0 {{ $auroraOrange }}, 14px 0 0 {{ $auroraOrange }}, 21px 0 0 {{ $auroraOrange }} !important; }
    </style>
</div>
