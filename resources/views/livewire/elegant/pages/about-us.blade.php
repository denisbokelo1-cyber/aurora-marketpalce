@php
    $title = labels('front_messages.about_us', 'About Us');
@endphp
@php
    use App\Services\SettingService;
    $settings = app(SettingService::class)->getSettings('web_settings', true);
    $settings = json_decode($settings);
@endphp
<div>
    <x-utility.breadcrumbs.breadcrumbOne :breadcrumb="$title" />

    <!-- Hero Section -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 900px; padding: 40px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                BIENVENUE SUR <span style="color: #F57C00;">AURORA</span> MARKETPLACE
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem; line-height: 1.7;">
                Chez AURORA MARKETPLACE, nous sommes convaincus que le commerce de demain doit être plus simple, plus rapide, plus intelligent et plus accessible à tous.
            </p>
            <div class="mt-4">
                <a href="#mission" class="btn" style="background: #F57C00; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='#e65100'" onmouseout="this.style.background='#F57C00'">Découvrir notre mission</a>
            </div>
        </div>
    </div>

    <!-- Mission -->
    <section style="padding: 60px 0;">
        <div class="container" style="max-width: 960px;">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-5">
                    <div style="border-radius: 12px; overflow: hidden; box-shadow: 0 2px 20px rgba(0,0,0,0.08); border: 1px solid #f0f0f0;">
                        <img class="w-100" src="{{ asset('storage/' . ($settings->logo ?? '')) }}" alt="AURORA MARKETPLACE" style="display: block; width: 100%;">
                    </div>
                </div>
                <div class="col-12 col-lg-7">
                    <h2 style="font-size: 26px; font-weight: 700; color: #e65100; margin-bottom: 14px;">Notre Mission</h2>
                    <p style="font-size: 14px; line-height: 1.8; color: #555; margin-bottom: 12px;">Notre mission est de révolutionner la manière dont les particuliers, les commerçants, les entreprises et les producteurs se rencontrent, échangent et développent leurs activités grâce à une plateforme numérique moderne, performante et inclusive.</p>
                    <p style="font-size: 14px; line-height: 1.8; color: #555; margin-bottom: 12px;"><strong>AURORA MARKETPLACE</strong> est bien plus qu'une simple marketplace. C'est un véritable écosystème digital conçu pour connecter des milliers de vendeurs et des millions de consommateurs au sein d'un environnement sécurisé, transparent et innovant.</p>
                    <p style="font-size: 14px; line-height: 1.8; color: #555;">Nous mettons la technologie au service du développement économique en offrant aux commerçants une vitrine digitale puissante et aux consommateurs un accès à une immense variété de produits, disponibles à tout moment et en quelques clics.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Valeurs -->
    <section style="background: #f8f9fa; padding: 60px 0;">
        <div class="container" style="max-width: 960px;">
            <div class="row g-4">
                <div class="col-12 col-md-6">
                    <div style="background: #fff; border-radius: 12px; padding: 32px; height: 100%; box-shadow: 0 2px 20px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 20px;">🌍</div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #e65100; margin-bottom: 10px;">Notre Plateforme</h3>
                        <p style="font-size: 13px; line-height: 1.7; color: #666; margin: 0;">Notre plateforme rassemble des produits de tous les univers : alimentation, mode, électronique, santé, beauté, maison, construction, automobile, agriculture, fournitures professionnelles, artisanat, services et bien plus encore.</p>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div style="background: #fff; border-radius: 12px; padding: 32px; height: 100%; box-shadow: 0 2px 20px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
                        <div style="width: 44px; height: 44px; border-radius: 50%; background: #fff8e1; display: flex; align-items: center; justify-content: center; margin-bottom: 16px; font-size: 20px;">💡</div>
                        <h3 style="font-size: 16px; font-weight: 700; color: #e65100; margin-bottom: 10px;">Notre Engagement</h3>
                        <p style="font-size: 13px; line-height: 1.7; color: #666; margin: 0;">Nous croyons profondément que chaque entrepreneur mérite les mêmes opportunités de croissance, quelle que soit la taille de son entreprise ou sa localisation.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Innovation -->
    <section style="padding: 60px 0;">
        <div class="container" style="max-width: 960px;">
            <div class="row align-items-center g-5">
                <div class="col-12 col-lg-7">
                    <h2 style="font-size: 26px; font-weight: 700; color: #e65100; margin-bottom: 14px;">Innovation & Confiance</h2>
                    <p style="font-size: 14px; line-height: 1.8; color: #555; margin-bottom: 12px;">L'innovation, la confiance, la qualité, la proximité et la satisfaction de nos utilisateurs constituent les fondements de chacune de nos décisions.</p>
                    <p style="font-size: 14px; line-height: 1.8; color: #555; margin-bottom: 12px;">Notre ambition dépasse le simple commerce en ligne. Nous souhaitons contribuer à la transformation numérique de l'Afrique, soutenir les entreprises locales, favoriser l'inclusion économique, créer des opportunités d'emploi et participer activement à la croissance durable de notre continent.</p>
                    <p style="font-size: 14px; line-height: 1.8; color: #555; font-style: italic;">Chaque commande représente une opportunité. Chaque vendeur représente une histoire. Chaque client représente notre priorité.</p>
                </div>
                <div class="col-12 col-lg-5">
                    <div style="background: linear-gradient(135deg, #e65100 0%, #f57c00 100%); border-radius: 12px; padding: 40px 30px; text-align: center; color: #fff; box-shadow: 0 2px 20px rgba(230,81,0,0.2);">
                        <div style="font-size: 40px; margin-bottom: 14px;">✨</div>
                        <h3 style="font-size: 20px; font-weight: 700; margin-bottom: 10px;">AURORA MARKETPLACE</h3>
                        <p style="font-size: 13px; opacity: 0.9; line-height: 1.7; margin-bottom: 6px;">n'est pas seulement une application.</p>
                        <p style="font-size: 13px; opacity: 0.9; line-height: 1.7; margin-bottom: 6px;">C'est une <strong>nouvelle façon de commercer.</strong></p>
                        <p style="font-size: 13px; opacity: 0.9; line-height: 1.7; margin-bottom: 6px;">Une <strong>nouvelle façon de grandir.</strong></p>
                        <p style="font-size: 13px; opacity: 0.9; line-height: 1.7; margin-bottom: 0;">Une <strong>nouvelle façon de connecter l'Afrique au monde.</strong></p>
                        <div style="border-top: 1px solid rgba(255,255,255,0.2); padding-top: 16px; margin-top: 16px;">
                            <p style="font-size: 14px; font-weight: 600; letter-spacing: 1px; color: #ffd54f; margin: 0;">Tout ce dont vous avez besoin.<br>En un seul endroit.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact -->
    <section style="background: #f8f9fa; padding: 60px 0;">
        <div class="container" style="max-width: 960px;">
            <h2 style="font-size: 24px; font-weight: 700; color: #e65100; margin-bottom: 24px; text-align: center;">Nous Contacter</h2>
            <div style="background: #fff; border-radius: 12px; padding: 32px; box-shadow: 0 2px 20px rgba(0,0,0,0.04); border: 1px solid #f0f0f0;">
                <div class="row g-4">
                    <div class="col-12 col-md-6">
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
                            <div style="width: 38px; height: 38px; min-width: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; font-size: 16px;">📍</div>
                            <div><p style="font-size: 13px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 2px 0;">Adresse</p><p style="font-size: 14px; color: #333; margin: 0;">195 av Kabambare, Commune/Lingwala, Kinshasa, RDC</p></div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px; margin-bottom: 14px;">
                            <div style="width: 38px; height: 38px; min-width: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; font-size: 16px;">📞</div>
                            <div><p style="font-size: 13px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 2px 0;">Téléphone</p><p style="font-size: 14px; color: #333; margin: 0;"><a href="tel:+243860275282" style="color: #e65100; text-decoration: none;">+243 860 275 282</a></p></div>
                        </div>
                        <div style="display: flex; align-items: center; gap: 12px;">
                            <div style="width: 38px; height: 38px; min-width: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; font-size: 16px;">✉️</div>
                            <div><p style="font-size: 13px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin: 0 0 2px 0;">Email</p><p style="font-size: 14px; color: #333; margin: 0;"><a href="mailto:contact@revival-business.com" style="color: #e65100; text-decoration: none;">contact@revival-business.com</a></p></div>
                        </div>
                    </div>
                    <div class="col-12 col-md-6">
                        <p style="font-size: 13px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 10px;">Suivez-nous</p>
                        <div style="display: flex; gap: 8px; flex-wrap: wrap;">
                            <a href="https://www.facebook.com/profile.php?id=61587848550970" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px;"><i class="anm anm-facebook hdr-icon icon"></i></a>
                            <a href="https://x.com/groupe85249" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px;"><i class="anm anm-twitter hdr-icon icon"></i></a>
                            <a href="https://instagram.com/revivalgroup7" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px;"><i class="anm anm-instagram hdr-icon icon"></i></a>
                            <a href="https://www.youtube.com/channel/UCCbPABAH4QHmbBntpgSin8Q" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px;"><i class="anm anm-youtube hdr-icon icon"></i></a>
                            <a href="https://linkedin.com/company/revival-group-drc" target="_blank" style="width: 38px; height: 38px; border-radius: 50%; background: #fff3e0; display: flex; align-items: center; justify-content: center; text-decoration: none; color: #e65100; font-size: 17px;"><i class="anm anm-linkedin hdr-icon icon"></i></a>
                        </div>
                        <div style="margin-top: 16px;">
                            <p style="font-size: 13px; font-weight: 700; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px;">Horaires</p>
                            <p style="font-size: 13px; color: #555; margin: 0;">Lun - Ven : 08h-18h<br>Sam : 09h-15h</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA -->
    <section style="padding: 60px 0; text-align: center;">
        <div class="container">
            <h2 style="font-size: 24px; font-weight: 700; color: #222; margin-bottom: 10px;">Prêt à nous rejoindre ?</h2>
            <p style="font-size: 14px; color: #666; margin-bottom: 24px;">Découvrez tout ce que AURORA MARKETPLACE a à vous offrir.</p>
            <a href="/products" wire:navigate class="btn btn-lg" style="background: #e65100; color: #fff; border: none; padding: 12px 40px; font-size: 14px; font-weight: 600; border-radius: 8px; text-decoration: none; display: inline-block; cursor: pointer;">Explorer maintenant</a>
        </div>
    </section>

    <div class="service-section section section-color-light">
        <x-utility.others.serviceSection />
    </div>
</div>
