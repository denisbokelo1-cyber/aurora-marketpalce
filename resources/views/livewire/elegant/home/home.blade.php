@php
    use App\Services\StoreService;
    use App\Services\TranslationService;
    use App\Services\MediaService;

    $store_settings = app(StoreService::class)->getStoreSettings();
    $language_code = app(TranslationService::class)->getLanguageCode();
    
    $hasSliders = isset($sliders) && count($sliders) > 0;
    $hasCategories = isset($categories['categories']) && count($categories['categories']) > 0;
    $hasBrands = isset($brands['brands']) && count($brands['brands']) > 0;
    $hasSections = isset($sections) && count($sections) > 0;
    $hasBlogs = isset($blogs) && count($blogs) > 0;

    // === DONNÉES DE DÉMONSTRATION ===
    $demoSliders = [
        ['image' => 'https://images.unsplash.com/photo-1610557892470-55d9e80c0bce?w=1920&q=80', 'title' => 'Prenez soin de vous', 'subtitle' => 'Découvrez notre gamme de produits de bain premium', 'description' => 'Explorez notre collection de produits de bain biologiques, savons artisanaux et soins corporels de luxe.'],
        ['image' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=1920&q=80', 'title' => 'Produits frais de la ferme', 'subtitle' => 'Épicerie fine & produits ménagers', 'description' => 'Produits frais, essentiels de garde-manger et produits d\'entretien naturels livrés chez vous.'],
        ['image' => 'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=1920&q=80', 'title' => 'Alimentation saine', 'subtitle' => 'Choix bio & wholesome', 'description' => 'Des snacks sans gluten aux superaliments — nourrissez votre corps avec le meilleur de la nature.'],
    ];

    $demoCategories = [
        ['name' => 'Produits laitiers', 'slug' => 'produits-laitiers', 'image' => 'https://images.unsplash.com/photo-1550583724-b2692b85b150?w=400&h=400&fit=crop'],
        ['name' => 'Petit-déjeuner', 'slug' => 'petit-dejeuner', 'image' => 'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=400&h=400&fit=crop'],
        ['name' => 'Soins personnels', 'slug' => 'soins-personnels', 'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=400&h=400&fit=crop'],
        ['name' => 'Poisson', 'slug' => 'poisson', 'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=400&h=400&fit=crop'],
        ['name' => 'Nettoyage', 'slug' => 'nettoyage', 'image' => 'https://images.unsplash.com/photo-1563453392212-326f5e854473?w=400&h=400&fit=crop'],
        ['name' => 'Fruits & Légumes', 'slug' => 'fruits-legumes', 'image' => 'https://images.unsplash.com/photo-1597362925123-77861d3fbac7?w=400&h=400&fit=crop'],
        ['name' => 'Bébé', 'slug' => 'bebe', 'image' => 'https://images.unsplash.com/photo-1596464716127-f2a82984de30?w=400&h=400&fit=crop'],
        ['name' => 'Papeterie', 'slug' => 'papeterie', 'image' => 'https://images.unsplash.com/photo-1455390582262-044cdead277a?w=400&h=400&fit=crop'],
        ['name' => 'Électroménager', 'slug' => 'electromenager', 'image' => 'https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=400&h=400&fit=crop'],
        ['name' => 'Lutte nuisibles', 'slug' => 'lutte-nuisibles', 'image' => 'https://images.unsplash.com/photo-1563636619-e9143da7973b?w=400&h=400&fit=crop'],
    ];

    $demoBrands = [
        ['name' => 'Amul', 'slug' => 'amul', 'image' => 'https://placehold.co/200x80/e74c3c/ffffff?text=Amul'],
        ['name' => 'Nestlé', 'slug' => 'nestle', 'image' => 'https://placehold.co/200x80/3498db/ffffff?text=Nestl%C3%A9'],
        ['name' => 'Colgate', 'slug' => 'colgate', 'image' => 'https://placehold.co/200x80/2ecc71/ffffff?text=Colgate'],
        ['name' => 'Dove', 'slug' => 'dove', 'image' => 'https://placehold.co/200x80/9b59b6/ffffff?text=Dove'],
        ['name' => 'Palmolive', 'slug' => 'palmolive', 'image' => 'https://placehold.co/200x80/e67e22/ffffff?text=Palmolive'],
        ['name' => 'Nivea', 'slug' => 'nivea', 'image' => 'https://placehold.co/200x80/1abc9c/ffffff?text=Nivea'],
        ['name' => 'Dettol', 'slug' => 'dettol', 'image' => 'https://placehold.co/200x80/34495e/ffffff?text=Dettol'],
        ['name' => 'Himalaya', 'slug' => 'himalaya', 'image' => 'https://placehold.co/200x80/e74c3c/ffffff?text=Himalaya'],
        ['name' => 'Puma', 'slug' => 'puma', 'image' => 'https://placehold.co/200x80/2c3e50/ffffff?text=Puma'],
        ['name' => 'Adidas', 'slug' => 'adidas', 'image' => 'https://placehold.co/200x80/2980b9/ffffff?text=Adidas'],
    ];

            $demoProducts = [
        ['id' => 1, 'name' => 'Crème visage bio', 'slug' => 'creme-visage-bio', 'image' => 'https://images.unsplash.com/photo-1614332287897-cdc485fa562d?w=400&h=400&fit=crop', 'price' => 29.99, 'special_price' => 19.99, 'rating' => 4.5, 'category' => 'Soins personnels', 'brand' => 'Nivea'],
        ['id' => 2, 'name' => 'Savon artisanal', 'slug' => 'savon-artisanal', 'image' => 'https://images.unsplash.com/photo-1552581234-26160f608093?w=400&h=400&fit=crop', 'price' => 24.99, 'special_price' => null, 'rating' => 4.2, 'category' => 'Soins personnels', 'brand' => 'Dove'],
        ['id' => 3, 'name' => 'Brosse à dents bambou', 'slug' => 'brosse-a-dents-bambou', 'image' => 'https://images.unsplash.com/photo-1607613009820-a29f7bb81c04?w=400&h=400&fit=crop', 'price' => 12.99, 'special_price' => 8.99, 'rating' => 4.8, 'category' => 'Soins personnels', 'brand' => 'Colgate'],
        ['id' => 4, 'name' => 'Huile essentielle lavande', 'slug' => 'huile-essentielle-lavande', 'image' => 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?w=400&h=400&fit=crop', 'price' => 18.99, 'special_price' => null, 'rating' => 4.6, 'category' => 'Soins personnels', 'brand' => 'Himalaya'],
        ['id' => 5, 'name' => 'Bouteille réutilisable', 'slug' => 'bouteille-reutilisable', 'image' => 'https://images.unsplash.com/photo-1602143407151-7111542de6e8?w=400&h=400&fit=crop', 'price' => 22.99, 'special_price' => 15.99, 'rating' => 4.3, 'category' => 'Maison', 'brand' => 'Dettol'],
        ['id' => 6, 'name' => 'Tapis de yoga premium', 'slug' => 'tapis-yoga-premium', 'image' => 'https://images.unsplash.com/photo-1601925260368-ae2f83cf8b7f?w=400&h=400&fit=crop', 'price' => 39.99, 'special_price' => null, 'rating' => 4.7, 'category' => 'Sport', 'brand' => 'Nike'],
        ['id' => 7, 'name' => 'Thé vert bio', 'slug' => 'the-vert-bio', 'image' => 'https://images.unsplash.com/photo-1556679343-c7306c1976bc?w=400&h=400&fit=crop', 'price' => 14.99, 'special_price' => 9.99, 'rating' => 4.4, 'category' => 'Épicerie', 'brand' => 'Nestlé'],
        ['id' => 8, 'name' => 'Shampoing solide', 'slug' => 'shampoing-solide', 'image' => 'https://images.unsplash.com/photo-1598440947619-2c35fc9aa908?w=400&h=400&fit=crop', 'price' => 16.99, 'special_price' => null, 'rating' => 4.1, 'category' => 'Soins personnels', 'brand' => 'Palmolive'],
        ['id' => 9, 'name' => 'Lait corporel', 'slug' => 'lait-corporel', 'image' => 'https://images.unsplash.com/photo-1614332287897-cdc485fa562d?w=400&h=400&fit=crop', 'price' => 21.99, 'special_price' => 14.99, 'rating' => 4.4, 'category' => 'Soins personnels', 'brand' => 'Nivea'],
        ['id' => 10, 'name' => 'Poudre lait bébé', 'slug' => 'poudre-lait-bebe', 'image' => 'https://images.unsplash.com/photo-1596464716127-f2a82984de30?w=400&h=400&fit=crop', 'price' => 34.99, 'special_price' => 28.99, 'rating' => 4.7, 'category' => 'Bébé', 'brand' => 'Nestlé'],
        ['id' => 11, 'name' => 'Saumon frais', 'slug' => 'saumon-frais', 'image' => 'https://images.unsplash.com/photo-1519708227418-c8fd9a32b7a2?w=400&h=400&fit=crop', 'price' => 19.99, 'special_price' => 14.99, 'rating' => 4.8, 'category' => 'Poisson', 'brand' => 'Amul'],
        ['id' => 12, 'name' => 'Amandes', 'slug' => 'amandes', 'image' => 'https://images.unsplash.com/photo-1508061253366-f7da158b6d46?w=400&h=400&fit=crop', 'price' => 15.99, 'special_price' => 11.99, 'rating' => 4.5, 'category' => 'Épicerie', 'brand' => 'Amul'],
    ];

    $demoBlogs = [
        ['title' => '10 astuces pour une peau éclatante', 'slug' => '10-astuces-peau-eclatante', 'image' => 'https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=600&h=400&fit=crop', 'created_at' => '15 juin 2025', 'description' => 'Découvrez nos conseils naturels pour prendre soin de votre peau au quotidien avec des produits biologiques.'],
        ['title' => 'Guide des superaliments', 'slug' => 'guide-superaliments', 'image' => 'https://images.unsplash.com/photo-1551218808-94e220e084d2?w=600&h=400&fit=crop', 'created_at' => '10 juin 2025', 'description' => 'Les superaliments qui transformeront votre alimentation et boosteront votre énergie naturellement.'],
        ['title' => 'Comment choisir ses produits bio', 'slug' => 'choisir-produits-bio', 'image' => 'https://images.unsplash.com/photo-1597362925123-77861d3fbac7?w=600&h=400&fit=crop', 'created_at' => '5 juin 2025', 'description' => 'Nos conseils pour reconnaître les véritables produits biologiques et faire les bons choix.'],
    ];

    $activeSliders = $hasSliders ? $sliders : $demoSliders;
    $activeCategories = $hasCategories ? $categories['categories'] : $demoCategories;
    $activeBrands = $hasBrands ? $brands['brands'] : $demoBrands;
    $activeBlogs = $hasBlogs ? $blogs : $demoBlogs;
    $babyProducts = array_slice($demoProducts, 8, 4);
    $meatProducts = array_slice($demoProducts, 10, 3);
    $allProducts = $demoProducts;
@endphp

<style>
.section-mb { padding: 60px 0; }
.section-mb-sm { padding: 40px 0; }
@media(max-width:768px){ .section-mb { padding: 40px 0; }}

/* TOP BAR - Thème Orage */
.top-bar-orange { height: 44px; background: #041632; color: #fff; font-size: 13px; display: flex; align-items: center; border-bottom: 2px solid #f4a51c; }
.top-bar-orange .container-fluid { display: flex; align-items: center; justify-content: space-between; }
.top-bar-orange .tb-left { display: flex; align-items: center; gap: 10px; }
.top-bar-orange .tb-left i { color: #f4a51c; font-size: 16px; }
.top-bar-orange .tb-left span { font-size: 12px; letter-spacing: 0.3px; }
.top-bar-orange .tb-center { font-size: 12px; letter-spacing: 0.5px; font-weight: 600; color: #f4a51c; }
.top-bar-orange .tb-right { display: flex; align-items: center; gap: 16px; }
.top-bar-orange .tb-right select { background: rgba(244,165,28,0.12); color: #f4a51c; border: 1px solid rgba(244,165,28,0.3); border-radius: 4px; padding: 4px 8px; font-size: 11px; font-weight: 600; cursor: pointer; outline: none; text-transform: uppercase; }
.top-bar-orange .tb-right select option { color: #041632; background: #fff; }
.top-bar-orange .tb-right a { color: #fff; margin-left: 6px; font-size: 15px; text-decoration: none; display: inline-block; transition: color 0.2s; }
.top-bar-orange .tb-right a:hover { color: #f4a51c; }

/* HERO */
.hero-slider-slide { position: relative; height: 590px; display: flex; align-items: center; }
.hero-slider-slide .slider-bg { position: absolute; inset: 0; background-size: cover; background-position: center; }
.hero-slider-overlay { position: absolute; inset: 0; background: rgba(0,0,0,0.2); }
.hero-slider-card { position: relative; z-index: 2; background: rgba(255,255,255,0.88); backdrop-filter: blur(6px); border-radius: 20px; padding: 50px 45px; max-width: 620px; margin: 0 auto; text-align: center; box-shadow: 0 20px 60px rgba(0,0,0,0.1); }
.hero-slider-card h1 { font-size: 40px; font-weight: 800; color: #222; margin-bottom: 8px; line-height: 1.2; }
.hero-slider-card .hero-sub { font-size: 17px; font-weight: 600; color: #444; margin-bottom: 12px; }
.hero-slider-card p { font-size: 15px; color: #666; margin-bottom: 24px; line-height: 1.6; }
.hero-slider-card .hero-buttons { display: flex; gap: 14px; justify-content: center; flex-wrap: wrap; }
.btn-hero-dark { background: #222; color: #fff; border: 2px solid #222; padding: 13px 34px; font-size: 14px; font-weight: 600; border-radius: 50px; text-transform: uppercase; text-decoration: none; transition: all 0.3s; display: inline-block; }
.btn-hero-dark:hover { background: #111; }
.btn-hero-light { background: transparent; color: #222; border: 2px solid #222; padding: 13px 34px; font-size: 14px; font-weight: 600; border-radius: 50px; text-transform: uppercase; text-decoration: none; transition: all 0.3s; display: inline-block; }
.btn-hero-light:hover { background: #222; color: #fff; }
.hero-swiper-pagination { position: absolute; bottom: 24px; left: 0; right: 0; text-align: center; z-index: 3; }
.hero-swiper-pagination .swiper-pagination-bullet { width: 12px; height: 12px; border-radius: 50%; background: rgba(255,255,255,0.5); opacity: 1; margin: 0 5px; }
.hero-swiper-pagination .swiper-pagination-bullet-active { background: #fff; transform: scale(1.2); }
@media(max-width:768px){
    .hero-slider-slide { height: 400px; }
    .hero-slider-card { padding: 28px 20px; max-width: 92%; }
    .hero-slider-card h1 { font-size: 24px; }
    .hero-slider-card p { font-size: 13px; }
}

/* CATÉGORIES */
.cat-fr-card { text-align: center; cursor: pointer; transition: transform 0.3s; }
.cat-fr-card:hover { transform: translateY(-4px); }
.cat-fr-card .cat-img-wrap { width: 95px; height: 95px; border-radius: 50%; overflow: hidden; margin: 0 auto 10px; border: 2px solid #f0f0f0; box-shadow: 0 4px 15px rgba(0,0,0,0.05); }
.cat-fr-card .cat-img-wrap img { width: 100%; height: 100%; object-fit: cover; }
.cat-fr-card h4 { font-size: 13px; font-weight: 600; color: #222; letter-spacing: 0.3px; }

/* PRODUIT */
.prod-card { background: #fff; border-radius: 10px; overflow: hidden; border: 1px solid #e8e8e8; transition: box-shadow 0.3s; height: 100%; }
.prod-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.07); }
.prod-card .pc-img { width: 100%; height: 200px; object-fit: cover; }
.prod-card .pc-body { padding: 14px; }
.prod-card .pc-brand { font-size: 11px; color: #999; text-transform: uppercase; letter-spacing: 0.5px; margin-bottom: 4px; }
.prod-card .pc-name { font-size: 14px; font-weight: 600; color: #1a1a2e; margin-bottom: 6px; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
.prod-card .pc-price { display: flex; align-items: center; gap: 7px; margin-bottom: 6px; }
.prod-card .pc-current { font-size: 16px; font-weight: 700; color: #d32f2f; }
.prod-card .pc-old { font-size: 12px; color: #aaa; text-decoration: line-through; }
.prod-card .pc-category { font-size: 11px; color: #aaa; margin-bottom: 5px; }
.prod-card .pc-stars { color: #f4a51c; font-size: 12px; margin-bottom: 10px; }
.prod-card .pc-stars .star-o { color: #ddd; }
.prod-card .pc-btn { width: 100%; padding: 10px 0; background: #e65100; color: #fff; border: none; border-radius: 8px; font-size: 12px; font-weight: 700; text-transform: uppercase; cursor: pointer; transition: background 0.3s; }
.prod-card .pc-btn:hover { background: #ef6c00; }

/* SECTION TITLE */
.section-title-fr { text-align: center; margin-bottom: 32px; }
.section-title-fr h2 { font-size: 26px; font-weight: 700; color: #222; margin-bottom: 6px; }
.section-title-fr p { font-size: 14px; font-style: italic; color: #999; }

/* 2-COLUMN BANNER */
.col-banner { position: relative; height: 100%; min-height: 380px; background-size: cover; background-position: center; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; text-align: center; }
.col-banner::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.3); }
.col-banner-content { position: relative; z-index: 1; padding: 30px; max-width: 280px; }
.col-banner-content h3 { font-size: 24px; font-weight: 700; color: #fff; margin-bottom: 8px; line-height: 1.2; }
.col-banner-content p { font-size: 13px; color: rgba(255,255,255,0.85); margin-bottom: 18px; }
.col-banner-content .btn-dark-fr { display: inline-block; background: #222; color: #fff; padding: 11px 28px; font-size: 13px; font-weight: 600; border-radius: 50px; text-transform: uppercase; text-decoration: none; transition: background 0.3s; }
.col-banner-content .btn-dark-fr:hover { background: #d58b3b; }

/* PROMO BANNER */
.promo-card-fr { border-radius: 12px; overflow: hidden; position: relative; height: 260px; background-size: cover; background-position: center; display: flex; align-items: flex-end; }
.promo-card-fr .promo-overlay { background: linear-gradient(transparent, rgba(0,0,0,0.5)); padding: 24px; width: 100%; }
.promo-card-fr .promo-overlay h4 { color: #fff; font-weight: 700; font-size: 18px; margin-bottom: 4px; }
.promo-card-fr .promo-overlay p { color: rgba(255,255,255,0.85); font-size: 13px; margin-bottom: 0; }

/* MARQUEE */
.marquee-section { background: #f7f7f7; padding: 16px 0; overflow: hidden; white-space: nowrap; }
.marquee-track { display: inline-block; animation: marquee 25s linear infinite; }
.marquee-track span { display: inline-block; margin: 0 35px; font-size: 15px; font-weight: 600; color: #e65100; }
@keyframes marquee { 0% { transform: translateX(0); } 100% { transform: translateX(-50%); } }

/* BLOG */
.blog-card-fr { background: #fff; border-radius: 12px; overflow: hidden; border: 1px solid #eee; transition: box-shadow 0.3s; height: 100%; }
.blog-card-fr:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.07); }
.blog-card-fr .bc-img { width: 100%; height: 200px; object-fit: cover; }
.blog-card-fr .bc-body { padding: 18px; }
.blog-card-fr .bc-date { font-size: 12px; color: #aaa; margin-bottom: 6px; }
.blog-card-fr .bc-title { font-size: 16px; font-weight: 700; color: #222; margin-bottom: 8px; }
.blog-card-fr .bc-desc { font-size: 13px; color: #888; margin-bottom: 14px; line-height: 1.5; }
.blog-card-fr .bc-link { display: inline-block; font-size: 12px; font-weight: 700; color: #e65100; text-transform: uppercase; text-decoration: none; letter-spacing: 0.5px; }
.blog-card-fr .bc-link:hover { text-decoration: underline; }

/* BRAND CAROUSEL - PURE LOGO BAND */
.brands-carousel-section { background: #fff; }
.brands-carousel-section .swiper-slide { text-align: center; padding: 10px 0; }
.brand-carousel-item { display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 10px; text-decoration: none; }
.brand-carousel-item img { width: 100px; height: 60px; object-fit: contain; transition: opacity 0.2s; }
.brand-carousel-item img:hover { opacity: 0.7; }
.brand-carousel-item span { display: block; font-size: 12px; font-weight: 600; color: #555; letter-spacing: 0.3px; }
.brands-carousel-section .swiper-button-next,
.brands-carousel-section .swiper-button-prev { color: #999; }
.brands-carousel-section .swiper-button-next::after,
.brands-carousel-section .swiper-button-prev::after { font-size: 18px; font-weight: 700; }

/* VERTICAL BANNER */
.banner-vertical-fr { position: relative; height: 100%; min-height: 440px; background-size: cover; background-position: center; border-radius: 12px; overflow: hidden; display: flex; align-items: center; justify-content: center; text-align: center; }
.banner-vertical-fr::before { content: ''; position: absolute; inset: 0; background: rgba(0,0,0,0.35); }
.banner-vertical-content { position: relative; z-index: 1; padding: 30px; }
.banner-vertical-content h3 { font-size: 28px; font-weight: 800; color: #fff; margin-bottom: 10px; line-height: 1.2; }
.banner-vertical-content p { font-size: 14px; color: rgba(255,255,255,0.85); margin-bottom: 20px; }

/* ROUND BUTTON */
.btn-round-blue { width: 44px; height: 44px; border-radius: 50%; background: #e65100; color: #fff; display: flex; align-items: center; justify-content: center; text-decoration: none; font-size: 20px; flex-shrink: 0; }
.btn-round-blue:hover { background: #ef6c00; color: #fff; }
</style>

<div id="page-content" class="index-demo1" wire:ignore>

{{-- 1. TOP BAR --}}
<div class="top-bar-orange d-none d-md-flex">
    <div class="container-fluid">
        <div class="tb-left">
            <i class="anm anm-truck-l"></i>
            <span>LIVRAISON GRATUITE DÈS 99 €</span>
        </div>
        <div class="tb-center">LIVRAISON GRATUITE POUR TOUTE COMMANDE SUPÉRIEURE À 99 €</div>
        <div class="tb-right">
            <a href="#" aria-label="Facebook"><i class="anm anm-facebook"></i></a>
            <a href="#" aria-label="Twitter"><i class="anm anm-twitter"></i></a>
            <a href="#" aria-label="Instagram"><i class="anm anm-instagram"></i></a>
            <select><option>FR</option><option>EN</option></select>
            <select><option>EUR</option><option>USD</option></select>
        </div>
    </div>
</div>

{{-- 2. HEADER (déjà inclus via layout) --}}

{{-- 3. HERO SLIDER --}}
<section class="slideshow-wrapper" style="overflow:hidden;">
    <div class="swiper hero-swiper">
        <div class="swiper-wrapper">
            @foreach ($activeSliders as $slide)
                @php
                    $img = is_array($slide) ? ($slide['image'] ?? '') : ($slide->image ?? '');
                    $title = is_array($slide) ? ($slide['title'] ?? 'Prenez soin de vous') : ($slide->title ?? 'Prenez soin de vous');
                    $sub = is_array($slide) ? ($slide['subtitle'] ?? 'Découvrez notre gamme') : 'Découvrez notre gamme';
                    $desc = is_array($slide) ? ($slide['description'] ?? '') : ($slide->short_description ?? '');
                @endphp
                <div class="swiper-slide">
                    <div class="hero-slider-slide">
                        <div class="slider-bg" style="background-image:url('{{ $img }}');"></div>
                        <div class="hero-slider-overlay"></div>
                        <div class="container-fluid position-relative" style="z-index:2;">
                            <div class="row justify-content-center">
                                <div class="col-12 col-md-8 col-lg-6">
                                    <div class="hero-slider-card">
                                        <h1>{{ $title }}</h1>
                                        <div class="hero-sub">{{ $sub }}</div>
                                        <p>{{ $desc }}</p>
                                        <div class="hero-buttons">
                                            <a href="{{ customUrl('products') }}" wire:navigate class="btn-hero-dark">Acheter maintenant</a>
                                            <a href="{{ customUrl('products') }}" wire:navigate class="btn-hero-light">Découvrir</a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="hero-swiper-pagination"></div>
    </div>
</section>

{{-- 4. CATÉGORIES --}}
<section class="section-mb">
    <div class="container-fluid">
        <div class="section-title-fr">
            <h2>PRODUITS D'ÉPICERIE</h2>
            <p>Découvrez notre sélection dans toutes nos catégories.</p>
        </div>
        <div class="row row-cols-2 row-cols-sm-3 row-cols-md-4 row-cols-lg-5 row-cols-xl-10 justify-content-center g-3">
            @foreach ($activeCategories as $cat)
                @php
                    $cn = is_object($cat) ? ($cat->name ?? '') : ($cat['name'] ?? '');
                    $cs = is_object($cat) ? ($cat->slug ?? '#') : ($cat['slug'] ?? '#');
                    $ci = is_object($cat) ? ($cat->image ?? '') : ($cat['image'] ?? '');
                @endphp
                <div class="col">
                    <a href="{{ customUrl('categories/' . $cs . '/products') }}" wire:navigate class="text-decoration-none">
                        <div class="cat-fr-card"><div class="cat-img-wrap"><img src="{{ $ci }}" alt="{{ $cn }}" loading="lazy"></div><h4>{{ $cn }}</h4></div>
                    </a>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 5. SECTION PRODUITS BÉBÉ --}}
<section class="section-mb-sm" style="background:#fafafa;">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-12 col-md-5 col-lg-4">
                <div class="col-banner" style="background-image:url('https://images.unsplash.com/photo-1596464716127-f2a82984de30?w=800&q=80');">
                    <div class="col-banner-content">
                        <h3>MEILLEURS PRODUITS<br>POUR BÉBÉS</h3>
                        <p>Des produits doux et naturels pour le confort de votre bébé.</p>
                        <a href="{{ customUrl('categories/bebe/products') }}" wire:navigate class="btn-dark-fr">Explorer maintenant</a>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-7 col-lg-8">
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach ($babyProducts as $product)
                        @php $p = is_array($product) ? $product : (array) $product; @endphp
                        <div class="col">
                            <div class="prod-card">
                                <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate><img class="pc-img" src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy"></a>
                                <div class="pc-body">
                                    <div class="pc-brand">{{ $p['brand'] ?? '' }}</div>
                                    <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate class="text-decoration-none"><div class="pc-name">{{ $p['name'] }}</div></a>
                                    <div class="pc-price">
                                        @if (!empty($p['special_price']) && $p['special_price'] > 0 && $p['special_price'] < $p['price'])
                                            <span class="pc-current">{{ number_format($p['special_price'], 2) }} €</span><span class="pc-old">{{ number_format($p['price'], 2) }} €</span>
                                        @else
                                            <span class="pc-current">{{ number_format($p['price'], 2) }} €</span>
                                        @endif
                                    </div>
                                    <div class="pc-category">{{ $p['category'] ?? '' }}</div>
                                    <div class="pc-stars">@php $r = floor($p['rating'] ?? 4); @endphp @for ($i=1;$i<=5;$i++)<i class="icon anm {{ $i<=$r ? 'anm-star' : 'anm-star-o' }}"></i>@endfor</div>
                                    <button class="pc-btn add-to-cart-fr" data-name="{{ $p['name'] }}">Ajouter au panier</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 6. TROIS BANNIÈRES PROMO --}}
<section class="section-mb-sm">
    <div class="container-fluid">
        <div class="row g-3">
            @php
                $promos = [
                    ['img' => 'https://images.unsplash.com/photo-1610557892470-55d9e80c0bce?w=600&q=80', 'title' => 'Produits de bain', 'desc' => "Jusqu'à -30% sur une sélection"],
                    ['img' => 'https://images.unsplash.com/photo-1542838132-92c53300491e?w=600&q=80', 'title' => 'Fruits frais', 'desc' => 'Livraison directe du producteur'],
                    ['img' => 'https://images.unsplash.com/photo-1606787366850-de6330128bfc?w=600&q=80', 'title' => 'Produits alimentaires', 'desc' => 'Bio et local, le meilleur du terroir'],
                ];
            @endphp
            @foreach ($promos as $promo)
                <div class="col-12 col-md-4">
                    <div class="promo-card-fr" style="background-image:url('{{ $promo['img'] }}');">
                        <div class="promo-overlay"><h4>{{ $promo['title'] }}</h4><p>{{ $promo['desc'] }}</p></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 7. BANDEAU DÉFILANT --}}
<div class="marquee-section">
    <div class="marquee-track">
        <span>✦ Jusqu'à 40 % de réduction sur le lait</span>
        <span>✦ Tous les produits</span>
        <span>✦ Les meilleurs produits de soins personnels</span>
        <span>✦ Les fruits et légumes frais</span>
        <span>✦ Jusqu'à 40 % de réduction sur les produits de cuisine</span>
        <span>✦ Jusqu'à 40 % de réduction sur le lait</span>
        <span>✦ Tous les produits</span>
        <span>✦ Les meilleurs produits de soins personnels</span>
        <span>✦ Les fruits et légumes frais</span>
        <span>✦ Jusqu'à 40 % de réduction sur les produits de cuisine</span>
    </div>
</div>

{{-- 8. VIANDES ET POISSONS --}}
<section class="section-mb">
    <div class="container-fluid">
        <div class="d-flex justify-content-between align-items-center mb-4">
            <div><h2 style="font-size:26px;font-weight:700;color:#222;margin-bottom:4px;">VIANDES ET POISSONS</h2><p style="font-style:italic;color:#999;font-size:14px;">Fraîcheur et qualité garanties</p></div>
            <a wire:navigate href="{{ customUrl('products') }}" class="btn-round-blue"><i class="anm anm-arrow-alt-right"></i></a>
        </div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach ($meatProducts as $product)
                @php $p = is_array($product) ? $product : (array) $product; @endphp
                <div class="col">
                    <div class="prod-card">
                        <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate><img class="pc-img" src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy"></a>
                        <div class="pc-body">
                            <div class="pc-brand">{{ $p['brand'] ?? '' }}</div>
                            <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate class="text-decoration-none"><div class="pc-name">{{ $p['name'] }}</div></a>
                            <div class="pc-price">
                                @if (!empty($p['special_price']) && $p['special_price'] > 0 && $p['special_price'] < $p['price'])
                                    <span class="pc-current">{{ number_format($p['special_price'], 2) }} €</span><span class="pc-old">{{ number_format($p['price'], 2) }} €</span>
                                @else
                                    <span class="pc-current">{{ number_format($p['price'], 2) }} €</span>
                                @endif
                            </div>
                            <div class="pc-category">{{ $p['category'] ?? '' }}</div>
                            <div class="pc-stars">@php $r = floor($p['rating'] ?? 4); @endphp @for ($i=1;$i<=5;$i++)<i class="icon anm {{ $i<=$r ? 'anm-star' : 'anm-star-o' }}"></i>@endfor</div>
                            <button class="pc-btn add-to-cart-fr" data-name="{{ $p['name'] }}">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 9. SOINS PERSONNELS --}}
<section class="section-mb-sm" style="background:#fafafa;">
    <div class="container-fluid">
        <div class="row g-4">
            <div class="col-12 col-md-7 col-lg-8">
                <div class="d-flex justify-content-between align-items-center mb-3">
                    <div><h2 style="font-size:26px;font-weight:700;color:#222;margin-bottom:4px;">SOINS PERSONNELS</h2><p style="font-style:italic;color:#999;font-size:14px;">Prenez soin de vous au quotidien</p></div>
                </div>
                <div class="row row-cols-2 row-cols-sm-2 row-cols-md-3 g-3">
                    @foreach (array_slice($allProducts, 0, 6) as $product)
                        @php $p = is_array($product) ? $product : (array) $product; @endphp
                        <div class="col">
                            <div class="prod-card">
                                <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate><img class="pc-img" src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy"></a>
                                <div class="pc-body">
                                    <div class="pc-brand">{{ $p['brand'] ?? '' }}</div>
                                    <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate class="text-decoration-none"><div class="pc-name">{{ $p['name'] }}</div></a>
                                    <div class="pc-price">
                                        @if (!empty($p['special_price']) && $p['special_price'] > 0 && $p['special_price'] < $p['price'])
                                            <span class="pc-current">{{ number_format($p['special_price'], 2) }} €</span><span class="pc-old">{{ number_format($p['price'], 2) }} €</span>
                                        @else
                                            <span class="pc-current">{{ number_format($p['price'], 2) }} €</span>
                                        @endif
                                    </div>
                                    <div class="pc-category">{{ $p['category'] ?? '' }}</div>
                                    <div class="pc-stars">@php $r = floor($p['rating'] ?? 4); @endphp @for ($i=1;$i<=5;$i++)<i class="icon anm {{ $i<=$r ? 'anm-star' : 'anm-star-o' }}"></i>@endfor</div>
                                    <button class="pc-btn add-to-cart-fr" data-name="{{ $p['name'] }}">Ajouter au panier</button>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div class="col-12 col-md-5 col-lg-4">
                <div class="banner-vertical-fr" style="background-image:url('https://images.unsplash.com/photo-1556228578-0d85b1a4d571?w=800&q=80');">
                    <div class="banner-vertical-content">
                        <h3>LES MEILLEURES<br>OFFRES EN<br>SOINS PERSONNELS</h3>
                        <p>Des produits de beauté et d'hygiène sélectionnés pour vous</p>
                        <a href="{{ customUrl('categories/soins-personnels/products') }}" wire:navigate class="btn-dark-fr">Acheter maintenant</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

{{-- 10. PRODUITS COMBINÉS --}}
<section class="section-mb">
    <div class="container-fluid">
        <div class="section-title-fr"><h2>PRODUITS COMBINÉS</h2><p>Des packs avantageux pour faire des économies</p></div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-5 g-3">
            @foreach (array_slice($allProducts, 2, 5) as $product)
                @php $p = is_array($product) ? $product : (array) $product; @endphp
                <div class="col">
                    <div class="prod-card">
                        <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate><img class="pc-img" src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy"></a>
                        <div class="pc-body">
                            <div class="pc-brand">{{ $p['brand'] ?? '' }}</div>
                            <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate class="text-decoration-none"><div class="pc-name">{{ $p['name'] }}</div></a>
                            <div class="pc-price">
                                @if (!empty($p['special_price']) && $p['special_price'] > 0 && $p['special_price'] < $p['price'])
                                    <span class="pc-current">{{ number_format($p['special_price'], 2) }} €</span><span class="pc-old">{{ number_format($p['price'], 2) }} €</span>
                                @else
                                    <span class="pc-current">{{ number_format($p['price'], 2) }} €</span>
                                @endif
                            </div>
                            <div class="pc-stars">@php $r = floor($p['rating'] ?? 4); @endphp @for ($i=1;$i<=5;$i++)<i class="icon anm {{ $i<=$r ? 'anm-star' : 'anm-star-o' }}"></i>@endfor</div>
                            <button class="pc-btn add-to-cart-fr" data-name="{{ $p['name'] }}">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 11. SOLDES ÉPICERIE --}}
<section class="section-mb-sm" style="background:#fafafa;">
    <div class="container-fluid">
        <div class="section-title-fr"><h2>SOLDES DE 50 % SUR L'ÉPICERIE</h2><p>Profitez de réductions exceptionnelles sur une sélection de produits</p></div>
        <div class="row row-cols-2 row-cols-md-3 row-cols-lg-4 g-3">
            @foreach (array_slice($allProducts, 4, 4) as $product)
                @php $p = is_array($product) ? $product : (array) $product; @endphp
                <div class="col">
                    <div class="prod-card">
                        <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate><img class="pc-img" src="{{ $p['image'] }}" alt="{{ $p['name'] }}" loading="lazy"></a>
                        <div class="pc-body">
                            <div class="pc-brand">{{ $p['brand'] ?? '' }}</div>
                            <a href="{{ customUrl('products/' . $p['slug']) }}" wire:navigate class="text-decoration-none"><div class="pc-name">{{ $p['name'] }}</div></a>
                            <div class="pc-price">
                                @if (!empty($p['special_price']) && $p['special_price'] > 0 && $p['special_price'] < $p['price'])
                                    <span class="pc-current">{{ number_format($p['special_price'], 2) }} €</span><span class="pc-old">{{ number_format($p['price'], 2) }} €</span>
                                @else
                                    <span class="pc-current" style="color:#222;">{{ number_format($p['price'], 2) }} €</span>
                                @endif
                            </div>
                            <div class="pc-stars">@php $r = floor($p['rating'] ?? 4); @endphp @for ($i=1;$i<=5;$i++)<i class="icon anm {{ $i<=$r ? 'anm-star' : 'anm-star-o' }}"></i>@endfor</div>
                            <button class="pc-btn add-to-cart-fr" data-name="{{ $p['name'] }}">Ajouter au panier</button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

{{-- 12. DYNAMIC SECTIONS DB --}}
@if ($hasSections)
    @foreach ($sections as $row)
        @if (!empty($row->product_details) && count((array) $row->product_details) > 0)
            @if ($row->style === 'style_1')
                <section class="section product-slider section-mb-sm" style="background:#fafafa;">
                    <div class="container-fluid">
                        <x-utility.section_header.sectionHeaderOne :title="$row" />
                        <div class="swiper style1-mySwiper">
                            <div class="swiper-wrapper">
                                @foreach ($row->product_details as $details)
                                    <div class="swiper-slide"><x-dynamic-component :component="getProductDisplayComponent($store_settings)" :details="(object) $details" /></div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </section>
            @endif
            @if ($row->style === 'style_3')
                <section class="section product-banner-slider section-mb-sm">
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-lg-3"><img class="w-100 rounded" src="{{ $row->banner_image }}" alt="{{ $row->title }}"></div>
                            <div class="col-lg-9">
                                <div class="swiper style2-mySwiper">
                                    <div class="swiper-wrapper">
                                        @foreach ($row->product_details as $details)
                                            <div class="swiper-slide"><x-dynamic-component :component="getProductDisplayComponent($store_settings)" :details="(object) $details" /></div>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
            @endif
        @endif
    @endforeach
@endif




{{-- 14. MARQUES POPULAIRES (Carrousel horizontal) --}}
<section class="section-mb-sm brands-carousel-section">
    <div class="container-fluid">
        <div class="section-title-fr"><h2>MARQUES POPULAIRES</h2><p>Découvrez nos meilleures marques</p></div>
        <div class="swiper brands-carousel">
            <div class="swiper-wrapper">
                @foreach ($activeBrands as $brand)
                    @php
                        $bn = is_array($brand) ? ($brand['name'] ?? $brand['brand_name'] ?? '') : ($brand->name ?? '');
                        $bs = is_array($brand) ? ($brand['slug'] ?? $brand['brand_slug'] ?? '') : ($brand->slug ?? '');
                        $bi = is_array($brand) ? ($brand['image'] ?? $brand['brand_img'] ?? '') : ($brand->image ?? '');
                    @endphp
                    <div class="swiper-slide">
                        <a href="{{ customUrl('products/?brand=' . $bs) }}" wire:navigate class="brand-carousel-item">
                            <img src="{{ $bi }}" alt="{{ $bn }}" loading="lazy">
                            <span>{{ $bn }}</span>
                        </a>
                    </div>
                @endforeach
            </div>
            <div class="swiper-button-next"></div>
            <div class="swiper-button-prev"></div>
        </div>
    </div>
</section>

{{-- 15. NEWSLETTER --}}
<section style="background:#f7f7f7;padding:60px 0;text-align:center;">
    <div class="container">
        <h3 style="font-size:26px;font-weight:700;color:#222;margin-bottom:6px;">Abonnez-vous à notre newsletter</h3>
        <p style="color:#888;margin-bottom:24px;font-size:14px;">Recevez les dernières actualités et offres exclusives</p>
        <form style="display:flex;max-width:500px;margin:0 auto;border-radius:50px;overflow:hidden;box-shadow:0 4px 20px rgba(0,0,0,0.06);" onsubmit="event.preventDefault();alert('Merci de votre abonnement !');">
            <input type="email" placeholder="Votre adresse email" required style="flex:1;padding:14px 20px;border:none;font-size:14px;outline:none;">
            <button type="submit" style="padding:14px 28px;background:#222;color:#fff;border:none;font-size:13px;font-weight:600;text-transform:uppercase;cursor:pointer;white-space:nowrap;">S'abonner</button>
        </form>
    </div>
</section>

{{-- 16. SERVICES --}}
@if (isset($settings))
    @php $ws = (array) $settings; @endphp
    @if (($ws['support_mode'] ?? 0) || ($ws['shipping_mode'] ?? 0) || ($ws['safety_security_mode'] ?? 0) || ($ws['return_mode'] ?? 0))
        <section class="section-mb-sm">
            <div class="container-fluid">
                <div class="service-info row col-row row-cols-lg-4 row-cols-md-4 row-cols-sm-2 row-cols-2 text-center">
                    @if ($ws['support_mode'] ?? 0)
                        <div class="service-wrap col-item"><div class="service-icon mb-3"><i class="icon anm anm-phone-call-l"></i></div><div class="service-content"><h3 class="title mb-2">{{ $ws['support_title'] ?? 'Support 24/7' }}</h3><span class="text-muted">{{ $ws['support_description'] ?? 'Assistance à tout moment' }}</span></div></div>
                    @endif
                    @if ($ws['shipping_mode'] ?? 0)
                        <div class="service-wrap col-item"><div class="service-icon mb-3"><i class="icon anm anm-truck-l"></i></div><div class="service-content"><h3 class="title mb-2">{{ $ws['shipping_title'] ?? 'Livraison gratuite' }}</h3><span class="text-muted">{{ $ws['shipping_description'] ?? 'Pour toute commande de plus de 99 €' }}</span></div></div>
                    @endif
                    @if ($ws['safety_security_mode'] ?? 0)
                        <div class="service-wrap col-item"><div class="service-icon mb-3"><i class="icon anm anm-credit-card-l"></i></div><div class="service-content"><h3 class="title mb-2">{{ $ws['safety_security_title'] ?? 'Paiement sécurisé' }}</h3><span class="text-muted">{{ $ws['safety_security_description'] ?? 'Transactions 100 % sécurisées' }}</span></div></div>
                    @endif
                    @if ($ws['return_mode'] ?? 0)
                        <div class="service-wrap col-item"><div class="service-icon mb-3"><i class="icon anm anm-redo-l"></i></div><div class="service-content"><h3 class="title mb-2">{{ $ws['return_title'] ?? 'Retours faciles' }}</h3><span class="text-muted">{{ $ws['return_description'] ?? 'Politique de retour de 30 jours' }}</span></div></div>
                    @endif
                </div>
            </div>
        </section>
    @endif
@endif

</div>

@script
<script>
(function() {
    'use strict';
    document.querySelectorAll('.add-to-cart-fr').forEach(function(btn) {
        btn.addEventListener('click', function(e) {
            e.preventDefault();
            var name = this.getAttribute('data-name') || 'Produit';
            alert(name + ' ajouté au panier !');
        });
    });
    if (typeof Swiper !== 'undefined') {
        var heroEl = document.querySelector('.hero-swiper');
        if (heroEl) {
            if (heroEl.swiper) { try { heroEl.swiper.destroy(true, true); } catch(e) {} }
            var cnt = heroEl.querySelectorAll('.swiper-wrapper > .swiper-slide').length;
            if (cnt > 0) {
                new Swiper(heroEl, { loop: cnt > 1, autoplay: cnt > 1 ? { delay: 5000, disableOnInteraction: false } : false, pagination: { el: '.hero-swiper-pagination', clickable: true } });
            }
        }
        var s1 = document.querySelector('.style1-mySwiper');
        if (s1 && !s1.swiper) { var c = s1.querySelectorAll('.swiper-wrapper > .swiper-slide').length; if (c > 0) { new Swiper(s1, { slidesPerView: 5, spaceBetween: 30, navigation: true, breakpoints: { 200: { slidesPerView: 2 }, 440: { slidesPerView: 2 }, 540: { slidesPerView: 3 }, 768: { slidesPerView: 4 }, 1200: { slidesPerView: 5 } } }); } }
        var s2 = document.querySelector('.style2-mySwiper');
        if (s2 && !s2.swiper) { var c2 = s2.querySelectorAll('.swiper-wrapper > .swiper-slide').length; if (c2 > 0) { new Swiper(s2, { slidesPerView: 4, spaceBetween: 30, navigation: true, breakpoints: { 200: { slidesPerView: 2 }, 440: { slidesPerView: 2 }, 768: { slidesPerView: 3 }, 1200: { slidesPerView: 4 } } }); } }
        // Brands carousel
        var brandsEl = document.querySelector('.brands-carousel');
        if (brandsEl) {
            if (brandsEl.swiper) { try { brandsEl.swiper.destroy(true, true); } catch(e) {} }
            var bcnt = brandsEl.querySelectorAll('.swiper-wrapper > .swiper-slide').length;
            if (bcnt > 0) {
                new Swiper(brandsEl, {
                    slidesPerView: 8,
                    spaceBetween: 40,
                    navigation: { nextEl: '.swiper-button-next', prevEl: '.swiper-button-prev' },
                    loop: bcnt > 8,
                    autoplay: { delay: 4000, disableOnInteraction: false },
                    breakpoints: {
                        200: { slidesPerView: 3, spaceBetween: 20 },
                        440: { slidesPerView: 4, spaceBetween: 20 },
                        768: { slidesPerView: 5, spaceBetween: 30 },
                        1024: { slidesPerView: 6, spaceBetween: 35 },
                        1200: { slidesPerView: 8, spaceBetween: 40 },
                    }
                });
            }
        }
    }
})();
</script>
@endscript
