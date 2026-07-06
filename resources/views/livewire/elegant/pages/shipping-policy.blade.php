@php
    $title = "Politique d'expédition";
    $articles = [
        ['num' => '1', 'title' => 'Zones de livraison', 'content' => "AURORA MARKETPLACE assure la livraison dans les zones où ses services sont disponibles. Notre réseau s'étend progressivement afin de couvrir un nombre croissant de villes, de régions et de pays. Les zones desservies sont indiquées au moment de la commande."],
        ['num' => '2', 'title' => 'Préparation des commandes', 'type' => 'list', 'content' => "Après la confirmation de votre commande, le vendeur procède à la préparation de vos articles. Le délai de préparation peut varier selon :", 'items' => [
            "la disponibilité des produits ;",
            "le volume des commandes ;",
            "les horaires d'ouverture du vendeur ;",
            "les contraintes logistiques éventuelles.",
        ], 'extra' => "Une fois la commande prête, elle est confiée à un livreur ou à un partenaire de livraison."],
        ['num' => '3', 'title' => 'Délais de livraison', 'type' => 'list', 'content' => "Les délais de livraison dépendent notamment :", 'items' => [
            "de votre localisation ;",
            "de la distance entre le vendeur et l'adresse de livraison ;",
            "de la disponibilité des produits ;",
            "des conditions de circulation ;",
            "des conditions météorologiques ;",
            "ou de tout autre événement indépendant de notre volonté.",
        ], 'extra' => "Les délais affichés sur la plateforme sont fournis à titre estimatif."],
        ['num' => '4', 'title' => 'Frais de livraison', 'type' => 'list', 'content' => "Les frais de livraison sont calculés selon différents critères, notamment :", 'items' => [
            "la distance à parcourir ;",
            "le poids ou le volume de la commande ;",
            "le mode de livraison choisi ;",
            "la zone géographique ;",
            "les tarifs applicables au moment de la commande.",
        ], 'extra' => "Le montant total est clairement affiché avant la validation de votre achat."],
        ['num' => '5', 'title' => 'Suivi de votre commande', 'content' => "Dès que votre commande est confirmée, vous pouvez suivre son évolution directement depuis votre compte. Selon les services disponibles, vous pourrez consulter les principales étapes : préparation, expédition, prise en charge par le livreur et livraison. Vous recevrez également des notifications afin de rester informé de l'avancement de votre commande."],
        ['num' => '6', 'title' => 'Réception de la commande', 'content' => "Lors de la livraison, nous vous invitons à vérifier l'état général de votre commande avant de l'accepter. Si vous constatez un produit manquant, endommagé, incorrect ou manifestement non conforme, signalez-le dans les meilleurs délais via l'application ou auprès de notre service client."],
        ['num' => '7', 'title' => 'Absence du destinataire', 'content' => "Le client est responsable de fournir une adresse exacte et des coordonnées permettant d'assurer la livraison. En cas d'absence, le livreur pourra, selon les procédures applicables, tenter une nouvelle livraison ou contacter le client afin de convenir d'une solution adaptée. Des frais supplémentaires peuvent s'appliquer en cas de nouvelle tentative de livraison lorsque l'absence est imputable au client."],
        ['num' => '8', 'title' => 'Retards de livraison', 'type' => 'list', 'content' => "Malgré tous les efforts déployés, certaines circonstances exceptionnelles peuvent entraîner un retard, notamment :", 'items' => [
            "les intempéries ;",
            "les embouteillages ;",
            "les incidents techniques ;",
            "les restrictions administratives ;",
            "les mouvements sociaux ;",
            "les cas de force majeure ;",
            "ou tout autre événement imprévisible.",
        ], 'extra' => "Dans ce cas, nous nous efforcerons de vous informer dans les meilleurs délais."],
        ['num' => '9', 'title' => 'Produits sensibles', 'content' => "Certains produits nécessitant des conditions particulières de transport (produits frais, surgelés, fragiles, volumineux ou de grande valeur) peuvent faire l'objet de modalités spécifiques afin de préserver leur qualité jusqu'à la livraison."],
        ['num' => '10', 'title' => 'Responsabilité', 'content' => "AURORA MARKETPLACE collabore avec des vendeurs et des partenaires de livraison afin d'assurer un service de qualité. Chaque partie demeure responsable de ses obligations respectives, notamment en matière de préparation, d'emballage, d'expédition et de livraison. En cas d'incident, notre équipe intervient pour faciliter la recherche d'une solution rapide et équitable."],
        ['num' => '11', 'title' => 'Modification de cette politique', 'content' => "Cette Politique d'expédition peut être modifiée à tout moment afin de tenir compte de l'évolution de nos services, des exigences réglementaires ou des améliorations apportées à notre plateforme. La version la plus récente est toujours disponible dans l'application."],
        ['num' => '12', 'title' => 'Nous contacter', 'content' => "Pour toute question relative à une expédition, une livraison ou au suivi de votre commande, notre service client est à votre disposition via les différents canaux de communication officiels indiqués dans l'application."],
    ];
