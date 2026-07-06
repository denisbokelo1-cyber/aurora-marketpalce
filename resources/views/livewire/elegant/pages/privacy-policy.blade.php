@php
    $title = 'Politique de confidentialité';
    $articles = [
        ['num' => '1', 'title' => "Les informations que nous collectons", 'type' => 'list', 'content' => "Afin de vous offrir une expérience optimale, nous pouvons collecter différentes catégories d'informations, notamment :", 'items' => [
            "Vos informations d'identification (nom, prénom, adresse e-mail, numéro de téléphone, photo de profil, etc.) ;",
            "Vos adresses de livraison et de facturation ;",
            "Les informations relatives à vos commandes, achats et transactions ;",
            "Les données de paiement, traitées de manière sécurisée par nos partenaires de paiement ;",
            "Les informations sur votre appareil, votre système d'exploitation, votre adresse IP et votre navigateur ;",
            "Votre position géographique lorsque vous autorisez son utilisation afin de faciliter les livraisons et les services de proximité ;",
            "Vos échanges avec notre service client ainsi que vos avis, commentaires et évaluations.",
        ]],
        ['num' => '2', 'title' => "Pourquoi utilisons-nous vos données ?", 'type' => 'list', 'content' => "Vos informations sont utilisées afin de :", 'items' => [
            "créer et gérer votre compte utilisateur ;",
            "traiter et livrer vos commandes ;",
            "assurer le bon fonctionnement de la plateforme ;",
            "améliorer continuellement nos services ;",
            "personnaliser votre expérience utilisateur ;",
            "vous envoyer des notifications concernant vos commandes, offres ou mises à jour importantes ;",
            "prévenir la fraude, les abus et les activités illicites ;",
            "respecter nos obligations légales et réglementaires.",
        ]],
        ['num' => '3', 'title' => "Protection de vos informations", 'type' => 'text', 'content' => "La sécurité de vos données constitue l'une de nos priorités. Nous mettons en œuvre des mesures techniques, organisationnelles et administratives destinées à protéger vos informations contre tout accès non autorisé, toute perte, toute altération, toute divulgation ou toute utilisation abusive. Malgré nos efforts, aucun système informatique n'est totalement invulnérable. Nous améliorons continuellement nos dispositifs de sécurité afin de garantir un niveau de protection élevé."],
        ['num' => '4', 'title' => "Partage des informations", 'type' => 'text', 'content' => "Nous ne vendons jamais vos données personnelles. Vos informations peuvent uniquement être partagées lorsque cela est nécessaire avec : les vendeurs concernés par vos commandes ; les partenaires de livraison ; les prestataires de paiement ; les fournisseurs de services techniques ; les autorités compétentes lorsque la loi l'exige. Tous nos partenaires sont tenus de respecter la confidentialité de vos données."],
        ['num' => '5', 'title' => "Cookies et technologies similaires", 'type' => 'text', 'content' => "AURORA MARKETPLACE utilise des cookies et des technologies similaires afin d'améliorer votre navigation, mémoriser vos préférences, analyser les performances de la plateforme et proposer une expérience plus fluide."],
        ['num' => '6', 'title' => "Conservation des données", 'type' => 'text', 'content' => "Nous conservons vos informations uniquement pendant la durée nécessaire à la fourniture de nos services, au respect de nos obligations légales, à la résolution des litiges et à la protection de nos droits."],
        ['num' => '7', 'title' => "Vos droits", 'type' => 'list', 'content' => "Vous disposez notamment des droits suivants :", 'items' => [
            "accéder à vos données personnelles ;",
            "corriger ou mettre à jour vos informations ;",
            "demander la suppression de votre compte, sous réserve des obligations légales applicables ;",
            "vous opposer à certains traitements de vos données lorsque la réglementation le permet ;",
            "retirer votre consentement lorsque celui-ci est requis.",
        ]],
        ['num' => '8', 'title' => "Protection des mineurs", 'type' => 'text', 'content' => "Nos services ne sont pas destinés aux personnes n'ayant pas atteint l'âge légal requis dans leur pays pour utiliser ce type de plateforme sans autorisation parentale. Si nous découvrons que des données ont été collectées en violation de cette règle, nous prendrons les mesures appropriées."],
        ['num' => '9', 'title' => "Évolution de cette politique", 'type' => 'text', 'content' => "Nous pouvons mettre à jour cette Politique de confidentialité afin de refléter les évolutions de nos services, des technologies ou de la réglementation. Toute modification importante sera portée à votre connaissance par les moyens appropriés."],
        ['num' => '10', 'title' => "Nous contacter", 'type' => 'text', 'content' => "Pour toute question concernant cette Politique de confidentialité ou le traitement de vos données personnelles, vous pouvez contacter notre service d'assistance via les coordonnées indiquées dans l'application ou sur notre site officiel."],
    ];
