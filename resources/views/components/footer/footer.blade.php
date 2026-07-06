@php
    use App\Services\CartService;
    $user_id = auth()->id() ?? 0;
    $store_id = session('store_id') ?? '';
    $favorites = getFavorites(user_id: $user_id, store_id: $store_id);
    $cart_count = app(CartService::class)->getCartCount($user_id, $store_id);
@endphp
<div class="footer">
    <div class="footer-top clearfix">
        <div class="container-fluid">
            <div class="row justify-content-around">
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                    <h4 class="h4">Liens rapides</h4>
                    <ul>
                        @auth
                            <li><a href="{{ customUrl('my-account') }}"
                                    wire:navigate>Mon compte</a></li>
                        @else
                            <li><a href="{{ customUrl('login') }}"
                                    wire:navigate>Se connecter</a></li>
                            <li><a href="{{ customUrl('register') }}"
                                    wire:navigate>S'inscrire</a></li>
                        @endauth
                        <li><a href="{{ customUrl('about_us') }}"
                                wire:navigate>À propos</a></li>
                        <li><a href="{{ customUrl('privacy_policy') }}"
                                wire:navigate>Confidentialité</a></li>
                        <li><a href="{{ customUrl('contact_us') }}"
                                wire:navigate>Contact</a></li>
                        <li><a href="{{ customUrl('term_and_conditions') }}"
                                wire:navigate>CGVU</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-links">
                    <h4 class="h4">{{ labels('front_messages.customer_services', 'Customer Services') }}</h4>
                    <ul>
                        <li><a href="{{ customUrl('faqs') }}"
                                wire:navigate>FAQ</a></li>
                        @auth
                            <li>
                                <a href="{{ customUrl('my-account.support') }}"
                                    wire:navigate>Centre d'aide</a>
                            </li>
                        @endauth
                        <li><a href="{{ customUrl('return_policy') }}"
                                wire:navigate>Politique de retour</a>
                        </li>
                        <li><a href="{{ customUrl('shipping_policy') }}"
                                wire:navigate>Politique d'expédition</a>
                        </li>
                    </ul>
                </div>
                <div class="col-12 col-sm-12 col-md-3 col-lg-3 footer-contact">
                    <h4 class="h4">{{ labels('front_messages.contact_us', 'Contact Us') }}</h4>
                    <p class="address d-flex"><ion-icon class="fs-2 me-2" name="location-outline"></ion-icon>
                        195 av Kabambare, Commune/Lingwala, Kinshasa, RDC</p>
                    <p class="phone d-flex align-items-center"><ion-icon class="fs-5 me-2"
                            name="call-outline"></ion-icon> <b
                            class="me-1 d-none">{{ labels('front_messages.phone', 'Phone') }}:</b> <a
                            href="tel:+243860275282">+243 860 275 282</a></p>
                    <p class="email d-flex align-items-center"><ion-icon class="fs-5 me-2"
                            name="mail-outline"></ion-icon> <b
                            class="me-1 d-none">{{ labels('front_messages.email', 'Email') }}:</b> <a
                            href="mailto:contact@revival-business.com">contact@revival-business.com</a></p>
                    <ul class="list-inline social-icons mt-3">
                        <li class="list-inline-item"><a href="https://x.com/groupe85249" target="_blank" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="X (Twitter)"><i
                                    class="anm anm-twitter hdr-icon icon"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.facebook.com/profile.php?id=61587848550970" target="_blank" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Facebook"><i
                                    class="anm anm-facebook hdr-icon icon"></i></a></li>
                        <li class="list-inline-item"><a href="https://instagram.com/revivalgroup7" target="_blank" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Instagram"><i
                                    class="anm anm-instagram hdr-icon icon"></i></a></li>
                        <li class="list-inline-item"><a href="https://www.youtube.com/channel/UCCbPABAH4QHmbBntpgSin8Q" target="_blank" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="Youtube"><i
                                    class="anm anm-youtube hdr-icon icon"></i></a></li>
                        <li class="list-inline-item"><a href="https://linkedin.com/company/revival-group-drc" target="_blank" data-bs-toggle="tooltip"
                                data-bs-placement="top" title="LinkedIn"><i
                                    class="anm anm-linkedin hdr-icon icon"></i></a></li>
                    </ul>
                    @if ($settings->app_download_section == 1)
                        <ul class="list-inline social-icons mt-3">
                            @if ($settings->app_download_section_playstore_url != '')
                                <li class="list-inline-item"><a href="{{ $settings->app_download_section_playstore_url }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="Play Store">
                                        <img src="{{ asset('assets/img/playstore.png') }}" alt="Play store">
                                    </a></li>
                            @endif
                            @if ($settings->app_download_section_appstore_url != '')
                                <li class="list-inline-item"><a href="{{ $settings->app_download_section_appstore_url }}"
                                        data-bs-toggle="tooltip" data-bs-placement="top" title="App Store">
                                        <img src="{{ asset('assets/img/appstore.png') }}" alt="app store">
                                    </a></li>
                            @endif
                        </ul>
                    @endif
                </div>
            </div>
        </div>
    </div>
    @if (config('constants.ALLOW_MODIFICATION') == 0)
        <a target="blank"
            href="https://codecanyon.net/item/eshop-plus-multi-vendor-ecommerce-multi-module-website-in-laravel/56605998"
            class="buy_now_button position-fixed bottom-0 m-3 z-3 text-decoration-none">
            <div class="btn btn-primary d-flex align-items-center gap-1 mb-4 rounded-pill px-3 py-2">
                <i class="anm anm-cart-plus"></i>
                Buy Now
            </div>
        </a>
    @endif
    <hr class="horizontal light m-0">
    <div class="footer-bottom clearfix">
        <div class="container-fluid">
            <div class="d-flex-center flex-column justify-content-md-between flex-md-row-reverse">
                <ul class="payment-icons d-flex-center mb-2 mb-md-0">
                    <li><i class="icon anm anm-cc-visa"></i></li>
                    <li><i class="icon anm anm-cc-mastercard"></i></li>
                    <li><i class="icon anm anm-cc-amex"></i></li>
                    <li><i class="icon anm anm-cc-paypal"></i></li>
                    <li><i class="icon anm anm-cc-stripe"></i></li>
                </ul>
                <div class="copytext text"> {!! preg_replace('/\b\d{4}\b/', date('Y'), $settings->copyright_details) !!}
                </div>
            </div>
        </div>
    </div>
    <!--Scoll Top-->
    @auth
        <iframe src="{{ url('chatify') }}" id="chat-iframe"></iframe>
    @endauth

    <div class="sticky-btn-box">
        @auth
            <a wire:navigate href="{{ customUrl('my-account/live-customer-support') }}"
                class="chat-btn chat-btn-redirect d-flex justify-content-center align-items-center"><i
                    class="anm anm-chat hdr-icon icon"></i></a>
            <div class="chat-btn chat-btn-popup d-flex justify-content-center align-items-center"><i
                    class="anm anm-chat hdr-icon icon"></i></div>
        @endauth
        <div id="site-scroll" class="d-flex justify-content-center align-items-center d-none mt-2"><i
                class="icon anm anm-arw-up"></i></div>

    </div>
    <div class="menubar-mobile d-flex align-items-center justify-content-between d-lg-none">
        <div class="menubar-shop menubar-item">
            <a wire:navigate href="{{ customUrl('products') }}"><i class="menubar-icon anm anm-th-large-l"></i><span
                    class="menubar-label">{{ labels('front_messages.products', 'Products') }}</span></a>
        </div>
        @auth
            <div class="menubar-account menubar-item">
                <a href="{{ customUrl('my-account') }}" wire:navigate><i class="menubar-icon icon anm anm-user-al"></i><span
                        class="menubar-label">{{ labels('front_messages.my_account', 'My Account') }}</span></a>
            </div>
        @else
            <div class="menubar-account menubar-item">
                <a href="{{ customUrl('login') }}" wire:navigate><i class="menubar-icon icon anm anm-user-al"></i><span
                        class="menubar-label">{{ labels('front_messages.sign_in', 'Sign In') }}</span></a>
            </div>
        @endauth
        <div class="menubar-search menubar-item">
            <a wire:navigate href="{{ customUrl('home') }}"><span class="menubar-icon anm anm-home-l"></span><span
                    class="menubar-label">{{ labels('front_messages.home', 'Home') }}</span></a>
        </div>
        <div class="menubar-wish menubar-item">
            <a wire:navigate href="{{ customUrl('my-account.favorites') }}">
                <span class="span-count position-relative text-center"><i
                        class="menubar-icon icon anm anm-heart-l"></i><span
                        class="wishlist-count counter menubar-count">{{ $favorites['favorites_count'] }}</span></span>
                <span class="menubar-label">{{ labels('front_messages.wishlist', 'Wishlist') }}</span>
            </a>
        </div>
        <div class="menubar-cart menubar-item">
            <a href="#;" class="btn-minicart" data-bs-toggle="offcanvas" data-bs-target="#minicart-drawer">
                <span class="span-count position-relative text-center"><i
                        class="menubar-icon icon anm anm-cart-l"></i><span
                        class="cart-count counter menubar-count">{{ $cart_count }}</span></span>
                <span class="menubar-label">{{ labels('front_messages.cart', 'Cart') }}</span>
            </a>
        </div>
    </div>
    <livewire:pages.quickview-model />
</div>
