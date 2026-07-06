@push('sidebar')
<aside class="aurora-sidebar" :class="{ 'open': sidebarOpen }">
    <button class="aurora-sidebar-close" @click="sidebarOpen = false">
        <i class='bx bx-x'></i>
    </button>
    <div class="aurora-sidebar-logo">
        <img src="{{ asset('assets/img/aurora-logo.svg') }}" alt="Aurora Marketplace">
        <span>Aurora</span>
    </div>
    <nav class="aurora-sidebar-nav">
        @php
            $logged_in_user = auth()->user();
            $user_role = '';
            if ($logged_in_user) {
                if ($logged_in_user->role) {
                    $user_role = $logged_in_user->role->name;
                } elseif ($logged_in_user->role_id) {
                    $roleModel = \App\Models\Role::find($logged_in_user->role_id);
                    $user_role = $roleModel?->name ?? '';
                } elseif (method_exists($logged_in_user, 'getRoleNames')) {
                    $user_role = $logged_in_user->getRoleNames()->first() ?? '';
                }
            }
        @endphp

        {{-- Dashboard --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.overview', 'Aperçu') }}</div>
        <a href="{{ route('admin.home') }}" class="aurora-sidebar-item {{ Request::is('admin/home') ? 'active' : '' }}">
            <i class='bx bx-grid-alt'></i>
            <span>{{ labels('admin_labels.dashboard', 'Dashboard') }}</span>
        </a>

        {{-- Gestion des magasins --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.stores', 'Magasins') }}</div>
        @php
            $settings = app(\App\Services\SettingService::class)->getSettings('admin_preference', true);
            if (is_string($settings)) { $settings = json_decode($settings); }
        @endphp
        @if (($settings->store_mode ?? '') != 'single')
        <a href="{{ route('admin.stores.index') }}" class="aurora-sidebar-item {{ Request::is('admin/stores') && !Request::is('admin/stores/manage_store*') ? 'active' : '' }}">
            <i class='bx bx-store'></i>
            <span>{{ labels('admin_labels.add_store', 'Ajouter un magasin') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view store') ?? false))
        <a href="{{ route('admin.stores.manage_store') }}" class="aurora-sidebar-item {{ Request::is('admin/stores/manage_store*') ? 'active' : '' }}">
            <i class='bx bx-store-alt'></i>
            <span>{{ labels('admin_labels.manage_stores', 'Gérer les magasins') }}</span>
        </a>
        @endif
        <a href="{{ route('admin.custom_fields.index') }}" class="aurora-sidebar-item {{ Request::is('admin/store/custom_fields*') ? 'active' : '' }}">
            <i class='bx bx-list-ul'></i>
            <span>{{ labels('admin_labels.custom_fields', 'Champs personnalisés') }}</span>
        </a>

        {{-- Catégories --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.categories', 'Catégories') }}</div>
        <a href="{{ route('categories.index') }}" class="aurora-sidebar-item {{ Request::is('admin/categories') && !Request::is('admin/categories/category_order*') && !Request::is('admin/categories/category_slider*') ? 'active' : '' }}">
            <i class='bx bx-category'></i>
            <span>{{ labels('admin_labels.categories', 'Catégories') }}</span>
        </a>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view category_order') ?? false))
        <a href="{{ route('category_order.index') }}" class="aurora-sidebar-item {{ Request::is('admin/categories/category_order*') ? 'active' : '' }}">
            <i class='bx bx-sort'></i>
            <span>{{ labels('admin_labels.categories_order', 'Ordre des catégories') }}</span>
        </a>
        @endif
        <a href="{{ route('category_slider.index') }}" class="aurora-sidebar-item {{ Request::is('admin/categories/category_slider*') ? 'active' : '' }}">
            <i class='bx bx-slider'></i>
            <span>{{ labels('admin_labels.categories_sliders', 'Sliders catégories') }}</span>
        </a>

        {{-- Marques --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.brand', 'Marques') }}</div>
        <a href="{{ route('brands.index') }}" class="aurora-sidebar-item {{ Request::is('admin/brands') ? 'active' : '' }}">
            <i class='bx bx-git-compare'></i>
            <span>{{ labels('admin_labels.brand', 'Marques') }}</span>
        </a>

        {{-- PRODUITS --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.products', 'Produits') }}</div>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view tax') ?? false))
        <a href="{{ route('taxes.index') }}" class="aurora-sidebar-item {{ Request::is('admin/taxes*') ? 'active' : '' }}">
            <i class='bx bx-calculator'></i>
            <span>{{ labels('admin_labels.tax', 'Taxes') }}</span>
        </a>
        @endif
        <a href="{{ route('admin.attributes.index') }}" class="aurora-sidebar-item {{ Request::is('admin/attributes*') ? 'active' : '' }}">
            <i class='bx bx-list-check'></i>
            <span>{{ labels('admin_labels.attributes_manage', 'Attributs') }}</span>
        </a>

        {{-- Sous-menu Produits --}}
        <a href="{{ route('admin.products.index') }}" class="aurora-sidebar-item {{ Request::is('admin/products') && !Request::is('admin/products/manage_product*') ? 'active' : '' }}">
            <i class='bx bx-package'></i>
            <span>{{ labels('admin_labels.add_products', 'Ajouter produits') }}</span>
        </a>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view product') ?? false))
        <a href="{{ route('admin.products.manage_product') }}" class="aurora-sidebar-item {{ Request::is('admin/products/manage_product*') ? 'active' : '' }}">
            <i class='bx bx-grid'></i>
            <span>{{ labels('admin_labels.manage_products', 'Gérer produits') }}</span>
        </a>
        @endif
        <a href="{{ route('admin.product_faqs.index') }}" class="aurora-sidebar-item {{ Request::is('admin/product_faqs*') ? 'active' : '' }}">
            <i class='bx bx-help-circle'></i>
            <span>{{ labels('admin_labels.product_faqs', 'FAQs produits') }}</span>
        </a>
        <a href="{{ route('admin.product_bulk_upload') }}" class="aurora-sidebar-item {{ Request::is('admin/product/product_bulk_upload*') ? 'active' : '' }}">
            <i class='bx bx-upload'></i>
            <span>{{ labels('admin_labels.bulk_upload', 'Import en masse') }}</span>
        </a>

        {{-- Gestion des stocks --}}
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view stock') ?? false))
        <a href="{{ route('admin.manage_stock.index') }}" class="aurora-sidebar-item {{ Request::is('admin/manage_stock*') ? 'active' : '' }}">
            <i class='bx bx-cube'></i>
            <span>{{ labels('admin_labels.stock_manage', 'Gestion des stocks') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view combo_stock') ?? false))
        <a href="{{ route('admin.manage_combo_stock.index') }}" class="aurora-sidebar-item {{ Request::is('admin/manage_combo_stock*') ? 'active' : '' }}">
            <i class='bx bx-cube-alt'></i>
            <span>{{ labels('admin_labels.combo_stock_manage', 'Stocks combinés') }}</span>
        </a>
        @endif

        {{-- PRODUITS COMBINÉS --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.combo_products_manage', 'Produits combinés') }}</div>
        <a href="{{ route('admin.combo_product_attributes.index') }}" class="aurora-sidebar-item {{ Request::is('admin/combo_product_attributes*') ? 'active' : '' }}">
            <i class='bx bx-list-check'></i>
            <span>{{ labels('admin_labels.attributes_manage', 'Attributs') }}</span>
        </a>
        <a href="{{ route('admin.combo_products.index') }}" class="aurora-sidebar-item {{ Request::is('admin/combo_products') && !Request::is('admin/combo_products/manage_product*') ? 'active' : '' }}">
            <i class='bx bx-package'></i>
            <span>{{ labels('admin_labels.add_combo_products', 'Ajouter combinés') }}</span>
        </a>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view combo_product') ?? false))
        <a href="{{ route('admin.combo_products.manage_product') }}" class="aurora-sidebar-item {{ Request::is('admin/combo_products/manage_product*') ? 'active' : '' }}">
            <i class='bx bx-grid'></i>
            <span>{{ labels('admin_labels.manage_products', 'Gérer combinés') }}</span>
        </a>
        @endif
        <a href="{{ route('admin.combo_product_faqs.index') }}" class="aurora-sidebar-item {{ Request::is('admin/combo_product_faqs*') ? 'active' : '' }}">
            <i class='bx bx-help-circle'></i>
            <span>{{ labels('admin_labels.product_faqs', 'FAQs combinés') }}</span>
        </a>

        {{-- Commandes --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.orders_manage', 'Commandes') }}</div>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view orders') ?? false))
        <a href="{{ route('admin.orders.index') }}" class="aurora-sidebar-item {{ Request::is('admin/orders') ? 'active' : '' }}">
            <i class='bx bx-cart'></i>
            <span>{{ labels('admin_labels.orders', 'Commandes') }}</span>
        </a>
        <a href="{{ route('admin.order_items.index') }}" class="aurora-sidebar-item {{ Request::is('admin/order_items*') ? 'active' : '' }}">
            <i class='bx bx-detail'></i>
            <span>{{ labels('admin_labels.order_items', 'Articles commandés') }}</span>
        </a>
        <a href="{{ route('admin.orders.order_tracking') }}" class="aurora-sidebar-item {{ Request::is('admin/orders/order_tracking*') ? 'active' : '' }}">
            <i class='bx bx-map'></i>
            <span>{{ labels('admin_labels.order_tracking', 'Suivi commandes') }}</span>
        </a>
        @endif

        {{-- VENDEURS --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.sellers', 'Vendeurs') }}</div>
        <a href="{{ route('admin.sellers.create') }}" class="aurora-sidebar-item {{ Request::is('admin/seller/create*') ? 'active' : '' }}">
            <i class='bx bx-user-plus'></i>
            <span>{{ labels('admin_labels.add_sellers', 'Ajouter vendeur') }}</span>
        </a>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view seller') ?? false))
        <a href="{{ route('sellers.index') }}" class="aurora-sidebar-item {{ Request::is('admin/sellers') && !Request::is('admin/sellers/seller_wallet_transaction*') ? 'active' : '' }}">
            <i class='bx bx-store-alt'></i>
            <span>{{ labels('admin_labels.sellers', 'Vendeurs') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view seller_wallet_transaction') ?? false))
        <a href="{{ route('admin.sellers.sellerWallet') }}" class="aurora-sidebar-item {{ Request::is('admin/sellers/seller_wallet_transaction*') ? 'active' : '' }}">
            <i class='bx bx-wallet'></i>
            <span>{{ labels('admin_labels.wallet_transactions', 'Portefeuille vendeurs') }}</span>
        </a>
        @endif

        {{-- Livreurs --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.delivery_boys', 'Livreurs') }}</div>
        <a href="{{ route('delivery_boys.index') }}" class="aurora-sidebar-item {{ Request::is('admin/delivery_boys') && !Request::is('admin/delivery_boys/manage_cash*') && !Request::is('admin/delivery_boys/fund_transfers*') ? 'active' : '' }}">
            <i class='bx bx-cycling'></i>
            <span>{{ labels('admin_labels.delivery_boys', 'Livreurs') }}</span>
        </a>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view delivery_boy_cash_collection') ?? false))
        <a href="{{ route('admin.get_cash_collection.index') }}" class="aurora-sidebar-item {{ Request::is('admin/delivery_boys/manage_cash*') ? 'active' : '' }}">
            <i class='bx bx-money'></i>
            <span>{{ labels('admin_labels.cash_collection', 'Collecte espèces') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view fund_transfer') ?? false))
        <a href="{{ route('admin.delivery_boys.fund_transfers.index') }}" class="aurora-sidebar-item {{ Request::is('admin/delivery_boys/fund_transfers*') ? 'active' : '' }}">
            <i class='bx bx-transfer'></i>
            <span>{{ labels('admin_labels.fund_transfer', 'Transferts fonds') }}</span>
        </a>
        @endif

        {{-- Clients --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.customers', 'Clients') }}</div>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view customers') ?? false))
        <a href="{{ route('admin.customers') }}" class="aurora-sidebar-item {{ Request::is('admin/customers') ? 'active' : '' }}">
            <i class='bx bx-user'></i>
            <span>{{ labels('admin_labels.view_customers', 'Voir clients') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view address') ?? false))
        <a href="{{ route('admin.customers.getCustomersAddresses') }}" class="aurora-sidebar-item {{ Request::is('admin/customers/customers_addresses*') ? 'active' : '' }}">
            <i class='bx bx-map-pin'></i>
            <span>{{ labels('admin_labels.addresses', 'Adresses') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view customer_transaction') ?? false))
        <a href="{{ route('admin.customers.viewTransactions') }}" class="aurora-sidebar-item {{ Request::is('admin/customers/view_transactions*') ? 'active' : '' }}">
            <i class='bx bx-receipt'></i>
            <span>{{ labels('admin_labels.transactions', 'Transactions') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view customer_wallet_transaction') ?? false))
        <a href="{{ route('admin.customers.walletTransaction') }}" class="aurora-sidebar-item {{ Request::is('admin/customers/wallet_transaction*') ? 'active' : '' }}">
            <i class='bx bx-wallet-alt'></i>
            <span>{{ labels('admin_labels.wallet_transactions', 'Portefeuille clients') }}</span>
        </a>
        @endif

        {{-- OFFRES & PROMOTIONS --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.offers', 'Offres & Promotions') }}</div>
        <a href="{{ route('offers.index') }}" class="aurora-sidebar-item {{ Request::is('admin/offers') ? 'active' : '' }}">
            <i class='bx bx-gift'></i>
            <span>{{ labels('admin_labels.offers', 'Offres') }}</span>
        </a>
        <a href="{{ route('offer_sliders.index') }}" class="aurora-sidebar-item {{ Request::is('admin/offer_sliders*') ? 'active' : '' }}">
            <i class='bx bx-images'></i>
            <span>{{ labels('admin_labels.offer_sliders', 'Sliders offres') }}</span>
        </a>
        <a href="{{ route('promo_codes.index') }}" class="aurora-sidebar-item {{ Request::is('admin/promo_codes*') ? 'active' : '' }}">
            <i class='bx bx-coupon'></i>
            <span>{{ labels('admin_labels.promo_codes', 'Codes promo') }}</span>
        </a>

        {{-- Sliders / Bannières --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.slider', 'Bannières') }}</div>
        <a href="{{ route('sliders.index') }}" class="aurora-sidebar-item {{ Request::is('admin/sliders*') ? 'active' : '' }}">
            <i class='bx bx-images'></i>
            <span>{{ labels('admin_labels.add_slider', 'Ajouter bannière') }}</span>
        </a>

        {{-- Section à la une --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.featured_section', 'Sections à la une') }}</div>
        <a href="{{ route('feature_section.index') }}" class="aurora-sidebar-item {{ Request::is('admin/feature_section') ? 'active' : '' }}">
            <i class='bx bx-star'></i>
            <span>{{ labels('admin_labels.featured', 'À la une') }}</span>
        </a>
        <a href="{{ route('feature_section.section_order') }}" class="aurora-sidebar-item {{ Request::is('admin/feature_section/section_order*') ? 'active' : '' }}">
            <i class='bx bx-sort'></i>
            <span>{{ labels('admin_labels.sections_order', 'Ordre sections') }}</span>
        </a>

        {{-- BLOG --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.blogs', 'Blog') }}</div>
        <a href="{{ route('admin.blogs.index') }}" class="aurora-sidebar-item {{ Request::is('admin/blogs') ? 'active' : '' }}">
            <i class='bx bx-folder'></i>
            <span>{{ labels('admin_labels.blog_categories', 'Catégories blog') }}</span>
        </a>
        <a href="{{ route('manage_blogs.index') }}" class="aurora-sidebar-item {{ Request::is('admin/manage_blogs*') ? 'active' : '' }}">
            <i class='bx bx-edit'></i>
            <span>{{ labels('admin_labels.create_blog', 'Créer un article') }}</span>
        </a>

        {{-- Localisation --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.location_management', 'Localisation') }}</div>
        <a href="{{ route('admin.display_zipcodes') }}" class="aurora-sidebar-item {{ Request::is('admin/area/zipcodes*') ? 'active' : '' }}">
            <i class='bx bx-map-pin'></i>
            <span>{{ labels('admin_labels.zipcodes', 'Codes postaux') }}</span>
        </a>
        <a href="{{ route('admin.display_city') }}" class="aurora-sidebar-item {{ Request::is('admin/area/city*') ? 'active' : '' }}">
            <i class='bx bx-building'></i>
            <span>{{ labels('admin_labels.city', 'Villes') }}</span>
        </a>
        <a href="{{ route('admin.pickup_location.index') }}" class="aurora-sidebar-item {{ Request::is('admin/pickup_location*') ? 'active' : '' }}">
            <i class='bx bx-location-plus'></i>
            <span>{{ labels('admin_labels.pickup_locations', 'Points retrait') }}</span>
        </a>
        <a href="{{ route('admin.zones.index') }}" class="aurora-sidebar-item {{ Request::is('admin/zones*') ? 'active' : '' }}">
            <i class='bx bx-map'></i>
            <span>{{ labels('admin_labels.zones', 'Zones') }}</span>
        </a>
        <a href="{{ route('admin.location_bulk_upload.index') }}" class="aurora-sidebar-item {{ Request::is('admin/area/location_bulk_upload*') ? 'active' : '' }}">
            <i class='bx bx-upload'></i>
            <span>{{ labels('admin_labels.bulk_upload', 'Import localisation') }}</span>
        </a>

        {{-- Médias --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.media_manage', 'Médias') }}</div>
        <a href="{{ route('admin.media') }}" class="aurora-sidebar-item {{ Request::is('admin/media') ? 'active' : '' }}">
            <i class='bx bx-image'></i>
            <span>{{ labels('admin_labels.add_media', 'Ajouter média') }}</span>
        </a>
        <a href="{{ route('admin.storage_type') }}" class="aurora-sidebar-item {{ Request::is('admin/storage_type*') ? 'active' : '' }}">
            <i class='bx bx-cloud'></i>
            <span>{{ labels('admin_labels.storage_type', 'Type stockage') }}</span>
        </a>

        {{-- Support Tickets --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.support_tickets', 'Support') }}</div>
        <a href="{{ route('ticket_types.index') }}" class="aurora-sidebar-item {{ Request::is('admin/tickets/ticket_types*') ? 'active' : '' }}">
            <i class='bx bx-category-alt'></i>
            <span>{{ labels('admin_labels.ticket_types', 'Types tickets') }}</span>
        </a>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view tickets') ?? false))
        <a href="{{ route('admin.tickets.viewTickets') }}" class="aurora-sidebar-item {{ Request::is('admin/tickets') && !Request::is('admin/tickets/ticket_types*') ? 'active' : '' }}">
            <i class='bx bx-support'></i>
            <span>{{ labels('admin_labels.tickets', 'Tickets') }}</span>
        </a>
        @endif

        {{-- Chat --}}
        <a href="{{ route('admin.chat.index') }}" class="aurora-sidebar-item {{ Request::is('admin/chat*') ? 'active' : '' }}">
            <i class='bx bx-chat'></i>
            <span>{{ labels('admin_labels.chats', 'Chat') }}</span>
        </a>

        {{-- Demandes retour --}}
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view return_request') ?? false))
        <div class="aurora-sidebar-section">{{ labels('admin_labels.return_requests', 'Retours') }}</div>
        <a href="{{ route('admin.return_request.index') }}" class="aurora-sidebar-item {{ Request::is('admin/return_request*') ? 'active' : '' }}">
            <i class='bx bx-revision'></i>
            <span>{{ labels('admin_labels.return_requests', 'Demandes retour') }}</span>
        </a>
        @endif

        {{-- Demandes paiement --}}
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view payment_request') ?? false))
        <div class="aurora-sidebar-section">{{ labels('admin_labels.payment_request', 'Paiements') }}</div>
        <a href="{{ route('admin.payment_request.index') }}" class="aurora-sidebar-item {{ Request::is('admin/payment_request*') ? 'active' : '' }}">
            <i class='bx bx-credit-card'></i>
            <span>{{ labels('admin_labels.payment_request', 'Demandes paiement') }}</span>
        </a>
        @endif

        {{-- FAQ --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.faqs', 'FAQ') }}</div>
        <a href="{{ route('faqs.index') }}" class="aurora-sidebar-item {{ Request::is('admin/faq*') ? 'active' : '' }}">
            <i class='bx bx-help-circle'></i>
            <span>{{ labels('admin_labels.faqs', 'FAQ') }}</span>
        </a>

        {{-- Notifications --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.send_notification', 'Notifications') }}</div>
        <a href="{{ route('notifications.index') }}" class="aurora-sidebar-item {{ Request::is('admin/send_notification*') ? 'active' : '' }}">
            <i class='bx bx-bell'></i>
            <span>{{ labels('admin_labels.notification', 'Notification') }}</span>
        </a>
        <a href="{{ route('seller_notifications.index') }}" class="aurora-sidebar-item {{ Request::is('admin/send_seller_notification*') ? 'active' : '' }}">
            <i class='bx bx-store'></i>
            <span>{{ labels('admin_labels.seller_notification', 'Aux vendeurs') }}</span>
        </a>
        <a href="{{ route('seller_email_notifications.index') }}" class="aurora-sidebar-item {{ Request::is('admin/seller_email_notification*') ? 'active' : '' }}">
            <i class='bx bx-envelope'></i>
            <span>{{ labels('admin_labels.seller_email_notification', 'Email vendeurs') }}</span>
        </a>

        {{-- Messages personnalisés --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.custom_message', 'Messages') }}</div>
        <a href="{{ route('admin.custom_message.index') }}" class="aurora-sidebar-item {{ Request::is('admin/custom_message*') ? 'active' : '' }}">
            <i class='bx bx-message-dots'></i>
            <span>{{ labels('admin_labels.add_custom_message', 'Message personnalisé') }}</span>
        </a>

        {{-- Affiliation --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.affiliate', 'Affiliation') }}</div>
        <a href="{{ route('admin.affiliate.manage_user') }}" class="aurora-sidebar-item {{ Request::is('admin/manage_affiliate_users*') || Request::is('admin/add_affiliate_user*') || Request::is('admin/affiliate_users*') ? 'active' : '' }}">
            <i class='bx bx-group'></i>
            <span>{{ labels('admin_labels.affiliate_users', 'Utilisateurs affiliés') }}</span>
        </a>
        <a href="{{ route('admin.affiliate.settings') }}" class="aurora-sidebar-item {{ Request::is('admin/affiliate_settings*') ? 'active' : '' }}">
            <i class='bx bx-cog'></i>
            <span>{{ labels('admin_labels.settings', 'Paramètres') }}</span>
        </a>
        <a href="{{ route('admin.affiliate.reports') }}" class="aurora-sidebar-item {{ Request::is('admin/affiliate/reports*') ? 'active' : '' }}">
            <i class='bx bx-bar-chart-alt-2'></i>
            <span>{{ labels('admin_labels.reports', 'Rapports') }}</span>
        </a>
        <a href="{{ route('admin.affiliate.policies') }}" class="aurora-sidebar-item {{ Request::is('admin/affiliate_policies*') ? 'active' : '' }}">
            <i class='bx bx-file'></i>
            <span>{{ labels('admin_labels.policies', 'Politiques') }}</span>
        </a>

        {{-- Paramètres --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.system_settings', 'Paramètres') }}</div>
        <a href="{{ route('settings.index') }}" class="aurora-sidebar-item {{ Request::is('admin/settings') ? 'active' : '' }}">
            <i class='bx bx-cog'></i>
            <span>{{ labels('admin_labels.settings', 'Paramètres système') }}</span>
        </a>

        {{-- Paramètres web --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.web_settings', 'Site web') }}</div>
        <a href="{{ route('general_settings') }}" class="aurora-sidebar-item {{ Request::is('admin/web_settings/general_settings*') ? 'active' : '' }}">
            <i class='bx bx-sliders'></i>
            <span>{{ labels('admin_labels.general_settings', 'Paramètres généraux') }}</span>
        </a>
        <a href="{{ route('pwa_settings') }}" class="aurora-sidebar-item {{ Request::is('admin/web_settings/pwa_settings*') ? 'active' : '' }}">
            <i class='bx bx-mobile-alt'></i>
            <span>{{ labels('admin_labels.pwa_settings', 'PWA') }}</span>
        </a>
        <a href="{{ route('firebase') }}" class="aurora-sidebar-item {{ Request::is('admin/web_settings/firebase*') ? 'active' : '' }}">
            <i class='bx bx-data'></i>
            <span>{{ labels('admin_labels.firebase', 'Firebase') }}</span>
        </a>
        <a href="{{ route('web_language') }}" class="aurora-sidebar-item {{ Request::is('admin/web_settings/language*') ? 'active' : '' }}">
            <i class='bx bx-globe'></i>
            <span>{{ labels('admin_labels.languages', 'Langues site') }}</span>
        </a>

        {{-- SEO --}}
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view seo') ?? false))
        <div class="aurora-sidebar-section">{{ labels('admin_labels.seo_management', 'SEO') }}</div>
        <a href="{{ route('admin.seo.index') }}" class="aurora-sidebar-item {{ Request::is('admin/seo*') ? 'active' : '' }}">
            <i class='bx bx-search-alt'></i>
            <span>{{ labels('admin_labels.seo', 'SEO') }}</span>
        </a>
        @endif

        {{-- Utilisateurs système --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.system_users', 'Utilisateurs') }}</div>
        <a href="{{ route('admin.system_users.index') }}" class="aurora-sidebar-item {{ Request::is('admin/system_users') && !Request::is('admin/manage_system_users*') ? 'active' : '' }}">
            <i class='bx bx-shield'></i>
            <span>{{ labels('admin_labels.system_users', 'Utilisateurs système') }}</span>
        </a>
        @if ($user_role == 'super_admin' || ($logged_in_user->hasPermissionTo('view system_user') ?? false))
        <a href="{{ route('admin.manage_system_users') }}" class="aurora-sidebar-item {{ Request::is('admin/manage_system_users*') ? 'active' : '' }}">
            <i class='bx bx-user-check'></i>
            <span>{{ labels('admin_labels.manage_system_users', 'Gérer utilisateurs') }}</span>
        </a>
        @endif

        {{-- Langues --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.language_settings', 'Langues') }}</div>
        <a href="{{ route('language.index') }}" class="aurora-sidebar-item {{ Request::is('admin/settings/language') ? 'active' : '' }}">
            <i class='bx bx-globe'></i>
            <span>{{ labels('admin_labels.language', 'Langues admin') }}</span>
        </a>
        <a href="{{ route('manage_language.index') }}" class="aurora-sidebar-item {{ Request::is('admin/settings/manage_language*') ? 'active' : '' }}">
            <i class='bx bx-edit-alt'></i>
            <span>{{ labels('admin_labels.manage_language', 'Gérer langues') }}</span>
        </a>

        {{-- Rapports --}}
        <div class="aurora-sidebar-section">{{ labels('admin_labels.reports', 'Rapports') }}</div>
        <a href="{{ route('admin.sales_reports.index') }}" class="aurora-sidebar-item {{ Request::is('admin/reports/sales_reports*') ? 'active' : '' }}">
            <i class='bx bx-bar-chart-alt-2'></i>
            <span>{{ labels('admin_labels.sales_reports', 'Rapports ventes') }}</span>
        </a>
    </nav>
</aside>
@endpush
