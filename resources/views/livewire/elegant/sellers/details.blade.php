@php
    use App\Services\MediaService;
    use App\Services\TranslationService;
    use App\Services\CurrencyService;
    use App\Services\StoreService;
    $auroraOrange = '#F57C00';
    $auroraDark = '#e65100';
    $img = app(MediaService::class)->getMediaImageUrl($seller[0]->logo, 'SELLER_IMG_PATH');
    $img = app(MediaService::class)->dynamic_image($img, 230);
    $totalProducts = \App\Models\Product::where('seller_id', $seller[0]->seller_id)->where('status', 1)->count();
@endphp
<div id="page-content">
    <x-utility.breadcrumbs.breadcrumbTwo :$bread_crumb />

    <!-- Seller Hero Banner -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 850px; padding: 30px 20px;">
            <div style="width: 100px; height: 100px; border-radius: 50%; overflow: hidden; margin: 0 auto 16px; border: 4px solid #fff; box-shadow: 0 6px 20px rgba(0,0,0,0.1);">
                <img src="{{ $img }}" alt="{{ $seller[0]->store_name }}" style="width: 100%; height: 100%; object-fit: cover;">
            </div>
            <h1 class="display-5 fw-bold mb-2" style="color: #1a1a2e;">
                {{ $seller[0]->store_name ?? '' }}
            </h1>
            <div style="font-size: 14px; color: #f4a51c; margin-bottom: 8px;">
                @php $rating = $seller[0]->rating ?? 0; $full = floor($rating); $half = $rating - $full >= 0.5; @endphp
                @for($i=1;$i<=5;$i++)
                    @if($i <= $full)★@elseif($i == $full+1 && $half)★@else☆@endif
                @endfor
                <span style="color: #999; font-size: 12px; margin-left: 4px;">({{ number_format($rating, 1) }})</span>
            </div>
            <p class="text-muted mx-auto" style="max-width: 600px; font-size: 0.95rem; line-height: 1.6;">
                @if(!empty($seller[0]->store_description))
                    {{ $seller[0]->store_description }}
                @else
                    Boutique officielle {{ $seller[0]->store_name }} sur Aurora Marketplace.
                @endif
            </p>
            <div style="margin-top: 10px;">
                <span style="display: inline-block; background: #fff; border: 2px solid {{ $auroraOrange }}; color: {{ $auroraOrange }}; padding: 6px 20px; border-radius: 20px; font-size: 13px; font-weight: 600;">
                    <strong>{{ $totalProducts }}</strong> produits
                </span>
            </div>
        </div>
    </div>

    <!-- Products Section -->
    <div class="container-fluid" style="padding: 30px 0 50px;">
        @if (isset($products['product']) && count($products['product']) >= 1)
            <!-- Toolbar -->
            <div class="toolbar toolbar-wrapper shop-toolbar mb-4" style="background: #fff; border-radius: 10px; border: 1px solid #f0f0f0; padding: 14px 20px; box-shadow: 0 1px 6px rgba(0,0,0,0.03);">
                <div class="row align-items-center">
                    <div class="col-12 col-md-4 text-center text-md-start mb-2 mb-md-0">
                        <span style="font-size: 13px; color: #888;">
                            <strong style="color: #1a1a2e;">{{ count($products['product']) }}</strong> produits sur <strong style="color: #1a1a2e;">{{ $totalProducts }}</strong>
                        </span>
                    </div>
                    <div class="col-6 col-md-4 text-center mb-2 mb-md-0">
                        <div class="d-flex align-items-center justify-content-center gap-2">
                            <label style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; margin: 0;">Afficher :</label>
                            <select name="perPage" style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 6px 10px; font-size: 12px; color: #555; background: #fafafa; cursor: pointer;">
                                <option value="12" selected>12</option>
                                <option value="24">24</option>
                                <option value="36">36</option>
                                <option value="48">48</option>
                            </select>
                        </div>
                    </div>
                    <div class="col-6 col-md-4 text-center text-md-end">
                        <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-2">
                            <label style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px; white-space: nowrap; margin: 0;">Trier :</label>
                            <select name="SortBy" style="border: 1px solid #e0e0e0; border-radius: 6px; padding: 6px 10px; font-size: 12px; color: #555; background: #fafafa; cursor: pointer;">
                                <option value="">En vedette</option>
                                <option value="price-asc">Prix ↑</option>
                                <option value="price-desc">Prix ↓</option>
                                <option value="latest-products">Nouveautés</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product Grid -->
            @php $store_settings = app(StoreService::class)->getStoreSettings(); @endphp
            <div class="grid-products grid-view-items" style="margin-top: 0;">
                <div class="row g-3 product-options {{ ($store_settings['products_display_style_for_web'] ?? '') == 'products_display_style_for_web_3' ? 'pro-hover3' : '' }} row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-4 row-cols-xl-5">
                    @foreach ($products['product'] as $details)
                        @php
                            $details = (object) $details;
                            $component = getProductDisplayComponent($store_settings);
                        @endphp
                        <div class="col" style="padding-top: 12px;">
                            <div wire:key="seller-prod-{{ $details->id }}" style="background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; overflow: hidden; height: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.3s ease;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                                <x-dynamic-component :component="$component" :details="$details" />
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-5 pt-3">{!! $products['links'] !!}</div>
        @else
            @php $title = labels('front_messages.seller_dont_have_any_products', 'Ce vendeur ne propose pas encore de produits'); @endphp
            <x-utility.others.not-found :$title />
        @endif
    </div>

    <style>
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
    /* Product card Aurora overrides */
    .aurora-product-card .product-box { border: none !important; background: transparent !important; }
    .aurora-product-card .product-image { margin: 0 !important; border-radius: 12px 12px 0 0; overflow: hidden; }
    .aurora-product-card .product-details { padding: 14px; }
    .aurora-product-card .product-labels .lbl { background: {{ $auroraOrange }} !important; color: #fff; border-radius: 4px; font-size: 10px; font-weight: 700; padding: 3px 10px; text-transform: uppercase; }
    .aurora-product-card .product-price .price { color: {{ $auroraOrange }}; font-weight: 700; }
    .aurora-product-card .product-price .old-price { color: #999; text-decoration: line-through; font-weight: 400; }
    .aurora-product-card .button-action .btn { background: {{ $auroraOrange }}; color: #fff; border: none; border-radius: 6px; font-size: 12px; font-weight: 600; padding: 9px 14px; transition: all 0.3s; }
    .aurora-product-card .button-action .btn:hover { background: {{ $auroraDark }}; box-shadow: 0 3px 10px rgba(230,81,0,0.25); }
    .aurora-product-card .product-name a { color: #1a1a2e; font-size: 14px; font-weight: 600; }
    .aurora-product-card .product-review .icon { color: #f4a51c; }
    </style>
</div>
