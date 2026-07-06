@php
    $title = 'Foire Aux Questions (FAQ)';
    $faqList = [
        ["q" => "Qu'est-ce qu'AURORA MARKETPLACE ?", "r" => "AURORA MARKETPLACE est une plateforme de commerce électronique qui vous permet d'acheter des milliers de produits auprès de plusieurs vendeurs, commerces et entreprises, en toute simplicité, avec une livraison rapide et des paiements sécurisés."],
        ["q" => "Comment créer un compte ?", "r" => "Téléchargez l'application, inscrivez-vous avec votre numéro de téléphone ou votre adresse e-mail, puis suivez les étapes de vérification pour commencer vos achats."],
        ["q" => "Puis-je commander sans créer un compte ?", "r" => "Non. Un compte est nécessaire afin d'assurer le suivi de vos commandes, la sécurité de vos paiements et une meilleure expérience utilisateur."],
        ["q" => "Quels types de produits sont disponibles ?", "r" => "Vous trouverez une large sélection de produits : alimentation, boissons, mode, chaussures, électronique, téléphones, informatique, électroménager, beauté, santé, maison, mobilier, fournitures scolaires, automobile, agriculture, construction, équipements professionnels, artisanat, articles pour bébés, animaux, sports et bien plus encore."],
        ["q" => "Les produits sont-ils authentiques ?", "r" => "Les vendeurs sont responsables de la qualité et de l'authenticité des produits qu'ils proposent. AURORA MARKETPLACE met en œuvre des mécanismes de contrôle afin de garantir une expérience d'achat fiable."],
        ["q" => "Comment passer une commande ?", "r" => "Choisissez vos articles, ajoutez-les à votre panier, sélectionnez votre adresse de livraison, choisissez votre mode de paiement puis confirmez votre commande."],
        ["q" => "Quels moyens de paiement sont acceptés ?", "r" => "Selon votre pays, vous pouvez payer via Mobile Money, carte bancaire, portefeuille électronique ou tout autre moyen de paiement disponible sur la plateforme."],
        ["q" => "Puis-je suivre ma commande ?", "r" => "Oui. Dès la confirmation de votre commande, vous pouvez suivre son évolution en temps réel jusqu'à sa livraison."],
        ["q" => "Combien de temps dure la livraison ?", "r" => "Le délai dépend de votre localisation, de la disponibilité des produits et du vendeur. Une estimation vous est communiquée avant la validation de votre commande."],
        ["q" => "Puis-je annuler une commande ?", "r" => "Oui, tant que celle-ci n'a pas encore été préparée ou expédiée, conformément à notre politique d'annulation."],
        ["q" => "Que faire si je reçois un produit endommagé ou incorrect ?", "r" => "Contactez immédiatement notre service client depuis l'application. Après vérification, une solution adaptée vous sera proposée conformément à notre politique de remboursement et de retour."],
        ["q" => "Puis-je retourner un produit ?", "r" => "Oui. Certains produits peuvent être retournés selon les conditions définies dans notre politique de retour et de remboursement."],
        ["q" => "Mes paiements sont-ils sécurisés ?", "r" => "Oui. Toutes les transactions sont protégées grâce à des technologies de sécurité destinées à préserver vos données personnelles et financières."],
        ["q" => "Mes informations personnelles sont-elles protégées ?", "r" => "Absolument. Nous accordons une importance particulière à la confidentialité de vos données et appliquons des mesures de sécurité conformes aux meilleures pratiques."],
        ["q" => "Comment devenir vendeur sur AURORA MARKETPLACE ?", "r" => "Il vous suffit de créer un compte vendeur, de soumettre les documents demandés et d'attendre la validation de votre boutique avant de commencer à vendre."],
        ["q" => "Puis-je vendre n'importe quel produit ?", "r" => "Les vendeurs peuvent proposer une large gamme de produits, à condition qu'ils soient légaux, conformes à la réglementation en vigueur et respectent les règles de la plateforme."],
        ["q" => "Comment contacter le service client ?", "r" => "Notre équipe d'assistance est disponible via l'application, par e-mail, téléphone ou tout autre canal officiel indiqué dans la rubrique « Contact »."],
        ["q" => "AURORA MARKETPLACE est-elle disponible dans plusieurs régions ?", "r" => "Oui. Notre ambition est de rendre la plateforme accessible dans plusieurs villes et pays, avec un développement progressif afin d'offrir des services toujours plus performants."],
        ["q" => "Pourquoi choisir AURORA MARKETPLACE ?", "r" => "Parce que nous réunissons des milliers de produits, des vendeurs de confiance, des paiements sécurisés, des livraisons efficaces et une expérience d'achat moderne sur une seule plateforme."],
    ];
