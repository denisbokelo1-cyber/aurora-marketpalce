@php
    use App\Services\MediaService;
    use App\Services\TranslationService;
    use App\Services\CurrencyService;
    $auroraOrange = '#F57C00';
    $auroraDark = '#e65100';
@endphp
<div id="page-content">
    <x-utility.breadcrumbs.breadcrumbTwo :$bread_crumb />

    <!-- Hero Banner (Aurora style) -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 850px; padding: 30px 20px;">
            <span style="display: inline-block; background: {{ $auroraOrange }}; color: #fff; padding: 5px 16px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">Marketplace</span>
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                NOS <span style="color: {{ $auroraOrange }};">VENDEURS</span>
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 650px; font-size: 1.1rem; line-height: 1.7;">
                Découvrez tous nos vendeurs partenaires et explorez leurs catalogues uniques. Des milliers de produits de qualité vous attendent.
            </p>
            <div class="mt-4">
                <a href="#sellers-grid" class="btn" style="background: {{ $auroraOrange }}; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='{{ $auroraDark }}'" onmouseout="this.style.background='{{ $auroraOrange }}'">Parcourir les vendeurs</a>
            </div>
        </div>
    </div>

    @if (isset($Sellers['listing']) && count($Sellers['listing']) >= 1)
    <div class="container-fluid" style="padding: 30px 0 50px;" id="sellers-grid">
        <div class="row g-4 row-cols-1 row-cols-sm-2 row-cols-md-3 row-cols-lg-4 row-cols-xl-5">
            @foreach ($Sellers['listing'] as $seller)
            <div class="col">
                <a wire:navigate href="{{ customUrl('sellers/' . $seller->slug) }}" style="text-decoration: none; color: inherit; display: block;">
                    <div style="background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; overflow: hidden; height: 100%; box-shadow: 0 2px 8px rgba(0,0,0,0.04); transition: all 0.3s ease; text-align: center;" onmouseover="this.style.transform='translateY(-6px)';this.style.boxShadow='0 16px 40px rgba(0,0,0,0.12)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                        <div style="padding: 28px 20px 16px;">
                            @php
                                $img = app(MediaService::class)->getMediaImageUrl($seller->logo, 'SELLER_IMG_PATH');
                                $img = app(MediaService::class)->dynamic_image($img, 200);
                            @endphp
                            <div style="width: 90px; height: 90px; border-radius: 50%; overflow: hidden; margin: 0 auto 14px; border: 3px solid #f5f5f5; box-shadow: 0 4px 12px rgba(0,0,0,0.08);">
                                <img src="{{ $img }}" alt="{{ $seller->store_name }}" style="width: 100%; height: 100%; object-fit: cover;" loading="lazy">
                            </div>
                            <h5 style="font-size: 15px; font-weight: 700; color: #1a1a2e; margin: 0 0 4px;">{{ $seller->store_name ?? '' }}</h5>
                            <div style="font-size: 12px; color: #f4a51c; margin-bottom: 6px;">
                                @php $rating = $seller->rating ?? 0; $full = floor($rating); $half = $rating - $full >= 0.5; @endphp
                                @for($i=1;$i<=5;$i++)
                                    @if($i <= $full)★@elseif($i == $full+1 && $half)★@else☆@endif
                                @endfor
                                <span style="color: #999; font-size: 11px; margin-left: 4px;">({{ number_format($rating, 1) }})</span>
                            </div>
                            @php
                                $productCount = \App\Models\Product::where('seller_id', $seller->seller_id)->where('status', 1)->count();
                            @endphp
                            <p style="font-size: 12px; color: #888; margin: 0 0 14px;">
                                <strong style="color: {{ $auroraOrange }};">{{ $productCount }}</strong> produits
                            </p>
                            <div style="padding: 0 10px 22px;">
                                <span style="display: inline-block; background: {{ $auroraOrange }}; color: #fff; padding: 9px 24px; border-radius: 6px; font-size: 13px; font-weight: 600; transition: all 0.3s; cursor: pointer;" onmouseover="this.style.background='{{ $auroraDark }}';this.style.boxShadow='0 3px 10px rgba(230,81,0,0.25)'" onmouseout="this.style.background='{{ $auroraOrange }}';this.style.boxShadow='none'">Voir la boutique</span>
                            </div>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
        <div class="d-flex justify-content-center mt-5 pt-3">{!! $Sellers['links'] !!}</div>
    </div>
    @else
    <div class="container-fluid" style="padding: 40px 0;">
        @php $title = labels('front_messages.no_seller_found', 'Aucun vendeur trouvé'); @endphp
        <x-utility.others.not-found :$title />
    </div>
    @endif

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
    </style>
</div>