@endphp
<div>
    <x-utility.breadcrumbs.breadcrumbOne :breadcrumb="$title" />

    <!-- Hero Section -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 900px; padding: 40px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                POLITIQUE D'<span style="color: #F57C00;">EXPÉDITION</span>
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem; line-height: 1.7;">
                Une livraison pensée pour votre tranquillité. Chez AURORA MARKETPLACE, nous nous engageons à offrir un service d'expédition fiable, transparent et efficace.
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
                    En passant commande sur notre plateforme, vous acceptez les modalités d'expédition décrites ci-dessous.
                    </p>
                </div>

                @foreach($articles as $article)
                <div style="background: #fff; border-radius: 14px; padding: 28px 30px; margin-bottom: 20px; box-shadow: 0 3px 18px rgba(0,0,0,0.05); border-left: 4px solid #e65100;">
                    <h3 style="font-size: 17px; font-weight: 700; color: #e65100; margin-bottom: 12px;">Article {{ $article['num'] }} — {{ $article['title'] }}</h3>
                    @if(isset($article['type']) && $article['type'] === 'list')
                        <p style="font-size: 14px; line-height: 1.8; color: #555; margin: 0;">{{ $article['content'] }}</p>
                        <ul style="font-size: 14px; line-height: 1.8; color: #555; margin-top: 8px; padding-left: 20px; list-style: disc;">
                            @foreach($article['items'] as $item)
                            <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                        @if(isset($article['extra']))
                        <p style="font-size: 14px; line-height: 1.8; color: #555; margin-top: 10px;">{{ $article['extra'] }}</p>
                        @endif
                    @else
                        <p style="font-size: 14px; line-height: 1.8; color: #555; margin: 0;">{{ $article['content'] }}</p>
                    @endif
                </div>
                @endforeach

                <!-- Engagement final -->
                <div style="margin-top: 50px; padding: 40px 35px; background: linear-gradient(135deg, rgba(230,81,0,0.85) 0%, rgba(245,124,0,0.80) 100%); border-radius: 16px; text-align: center; color: #fff; box-shadow: 0 20px 50px rgba(230,81,0,0.15);">
                    <h3 style="font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 14px;">Notre engagement</h3>
                    <p style="font-size: 14px; line-height: 1.8; opacity: 0.95; max-width: 700px; margin: 0 auto;">
                    Chez AURORA MARKETPLACE, chaque livraison représente bien plus qu'un simple transport de marchandises. Elle reflète notre engagement envers la qualité, la confiance et la satisfaction de nos utilisateurs. Nous mettons tout en œuvre pour que chaque commande soit préparée avec soin, expédiée avec efficacité et livrée dans les meilleures conditions, afin de vous offrir une expérience d'achat fiable, rapide et sereine.
                    </p>
                    <div style="margin-top: 18px; font-size: 15px; font-weight: 600; letter-spacing: 0.5px; color: #ffd54f;">
                    AURORA MARKETPLACE — Vos achats entre de bonnes mains, jusqu'à votre porte.
                    </div>
                </div>

            </div>
        </div>
    </section>
</div>
