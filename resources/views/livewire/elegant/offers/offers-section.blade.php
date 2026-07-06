@php
    use App\Services\TranslationService;
    $language_code = app(TranslationService::class)->getLanguageCode();
    $primaryColor = '#e65100';
    $primaryHover = '#d84315';
@endphp
<div id="page-content" style="background: #fafafa;">
    <x-utility.breadcrumbs.breadcrumbTwo :$bread_crumb />

    <!-- Hero -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%);">
        <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
            ACHETEZ EN LIGNE ET PROFITEZ DE NOS OFFRES EXCEPTIONNELLES
        </h1>
        <p class="lead text-muted mx-auto" style="max-width: 600px;">
            Des réductions incroyables sur une sélection de produits de qualité. Ne manquez pas ces offres limitées !
        </p>
    </div>

    @if (isset($singleOffers) && count($singleOffers) >= 1)
        <div class="container-fluid py-4">
            <div class="row g-4 row-cols-1 row-cols-md-2 row-cols-lg-3">
                @foreach ($singleOffers as $offer)
                    @php
                        $offerTitle = app(TranslationService::class)->getDynamicTranslation(\App\Models\Offer::class, 'title', $offer->id, $language_code);
                        $imgUrl = !empty($offer->banner_image) ? $offer->banner_image : '';
                        $offerUrl = !empty($offer->link) ? $offer->link : customUrl('products');
                        $badge = '';
                        if (!in_array($offer->type, ['default','products','combo_products','offer_url'])) {
                            $badge = "{$offer->min_discount}%-{$offer->max_discount}%";
                        }
                    @endphp
                    <div class="col">
                        <div class="offer-card h-100" style="border-radius: 12px; overflow: hidden; background: #fff; box-shadow: 0 2px 12px rgba(0,0,0,0.06); transition: transform 0.3s, box-shadow 0.3s;">
                            <!-- Image -->
                            <div style="width: 100%; height: 220px; overflow: hidden; position: relative;">
                                @if (!empty($imgUrl))
                                    <img src="{{ $imgUrl }}" alt="{{ $offerTitle }}"
                                         style="width: 100%; height: 100%; object-fit: cover; display: block; transition: transform 0.4s;"
                                         onerror="this.parentElement.innerHTML='<div style=\'width:100%;height:100%;background:#eee;display:flex;align-items:center;justify-content:center;color:#999;\'>Image</div>'">
                                @else
                                    <div style="width:100%;height:100%;background:#eee;display:flex;align-items:center;justify-content:center;color:#999;">Image</div>
                                @endif
                                @if (!empty($badge))
                                    <span style="position:absolute;top:12px;left:12px;background:{{ $primaryColor }};color:#fff;font-size:0.75rem;font-weight:700;padding:4px 12px;border-radius:4px;">
                                        {{ $badge }}
                                    </span>
                                @endif
                            </div>
                            <!-- Content -->
                            <div class="p-3 text-center">
                                <h3 style="font-size:1.15rem;font-weight:700;color:#1a1a2e;margin-bottom:8px;">{{ $offerTitle }}</h3>
                                <p style="font-size:0.85rem;color:#888;line-height:1.5;margin-bottom:14px;">
                                    @if (!empty($badge))
                                        Réductions jusqu'à {{ $offer->max_discount }}% sur cette catégorie.
                                    @else
                                        Découvrez nos meilleures offres.
                                    @endif
                                </p>
                                <a wire:navigate href="{{ $offerUrl }}"
                                   style="display:inline-block;background:{{ $primaryColor }};color:#fff;padding:10px 28px;border-radius:6px;font-weight:600;font-size:0.85rem;text-decoration:none;transition:all 0.3s;"
                                   onmouseover="this.style.background='{{ $primaryHover }}';this.style.boxShadow='0 4px 12px rgba(230,81,0,0.3)';"
                                   onmouseout="this.style.background='{{ $primaryColor }}';this.style.boxShadow='none';">
                                    DÉCOUVREZ MAINTENANT
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if ((!isset($offers_sliders) || $offers_sliders->original['error'] == 'true') && (!isset($singleOffers) || count($singleOffers) < 1))
        @php $title = labels('front_messages.no_offers_found', 'No Offers Found!'); @endphp
        <div class="container-fluid py-5 text-center"><x-utility.others.not-found :$title /></div>
    @endif
</div>