@endphp
<div>
    <x-utility.breadcrumbs.breadcrumbOne :breadcrumb="$title" />

    <!-- Hero Section -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 900px; padding: 40px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                POLITIQUE DE <span style="color: #F57C00;">CONFIDENTIALITÉ</span>
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem; line-height: 1.7;">
                Votre vie privée est notre priorité. Chez AURORA MARKETPLACE, nous accordons une importance capitale à la protection de vos données personnelles.
            </p>
            <div class="mt-4">
                <a href="#" class="btn" style="background: #F57C00; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='#e65100'" onmouseout="this.style.background='#F57C00'">En savoir plus</a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <section style="padding: 60px 0 40px;">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;">

                <div style="margin-bottom: 40px;">
                    <p style="font-size: 15px; line-height: 1.8; color: #555; margin-bottom: 14px;">
                    Cette Politique de confidentialité explique de manière claire et transparente quelles informations nous collectons, pourquoi nous les utilisons, comment nous les protégeons et quels sont vos droits.
                    </p>
                    <p style="font-size: 15px; line-height: 1.8; color: #555;">En utilisant AURORA MARKETPLACE, vous acceptez les pratiques décrites dans la présente politique.</p>
                </div>

                @foreach($articles as $article)
                <div style="background: #fff; border-radius: 14px; padding: 28px 30px; margin-bottom: 20px; box-shadow: 0 3px 18px rgba(0,0,0,0.05); border-left: 4px solid #e65100;">
                    <h3 style="font-size: 17px; font-weight: 700; color: #e65100; margin-bottom: 12px;">Article {{ $article['num'] }} — {{ $article['title'] }}</h3>
                    @if($article['type'] === 'list')
                        <p style="font-size: 14px; line-height: 1.8; color: #555; margin: 0;">{{ $article['content'] }}</p>
                        <ul style="font-size: 14px; line-height: 1.8; color: #555; margin-top: 8px; padding-left: 20px; list-style: disc;">
                            @foreach($article['items'] as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p style="font-size: 14px; line-height: 1.8; color: #555; margin: 0;">{{ $article['content'] }}</p>
                    @endif
                </div>
                @endforeach

                <!-- Engagement final -->
                <div style="margin-top: 50px; padding: 40px 35px; background: linear-gradient(135deg, rgba(230,81,0,0.85) 0%, rgba(245,124,0,0.80) 100%); border-radius: 16px; text-align: center; color: #fff; box-shadow: 0 20px 50px rgba(230,81,0,0.15);">
                    <h3 style="font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 14px;">Notre engagement</h3>
                    <p style="font-size: 14px; line-height: 1.8; opacity: 0.95; max-width: 700px; margin: 0 auto;">
                    La confiance est au cœur d'AURORA MARKETPLACE. Nous nous engageons à traiter vos données avec transparence, intégrité, responsabilité et le plus grand respect de votre vie privée afin que vous puissiez utiliser notre plateforme en toute sérénité.
                    </p>
                </div>

            </div>
        </div>
    </section>
</div>
