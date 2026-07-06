@php
    $auroraOrange = '#F57C00';
    $auroraDark = '#e65100';
@endphp
<div id="page-content">
    <x-utility.breadcrumbs.breadcrumbTwo :$bread_crumb />

    <!-- Hero Banner (Offers-style) -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 360px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 800px; padding: 30px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                {{ $blogTitle }}
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 650px; font-size: 1rem; line-height: 1.6;">
                <ion-icon name="time-outline" style="vertical-align: middle; margin-right: 6px;"></ion-icon>
                <time datetime="{{ $blogArray['created_at'] ?? $blogItem->created_at }}">{{ $blogArray['created_at'] ?? $blogItem->created_at }}</time>
            </p>
        </div>
    </div>

    <div class="container-fluid" style="padding: 30px 0 50px;">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10 col-xl-8">
                <div class="blog-article">
                    @if (!empty($blog_img))
                        <div style="width: 100%; border-radius: 12px; overflow: hidden; margin-bottom: 30px; box-shadow: 0 4px 20px rgba(0,0,0,0.08);">
                            <img style="width: 100%; height: auto; max-height: 480px; object-fit: cover; display: block;"
                                 src="{{ $blog_img }}" alt="{{ $blogTitle }}" />
                        </div>
                    @endif

                    <div class="blog-content" style="background: #fff; border-radius: 12px; border: 1px solid #f0f0f0; padding: 30px; box-shadow: 0 2px 12px rgba(0,0,0,0.04);">
                        <h2 class="h1" style="font-size: 28px; font-weight: 700; color: #1a1a2e; margin-bottom: 10px;">{{ $blogTitle }}</h2>
                        <div style="font-size: 13px; color: #999; margin-bottom: 20px; display: flex; align-items: center; gap: 6px;">
                            <ion-icon name="time-outline"></ion-icon>
                            <time datetime="{{ $blogArray['created_at'] ?? $blogItem->created_at }}">{{ $blogArray['created_at'] ?? $blogItem->created_at }}</time>
                        </div>
                        <hr style="border: 0; border-top: 1px solid #eee; margin: 0 0 24px 0;">
                        <div class="content" style="font-size: 15px; line-height: 1.8; color: #444;">
                            {!! htmlspecialchars_decode($blogArray['description'] ?? $blogItem->description, ENT_QUOTES) !!}
                        </div>
                        <hr style="border: 0; border-top: 1px solid #eee; margin: 30px 0;">
                        <div class="d-flex justify-content-between align-items-center flex-wrap">
                            <a wire:navigate href="{{ customUrl('blogs') }}"
                               style="display: inline-flex; align-items: center; gap: 6px; background: {{ $auroraOrange }}; color: #fff; padding: 8px 20px; border-radius: 6px; font-size: 12px; font-weight: 600; text-decoration: none; transition: all 0.3s;"
                               onmouseover="this.style.background='{{ $auroraDark }}'"
                               onmouseout="this.style.background='{{ $auroraOrange }}'">
                                <ion-icon name="arrow-back-outline"></ion-icon> Retour aux articles
                            </a>
                            <div class="social-sharing d-flex align-items-center gap-2 mt-2 mt-md-0">
                                <span style="font-size: 12px; color: #888; text-transform: uppercase; letter-spacing: 0.5px;">Partager :</span>
                                <div class="shareon" data-url="{{ $webUrl }}" data-deep-link="{{ $deepLinkUrl ?? '' }}">
                                    <a class="facebook" data-text="{{ $shareText }}"></a>
                                    <a class="telegram" data-text="{{ $shareText }}"></a>
                                    <a class="twitter" data-text="{{ $shareText }}"></a>
                                    <a class="whatsapp" data-text="{{ $shareText }}"></a>
                                    <a class="email" data-text="{{ $shareText }}"></a>
                                    <a class="copy-url" data-deep-link="{{ $deepLinkUrl ?? '' }}"></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @include('partials.deep-link-bottom-sheet', ['deepLinkUrl' => $deepLinkUrl])
</div>
