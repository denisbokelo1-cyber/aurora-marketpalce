@php
    $title = 'Politique de retour et de remboursement';
@endphp
<div>
    <x-utility.breadcrumbs.breadcrumbOne :breadcrumb="$title" />

    <!-- Hero Section -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 900px; padding: 40px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                POLITIQUE DE <span style="color: #F57C00;">RETOUR</span><br>ET DE REMBOURSEMENT
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem; line-height: 1.7;">
                Votre satisfaction est notre priorité. Chez AURORA MARKETPLACE, nous nous engageons à offrir une expérience d'achat fiable, transparente et sécurisée.
            </p>
            <div class="mt-4">
                <a href="#" class="btn" style="background: #F57C00; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='#e65100'" onmouseout="this.style.background='#F57C00'">Consulter la politique</a>
            </div>
        </div>
    </div>

    <!-- Content -->
    <section style="padding: 60px 0 40px;">
        <div class="container">
            <div style="max-width: 900px; margin: 0 auto;">

                <div style="margin-bottom: 40px;">
                    <p style="font-size: 15px; line-height: 1.8; color: #555; margin-bottom: 14px;">
                    Chez <strong>AURORA MARKETPLACE</strong>, nous nous engageons à offrir une expérience d'achat fiable, transparente et sécurisée. Si un produit ne répond pas à vos attentes ou ne correspond pas à votre commande, nous mettons à votre disposition une procédure simple de retour et de remboursement, dans les conditions décrites ci-dessous.
                    </p>
                </div>

                @php
                $articles = [
                    ['num' => '1', 'title' => "Conditions d'éligibilité", 'type' => 'list', 'items' => [
                        "le produit reçu est différent de celui commandé ;",
                        "le produit est endommagé, défectueux ou inutilisable à la livraison ;",
                        "le produit est incomplet ou présente un défaut de fabrication ;",
                        "le vendeur ou la plateforme approuve la demande conformément aux présentes conditions.",
                    ], 'extra' => "Le produit doit être retourné dans son état d'origine, avec tous ses accessoires, son emballage, ses étiquettes et, lorsque cela est applicable, la preuve d'achat."],

                    ['num' => '2', 'title' => 'Produits non éligibles au retour', 'type' => 'list', 'items' => [
                        "les produits personnalisés ou fabriqués sur mesure ;",
                        "les denrées périssables ou alimentaires déjà livrées, sauf en cas de défaut avéré ;",
                        "les produits ouverts, utilisés ou détériorés après la livraison ;",
                        "les produits numériques ou immatériels déjà consommés ou téléchargés ;",
                        "tout autre produit expressément indiqué comme non retournable.",
                    ]],

                    ['num' => '3', 'title' => 'Délai de demande', 'type' => 'text', 'content' => "Toute demande de retour ou de remboursement doit être introduite dans le délai indiqué sur la fiche du produit ou dans les conditions spécifiques du vendeur. Plus la demande est effectuée rapidement après la réception de la commande, plus son traitement sera efficace."],
                    ['num' => '4', 'title' => 'Comment effectuer une demande ?', 'type' => 'text', 'content' => "Vous pouvez introduire votre demande directement depuis votre compte AURORA MARKETPLACE ou en contactant notre service client. Selon le cas, des informations complémentaires pourront être demandées, notamment des photographies du produit, une description du problème ou tout document permettant de faciliter l'examen de votre dossier."],
                    ['num' => '5', 'title' => 'Vérification de la demande', 'type' => 'text', 'content' => "Chaque demande fait l'objet d'une analyse afin de garantir une solution juste pour l'ensemble des parties. AURORA MARKETPLACE peut consulter le vendeur, le transporteur ou tout autre partenaire concerné avant de rendre sa décision."],
                    ['num' => '6', 'title' => 'Modalités de remboursement', 'type' => 'list', 'items' => [
                        "sur le moyen de paiement utilisé lors de l'achat ;",
                        "sous forme de crédit sur votre portefeuille électronique AURORA MARKETPLACE, lorsque cette option est disponible ;",
                        "ou par tout autre moyen accepté par la plateforme.",
                    ], 'extra' => "Le délai de remboursement peut varier selon le mode de paiement utilisé et les délais de traitement des partenaires financiers."],
                    ['num' => '7', 'title' => 'Frais de retour', 'type' => 'text', 'content' => "Lorsque l'erreur est imputable au vendeur, au transporteur ou à AURORA MARKETPLACE, les frais de retour peuvent être pris en charge conformément aux règles applicables. Dans les autres situations, les frais de retour peuvent rester à la charge du client."],
                    ['num' => '8', 'title' => 'Annulation de commande', 'type' => 'text', 'content' => "Une commande peut être annulée avant son expédition ou sa préparation, sous réserve de son état de traitement. Une fois la commande expédiée ou remise au transporteur, les conditions de retour prévues dans cette politique s'appliquent."],
                    ['num' => '9', 'title' => 'Produits livrés par des vendeurs partenaires', 'type' => 'text', 'content' => "AURORA MARKETPLACE agit en tant que plateforme mettant en relation acheteurs et vendeurs. Chaque vendeur demeure responsable de la conformité, de la qualité et de l'authenticité des produits qu'il commercialise. Toutefois, nous intervenons activement afin de faciliter le règlement des litiges et de garantir une expérience d'achat équitable."],
                    ['num' => '10', 'title' => 'Prévention des abus', 'type' => 'text', 'content' => "Toute demande frauduleuse, abusive ou fondée sur des informations inexactes peut être refusée. AURORA MARKETPLACE se réserve également le droit de suspendre ou de limiter l'accès aux utilisateurs qui détourneraient les procédures de retour ou de remboursement."],
                    ['num' => '11', 'title' => 'Modification de cette politique', 'type' => 'text', 'content' => "Cette politique peut être mise à jour à tout moment afin de tenir compte de l'évolution de nos services, des exigences légales ou des bonnes pratiques du commerce électronique. La version la plus récente est toujours disponible sur la plateforme."],
                ];
                @endphp

                @foreach($articles as $article)
                <div style="background: #fff; border-radius: 14px; padding: 28px 30px; margin-bottom: 20px; box-shadow: 0 3px 18px rgba(0,0,0,0.05); border-left: 4px solid #e65100;">
                    <h3 style="font-size: 17px; font-weight: 700; color: #e65100; margin-bottom: 12px;">Article {{ $article['num'] }} — {{ $article['title'] }}</h3>
                    @if($article['type'] === 'list')
                        @if(isset($article['content']))
                        <p style="font-size: 14px; line-height: 1.8; color: #555; margin: 0;">{{ $article['content'] }}</p>
                        @endif
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
                    Chez AURORA MARKETPLACE, nous croyons que la confiance est la base de toute relation commerciale durable. C'est pourquoi nous nous engageons à traiter chaque demande de retour ou de remboursement avec impartialité, transparence, diligence et professionnalisme, afin de protéger les intérêts de nos clients, de nos vendeurs et de l'ensemble de notre communauté.
                    </p>
                </div>

            </div>
        </div>
    </section>
</div>