@endphp
<div>
    <x-utility.breadcrumbs.breadcrumbOne :breadcrumb="$title" />

    <!-- Hero Section -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 900px; padding: 40px 20px;">
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                FOIRE AUX <span style="color: #F57C00;">QUESTIONS</span>
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 700px; font-size: 1.1rem; line-height: 1.7;">
                Trouvez les réponses aux questions les plus fréquentes sur AURORA MARKETPLACE.
            </p>
            <div class="mt-4">
                <a href="#faqAccordion" class="btn" style="background: #F57C00; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='#e65100'" onmouseout="this.style.background='#F57C00'">Voir les questions</a>
            </div>
        </div>
    </div>

    <!-- FAQ Content -->
<style>
.faq-question-btn:hover { background: rgba(230,81,0,0.03); }
.faq-question-btn:focus { outline: none; }
</style>
    <section style="padding: 60px 0 40px;">
        <div class="container">
            <div style="max-width: 850px; margin: 0 auto;">
                <div class="accordion" id="faqAccordion">
                @foreach($faqList as $index => $faq)
                    <div style="background: #fff; border-radius: 14px; margin-bottom: 12px; box-shadow: 0 3px 18px rgba(0,0,0,0.05); border-left: 4px solid #e65100; overflow: hidden;">
                        <div style="padding: 0;">
                            <button class="faq-question-btn" type="button" data-bs-toggle="collapse" data-bs-target="#faqCollapse{{ $index }}" aria-expanded="false" style="width: 100%; background: none; border: none; padding: 20px 30px; text-align: left; cursor: pointer; display: flex; justify-content: space-between; align-items: center; font-size: 15px; font-weight: 600; color: #e65100; outline: none; box-shadow: none;">
                                <span>{{ $faq['q'] }}</span>
                                <span style="font-size: 18px; transition: transform 0.3s; flex-shrink: 0; margin-left: 15px;" class="faq-icon">+</span>
                            </button>
                            <div id="faqCollapse{{ $index }}" class="collapse" data-bs-parent="#faqAccordion">
                                <div style="padding: 0 30px 20px 30px;">
                                    <p style="font-size: 14px; line-height: 1.8; color: #555; margin: 0;">{{ $faq['r'] }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
                </div>

                <!-- Engagement final -->
                <div style="margin-top: 50px; padding: 40px 35px; background: linear-gradient(135deg, #e65100 0%, #f57c00 100%); border-radius: 16px; text-align: center; color: #fff; box-shadow: 0 20px 50px rgba(230,81,0,0.25);">
                    <h3 style="font-size: 22px; font-weight: 700; color: #fff; margin-bottom: 14px;">Notre engagement</h3>
                    <p style="font-size: 14px; line-height: 1.8; opacity: 0.95; max-width: 700px; margin: 0 auto;">
                    Chez AURORA MARKETPLACE, nous nous engageons à offrir une expérience d'achat simple, rapide, sécurisée et transparente. Votre satisfaction, votre confiance et votre sécurité sont au cœur de chacune de nos actions.
                    </p>
                </div>
            </div>
        </div>
    </section>
</div>
