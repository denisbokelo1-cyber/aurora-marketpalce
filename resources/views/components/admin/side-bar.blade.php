<!-- Aurora Sidebar -->
<aside class="aurora-sidebar">
    <div class="aurora-sidebar-nav">
        @php
            $user = auth()->user();
            use Chatify\ChatifyMessenger;
            use App\Services\MediaService;
            use App\Services\SettingService;
            $setting = app(SettingService::class)->getSettings('system_settings', true);
            $setting = json_decode($setting, true);
            $sms_gateway_settings = app(SettingService::class)->getSettings('sms_gateway_settings');
            $messenger = new ChatifyMessenger();
            $unread = $messenger->totalUnseenMessages();
            $settings = app(SettingService::class)->getSettings('admin_preference', true);
            if (is_string($settings)) { $settings = json_decode($settings); }
            $user_role = 'super_admin';
            $logged_in_user = $user;
        @endphp
        <input type="hidden" id="sms_gateway_data" value='{{ $sms_gateway_settings }}' />

        <!-- Logo -->
        <div class="aurora-sidebar-logo">
            <img src="{{ asset('assets/img/aurora-logo.svg') }}" alt="Aurora">
        </div>

        <!-- Search -->
        <div class="aurora-sidebar-search">
            <i class='bx bx-search'></i>
            <input type="text" id="menuSearch" placeholder="{{ labels('admin_labels.search', 'Rechercher') }}">
        </div>

        <!-- === DASHBOARD === -->
        <div class="aurora-sidebar-section">Dashboard</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/home') ? 'active' : '' }}" href="{{ route('admin.home') }}">
            <i class='bx bx-tachometer'></i>
            <span>{{ labels('admin_labels.dashboard', 'Dashboard') }}</span>
        </a>

        <!-- === STORES === -->
        <div class="aurora-sidebar-section">Stores</div>
        @if (($settings->store_mode ?? '') != 'single')
        <a class="aurora-sidebar-item {{ Request::is('admin/stores') ? 'active' : '' }}" href="{{ route('admin.stores.index') }}">
            <i class='bx bx-store-alt'></i>
            <span>{{ labels('admin_labels.add_store', 'Add Store') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || $user->hasPermissionTo('view store'))
        <a class="aurora-sidebar-item {{ Request::is('admin/stores/manage_store*') ? 'active' : '' }}" href="{{ route('admin.stores.manage_store') }}">
            <i class='bx bx-buildings'></i>
            <span>{{ labels('admin_labels.manage_stores', 'Manage Stores') }}</span>
        </a>
        @endif
        <a class="aurora-sidebar-item {{ Request::is('admin/store/custom_fields*') ? 'active' : '' }}" href="{{ route('admin.custom_fields.index') }}">
            <i class='bx bx-list-ul'></i>
            <span>{{ labels('admin_labels.custom_fields', 'Custom Fields') }}</span>
        </a>

        <!-- === ORDERS === -->
        @if ($user_role == 'super_admin' || $user->hasPermissionTo('view orders'))
        <div class="aurora-sidebar-section">Orders</div>
        <a class="aurora-sidebar-item has-sub {{ Request::is('admin/orders*') || Request::is('admin/order_items*') ? 'active' : '' }}" data-target="orderSub">
            <i class='bx bx-cart'></i>
            <span>{{ labels('admin_labels.orders_manage', 'Orders Manage') }}</span>
            <i class='bx bx-chevron-down arrow'></i>
        </a>
        <div class="aurora-sidebar-sub {{ Request::is('admin/orders*') || Request::is('admin/order_items*') ? 'open' : '' }}" id="orderSub">
            <a class="aurora-sidebar-item {{ Request::is('admin/orders') && !Request::is('admin/orders/*') ? 'active' : '' }}" href="{{ route('admin.orders.index') }}">
                <i class='bx bx-list-ul'></i>
                <span>{{ labels('admin_labels.orders', 'Orders') }}</span>
            </a>
            <a class="aurora-sidebar-item {{ Request::is('admin/order_items*') ? 'active' : '' }}" href="{{ route('admin.order_items.index') }}">
                <i class='bx bx-package'></i>
                <span>{{ labels('admin_labels.order_items', 'Order Items') }}</span>
            </a>
            <a class="aurora-sidebar-item {{ Request::is('admin/orders/order_tracking*') ? 'active' : '' }}" href="{{ route('admin.orders.order_tracking') }}">
                <i class='bx bx-map'></i>
                <span>{{ labels('admin_labels.order_tracking', 'Order Tracking') }}</span>
            </a>
        </div>
        @endif

        <!-- === CATEGORIES === -->
        <a class="aurora-sidebar-item has-sub {{ Request::is('admin/categories*') ? 'active' : '' }}" data-target="catSub">
            <i class='bx bx-category'></i>
            <span>{{ labels('admin_labels.categories', 'Categories') }}</span>
            <i class='bx bx-chevron-down arrow'></i>
        </a>
        <div class="aurora-sidebar-sub {{ Request::is('admin/categories*') ? 'open' : '' }}" id="catSub">
            <a class="aurora-sidebar-item {{ Request::is('admin/categories') && !Request::is('admin/categories/*') ? 'active' : '' }}" href="{{ route('categories.index') }}">
                <i class='bx bx-list-ul'></i>
                <span>{{ labels('admin_labels.categories', 'Categories') }}</span>
            </a>
            @if ($user_role == 'super_admin' || $user->hasPermissionTo('view category_order'))
            <a class="aurora-sidebar-item {{ Request::is('admin/categories/category_order*') ? 'active' : '' }}" href="{{ route('category_order.index') }}">
                <i class='bx bx-sort'></i>
                <span>{{ labels('admin_labels.categories_order', 'Categories Order') }}</span>
            </a>
            @endif
            <a class="aurora-sidebar-item {{ Request::is('admin/categories/category_slider*') ? 'active' : '' }}" href="{{ route('category_slider.index') }}">
                <i class='bx bx-slideshow'></i>
                <span>{{ labels('admin_labels.categories_sliders', 'Categories Sliders') }}</span>
            </a>
            <a class="aurora-sidebar-item {{ Request::is('admin/categories/bulk_upload*') ? 'active' : '' }}" href="{{ route('categories.bulk_upload') }}">
                <i class='bx bx-upload'></i>
                <span>{{ labels('admin_labels.bulk_upload', 'Bulk Upload') }}</span>
            </a>
        </div>

        <!-- === STOCK === -->
        @if ($user_role == 'super_admin' || $user->hasPermissionTo('view stock'))
        <a class="aurora-sidebar-item {{ Request::is('admin/manage_stock*') ? 'active' : '' }}" href="{{ route('admin.manage_stock.index') }}">
            <i class='bx bx-cube'></i>
            <span>{{ labels('admin_labels.stock_manage', 'Stock Manage') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || $user->hasPermissionTo('view combo_stock'))
        <a class="aurora-sidebar-item {{ Request::is('admin/manage_combo_stock*') ? 'active' : '' }}" href="{{ route('admin.manage_combo_stock.index') }}">
            <i class='bx bx-cubes'></i>
            <span>{{ labels('admin_labels.combo_stock_manage', 'Combo Stock Manage') }}</span>
        </a>
        @endif

        <!-- === BRANDS === -->
        <div class="aurora-sidebar-section">Brands</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/brands') ? 'active' : '' }}" href="{{ route('brands.index') }}">
            <i class='bx bx-certification'></i>
            <span>{{ labels('admin_labels.brand', 'Brand') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/brands/bulk_upload*') ? 'active' : '' }}" href="{{ route('brands.bulk_upload') }}">
            <i class='bx bx-upload'></i>
            <span>{{ labels('admin_labels.bulk_upload', 'Bulk Upload') }}</span>
        </a>

        <!-- === SELLERS === -->
        <div class="aurora-sidebar-section">Sellers</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/seller/*') ? 'active' : '' }}" href="{{ route('admin.sellers.create') }}">
            <i class='bx bx-user-plus'></i>
            <span>{{ labels('admin_labels.add_sellers', 'Add Sellers') }}</span>
        </a>
        @if ($user_role == 'super_admin' || $user->hasPermissionTo('view seller'))
        <a class="aurora-sidebar-item {{ Request::is('admin/sellers') ? 'active' : '' }}" href="{{ route('sellers.index') }}">
            <i class='bx bx-users'></i>
            <span>{{ labels('admin_labels.sellers', 'Sellers') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || $user->hasPermissionTo('view seller_wallet_transaction'))
        <a class="aurora-sidebar-item {{ Request::is('admin/sellers/seller_wallet_transaction*') ? 'active' : '' }}" href="{{ route('admin.sellers.sellerWallet') }}">
            <i class='bx bx-wallet'></i>
            <span>{{ labels('admin_labels.wallet_transactions', 'Wallet Transaction') }}</span>
        </a>
        @endif

        <!-- === PRODUCTS === -->
        <div class="aurora-sidebar-section">Products</div>
        @if ($user_role == 'super_admin' || $user->hasPermissionTo('view tax'))
        <a class="aurora-sidebar-item {{ Request::is('admin/taxes*') ? 'active' : '' }}" href="{{ route('taxes.index') }}">
            <i class='bx bx-tax'></i>
            <span>{{ labels('admin_labels.tax', 'Tax') }}</span>
        </a>
        @endif
        <a class="aurora-sidebar-item {{ Request::is('admin/attributes*') ? 'active' : '' }}" href="{{ route('admin.attributes.index') }}">
            <i class='bx bx-list-ul'></i>
            <span>{{ labels('admin_labels.attributes_manage', 'Attributes') }}</span>
        </a>
        <a class="aurora-sidebar-item has-sub {{ Request::is('admin/products*') || Request::is('admin/product_faqs*') ? 'active' : '' }}" data-target="prodSub">
            <i class='bx bx-package'></i>
            <span>{{ labels('admin_labels.products_manage', 'Products') }}</span>
            <i class='bx bx-chevron-down arrow'></i>
        </a>
        <div class="aurora-sidebar-sub {{ Request::is('admin/products*') || Request::is('admin/product_faqs*') ? 'open' : '' }}" id="prodSub">
            <a class="aurora-sidebar-item {{ Request::is('admin/products') && !Request::is('admin/products/*') ? 'active' : '' }}" href="{{ route('admin.products.index') }}">
                <i class='bx bx-plus-circle'></i>
                <span>{{ labels('admin_labels.add_products', 'Add Products') }}</span>
            </a>
            @if ($user_role == 'super_admin' || $user->hasPermissionTo('view product'))
            <a class="aurora-sidebar-item {{ Request::is('admin/products/manage_product*') ? 'active' : '' }}" href="{{ route('admin.products.manage_product') }}">
                <i class='bx bx-list-ul'></i>
                <span>{{ labels('admin_labels.manage_products', 'Manage Products') }}</span>
            </a>
            @endif
            <a class="aurora-sidebar-item {{ Request::is('admin/product_faqs*') ? 'active' : '' }}" href="{{ route('admin.product_faqs.index') }}">
                <i class='bx bx-help-circle'></i>
                <span>{{ labels('admin_labels.product_faqs', 'Product FAQs') }}</span>
            </a>
            <a class="aurora-sidebar-item {{ Request::is('admin/product/product_bulk_upload*') ? 'active' : '' }}" href="{{ route('admin.product_bulk_upload') }}">
                <i class='bx bx-upload'></i>
                <span>{{ labels('admin_labels.bulk_upload', 'Bulk Upload') }}</span>
            </a>
        </div>

        <!-- === COMBO PRODUCTS === -->
        <div class="aurora-sidebar-section">Combo Products</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/combo_product_attributes*') ? 'active' : '' }}" href="{{ route('admin.combo_product_attributes.index') }}">
            <i class='bx bx-list-ul'></i>
            <span>{{ labels('admin_labels.attributes_manage', 'Attributes') }}</span>
        </a>
        <a class="aurora-sidebar-item has-sub {{ Request::is('admin/combo_products*') || Request::is('admin/combo_product_faqs*') ? 'active' : '' }}" data-target="comboSub">
            <i class='bx bx-package'></i>
            <span>{{ labels('admin_labels.products_manage', 'Combo Products') }}</span>
            <i class='bx bx-chevron-down arrow'></i>
        </a>
        <div class="aurora-sidebar-sub {{ Request::is('admin/combo_products*') || Request::is('admin/combo_product_faqs*') ? 'open' : '' }}" id="comboSub">
            <a class="aurora-sidebar-item {{ Request::is('admin/combo_products') && !Request::is('admin/combo_products/*') ? 'active' : '' }}" href="{{ route('admin.combo_products.index') }}">
                <i class='bx bx-plus-circle'></i>
                <span>{{ labels('admin_labels.add_combo_products', 'Add Products') }}</span>
            </a>
            @if ($user_role == 'super_admin' || $user->hasPermissionTo('view combo_product'))
            <a class="aurora-sidebar-item {{ Request::is('admin/combo_products/manage_product*') ? 'active' : '' }}" href="{{ route('admin.combo_products.manage_product') }}">
                <i class='bx bx-list-ul'></i>
                <span>{{ labels('admin_labels.manage_products', 'Manage Products') }}</span>
            </a>
            @endif
            <a class="aurora-sidebar-item {{ Request::is('admin/combo_product_faqs*') ? 'active' : '' }}" href="{{ route('admin.combo_product_faqs.index') }}">
                <i class='bx bx-help-circle'></i>
                <span>{{ labels('admin_labels.product_faqs', 'Product FAQs') }}</span>
            </a>
        </div>

        <!-- === AFFILIATE === -->
        <div class="aurora-sidebar-section">Affiliate</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/manage_affiliate_users*') || Request::is('admin/add_affiliate_user*') || Request::is('admin/affiliate_users*') ? 'active' : '' }}" href="{{ route('admin.affiliate.manage_user') }}">
            <i class='bx bx-user'></i>
            <span>{{ labels('admin_labels.affiliate_users', 'Affiliate Users') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/affiliate_settings*') ? 'active' : '' }}" href="{{ route('admin.affiliate.settings') }}">
            <i class='bx bx-cog'></i>
            <span>{{ labels('admin_labels.settings', 'Settings') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/affiliate/reports*') ? 'active' : '' }}" href="{{ route('admin.affiliate.reports') }}">
            <i class='bx bx-bar-chart'></i>
            <span>{{ labels('admin_labels.reports', 'Reports') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/affiliate_policies*') ? 'active' : '' }}" href="{{ route('admin.affiliate.policies') }}">
            <i class='bx bx-file'></i>
            <span>{{ labels('admin_labels.policies', 'Policies') }}</span>
        </a>

        <!-- === BLOGS === -->
        <div class="aurora-sidebar-section">Blogs</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/blogs') ? 'active' : '' }}" href="{{ route('admin.blogs.index') }}">
            <i class='bx bx-category'></i>
            <span>{{ labels('admin_labels.blog_categories', 'Blog Categories') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/manage_blogs*') ? 'active' : '' }}" href="{{ route('manage_blogs.index') }}">
            <i class='bx bx-edit'></i>
            <span>{{ labels('admin_labels.create_blog', 'Create Blog') }}</span>
        </a>

        <!-- === MEDIA === -->
        <div class="aurora-sidebar-section">Media</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/media*') ? 'active' : '' }}" href="{{ route('admin.media') }}">
            <i class='bx bx-image-add'></i>
            <span>{{ labels('admin_labels.add_media', 'Add Media') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/storage_type*') ? 'active' : '' }}" href="{{ route('admin.storage_type') }}">
            <i class='bx bx-server'></i>
            <span>{{ labels('admin_labels.storage_type', 'Storage Type') }}</span>
        </a>

        <!-- === SLIDER === -->
        <div class="aurora-sidebar-section">Slider</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/sliders*') ? 'active' : '' }}" href="{{ route('sliders.index') }}">
            <i class='bx bx-carousel'></i>
            <span>{{ labels('admin_labels.add_slider', 'Add Slider') }}</span>
        </a>

        <!-- === OFFERS === -->
        <div class="aurora-sidebar-section">Offers</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/offers') ? 'active' : '' }}" href="{{ route('offers.index') }}">
            <i class='bx bx-gift'></i>
            <span>{{ labels('admin_labels.offers', 'Offers') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/offer_sliders*') ? 'active' : '' }}" href="{{ route('offer_sliders.index') }}">
            <i class='bx bx-slideshow'></i>
            <span>{{ labels('admin_labels.offer_sliders', 'Offer Sliders') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/promo_codes*') ? 'active' : '' }}" href="{{ route('promo_codes.index') }}">
            <i class='bx bx-code'></i>
            <span>{{ labels('admin_labels.promo_codes', 'Promo Codes') }}</span>
        </a>

        <!-- === SUPPORT TICKETS === -->
        <div class="aurora-sidebar-section">Support</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/tickets/ticket_types*') ? 'active' : '' }}" href="{{ route('ticket_types.index') }}">
            <i class='bx bx-category'></i>
            <span>{{ labels('admin_labels.ticket_types', 'Ticket Types') }}</span>
        </a>
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view tickets'))
        <a class="aurora-sidebar-item {{ Request::is('admin/tickets') ? 'active' : '' }}" href="{{ route('admin.tickets.viewTickets') }}">
            <i class='bx bx-support'></i>
            <span>{{ labels('admin_labels.tickets', 'Tickets') }}</span>
        </a>
        @endif

        <!-- === CHAT === -->
        <div class="aurora-sidebar-section">Chat</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/chat*') ? 'active' : '' }}" href="{{ route('admin.chat.index') }}">
            <i class='bx bx-chat'></i>
            <span>{{ labels('admin_labels.chats', 'Chats') }}</span>
            @if ($unread > 0)<span class="aurora-badge-pill danger">{{ $unread }}</span>@endif
        </a>

        <!-- === FEATURED === -->
        <div class="aurora-sidebar-section">Featured</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/feature_section') ? 'active' : '' }}" href="{{ route('feature_section.index') }}">
            <i class='bx bx-star'></i>
            <span>{{ labels('admin_labels.featured', 'Featured') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/feature_section/section_order*') ? 'active' : '' }}" href="{{ route('feature_section.section_order') }}">
            <i class='bx bx-sort'></i>
            <span>{{ labels('admin_labels.sections_order', 'Sections Order') }}</span>
        </a>

        <!-- === CUSTOMERS === -->
        <div class="aurora-sidebar-section">Customers</div>
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view customers'))
        <a class="aurora-sidebar-item {{ Request::is('admin/customers') ? 'active' : '' }}" href="{{ route('admin.customers') }}">
            <i class='bx bx-user'></i>
            <span>{{ labels('admin_labels.view_customers', 'View Customers') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view address'))
        <a class="aurora-sidebar-item {{ Request::is('admin/customers/customers_addresses*') ? 'active' : '' }}" href="{{ route('admin.customers.getCustomersAddresses') }}">
            <i class='bx bx-map'></i>
            <span>{{ labels('admin_labels.addresses', 'Addresses') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view customer_transaction'))
        <a class="aurora-sidebar-item {{ Request::is('admin/customers/view_transactions*') ? 'active' : '' }}" href="{{ route('admin.customers.viewTransactions') }}">
            <i class='bx bx-transfer'></i>
            <span>{{ labels('admin_labels.transactions', 'Transactions') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view customer_wallet_transaction'))
        <a class="aurora-sidebar-item {{ Request::is('admin/customers/wallet_transaction*') ? 'active' : '' }}" href="{{ route('admin.customers.walletTransaction') }}">
            <i class='bx bx-wallet'></i>
            <span>{{ labels('admin_labels.wallet_transactions', 'Wallet Transactions') }}</span>
        </a>
        @endif

        <!-- === RETURN REQUESTS === -->
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view return_request'))
        <div class="aurora-sidebar-section">Returns</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/return_request*') ? 'active' : '' }}" href="{{ route('admin.return_request.index') }}">
            <i class='bx bx-revision'></i>
            <span>{{ labels('admin_labels.return_requests', 'Return Requests') }}</span>
        </a>
        @endif

        <!-- === DELIVERY BOYS === -->
        <div class="aurora-sidebar-section">Delivery</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/delivery_boys') ? 'active' : '' }}" href="{{ route('delivery_boys.index') }}">
            <i class='bx bx-cycling'></i>
            <span>{{ labels('admin_labels.delivery_boys', 'Delivery Boys') }}</span>
        </a>
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view delivery_boy_cash_collection'))
        <a class="aurora-sidebar-item {{ Request::is('admin/delivery_boys/manage_cash*') ? 'active' : '' }}" href="{{ route('admin.get_cash_collection.index') }}">
            <i class='bx bx-money'></i>
            <span>{{ labels('admin_labels.cash_collection', 'Cash Collection') }}</span>
        </a>
        @endif
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view fund_transfer'))
        <a class="aurora-sidebar-item {{ Request::is('admin/delivery_boys/fund_transfers*') ? 'active' : '' }}" href="{{ route('admin.delivery_boys.fund_transfers.index') }}">
            <i class='bx bx-transfer'></i>
            <span>{{ labels('admin_labels.fund_transfer', 'Fund Transfer') }}</span>
        </a>
        @endif

        <!-- === PAYMENT REQUEST === -->
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view payment_request'))
        <div class="aurora-sidebar-section">Payments</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/payment_request*') ? 'active' : '' }}" href="{{ route('admin.payment_request.index') }}">
            <i class='bx bx-wallet-alt'></i>
            <span>{{ labels('admin_labels.payment_request', 'Payment Request') }}</span>
        </a>
        @endif

        <!-- === FAQ === -->
        <div class="aurora-sidebar-section">Content</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/faq*') ? 'active' : '' }}" href="{{ route('faqs.index') }}">
            <i class='bx bx-help-circle'></i>
            <span>{{ labels('admin_labels.faqs', 'FAQs') }}</span>
        </a>

        <!-- === NOTIFICATIONS === -->
        <a class="aurora-sidebar-item {{ Request::is('admin/send_notification*') ? 'active' : '' }}" href="{{ route('notifications.index') }}">
            <i class='bx bx-send'></i>
            <span>{{ labels('admin_labels.notification', 'Notification') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/send_seller_notification*') ? 'active' : '' }}" href="{{ route('seller_notifications.index') }}">
            <i class='bx bx-send'></i>
            <span>{{ labels('admin_labels.seller_notification', 'Seller Notification') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/seller_email_notification*') ? 'active' : '' }}" href="{{ route('seller_email_notifications.index') }}">
            <i class='bx bx-mail-send'></i>
            <span>{{ labels('admin_labels.seller_email_notification', 'Seller Email') }}</span>
        </a>

        <!-- === CUSTOM MESSAGE === -->
        <div class="aurora-sidebar-section">Messages</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/custom_message*') ? 'active' : '' }}" href="{{ route('admin.custom_message.index') }}">
            <i class='bx bx-message-dots'></i>
            <span>{{ labels('admin_labels.add_custom_message', 'Custom Message') }}</span>
        </a>

        <!-- === LOCATION === -->
        <div class="aurora-sidebar-section">Location</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/area/zipcodes*') ? 'active' : '' }}" href="{{ route('admin.display_zipcodes') }}">
            <i class='bx bx-map-pin'></i>
            <span>{{ labels('admin_labels.zipcodes', 'Zipcodes') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/area/city*') ? 'active' : '' }}" href="{{ route('admin.display_city') }}">
            <i class='bx bx-building'></i>
            <span>{{ labels('admin_labels.city', 'City') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/pickup_location*') ? 'active' : '' }}" href="{{ route('admin.pickup_location.index') }}">
            <i class='bx bx-location-plus'></i>
            <span>{{ labels('admin_labels.pickup_locations', 'Pickup Locations') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/zones*') ? 'active' : '' }}" href="{{ route('admin.zones.index') }}">
            <i class='bx bx-globe'></i>
            <span>{{ labels('admin_labels.zones', 'Zones') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/area/location_bulk_upload*') ? 'active' : '' }}" href="{{ route('admin.location_bulk_upload.index') }}">
            <i class='bx bx-upload'></i>
            <span>{{ labels('admin_labels.bulk_upload', 'Bulk Upload') }}</span>
        </a>

        <!-- === SETTINGS === -->
        <div class="aurora-sidebar-section">Settings</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/settings') ? 'active' : '' }}" href="{{ route('settings.index') }}">
            <i class='bx bx-cog'></i>
            <span>{{ labels('admin_labels.settings', 'Settings') }}</span>
        </a>

        <!-- === WEB SETTINGS === -->
        <div class="aurora-sidebar-section">Web</div>
        <a class="aurora-sidebar-item has-sub {{ Request::is('admin/web_settings*') ? 'active' : '' }}" data-target="webSub">
            <i class='bx bx-globe'></i>
            <span>{{ labels('admin_labels.web_settings', 'Web Settings') }}</span>
            <i class='bx bx-chevron-down arrow'></i>
        </a>
        <div class="aurora-sidebar-sub {{ Request::is('admin/web_settings*') ? 'open' : '' }}" id="webSub">
            <a class="aurora-sidebar-item {{ Request::is('admin/web_settings/general_settings*') ? 'active' : '' }}" href="{{ route('general_settings') }}">{{ labels('admin_labels.general_settings', 'General Settings') }}</a>
            <a class="aurora-sidebar-item {{ Request::is('admin/web_settings/pwa_settings*') ? 'active' : '' }}" href="{{ route('pwa_settings') }}">{{ labels('admin_labels.pwa_settings', 'PWA Settings') }}</a>
            <a class="aurora-sidebar-item {{ Request::is('admin/web_settings/firebase*') ? 'active' : '' }}" href="{{ route('firebase') }}">{{ labels('admin_labels.firebase', 'Firebase') }}</a>
            <a class="aurora-sidebar-item {{ Request::is('admin/web_settings/language*') ? 'active' : '' }}" href="{{ route('web_language') }}">{{ labels('admin_labels.languages', 'Languages') }}</a>
        </div>

        <!-- === SEO === -->
        <div class="aurora-sidebar-section">SEO</div>
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view seo'))
        <a class="aurora-sidebar-item {{ Request::is('admin/seo*') ? 'active' : '' }}" href="{{ route('admin.seo.index') }}">
            <i class='bx bx-search-alt'></i>
            <span>{{ labels('admin_labels.seo', 'SEO') }}</span>
        </a>
        @endif

        <!-- === SYSTEM USERS === -->
        <div class="aurora-sidebar-section">Users</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/system_users*') ? 'active' : '' }}" href="{{ route('admin.system_users.index') }}">
            <i class='bx bx-group'></i>
            <span>{{ labels('admin_labels.system_users', 'System Users') }}</span>
        </a>
        @if ($user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view system_user'))
        <a class="aurora-sidebar-item {{ Request::is('admin/manage_system_users*') ? 'active' : '' }}" href="{{ route('admin.manage_system_users') }}">
            <i class='bx bx-user-check'></i>
            <span>{{ labels('admin_labels.manage_system_users', 'Manage System Users') }}</span>
        </a>
        @endif

        <!-- === LANGUAGE === -->
        <div class="aurora-sidebar-section">Languages</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/settings/language*') ? 'active' : '' }}" href="{{ route('language.index') }}">
            <i class='bx bx-text'></i>
            <span>{{ labels('admin_labels.language', 'Language') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/settings/manage_language*') ? 'active' : '' }}" href="{{ route('manage_language.index') }}">
            <i class='bx bx-edit'></i>
            <span>{{ labels('admin_labels.manage_language', 'Manage Language') }}</span>
        </a>
        <a class="aurora-sidebar-item {{ Request::is('admin/language/bulk_translation_upload*') ? 'active' : '' }}" href="{{ route('translation_bulk_upload.index') }}">
            <i class='bx bx-upload'></i>
            <span>{{ labels('admin_labels.bulk_upload', 'Bulk Import') }}</span>
        </a>

        <!-- === REPORTS === -->
        <div class="aurora-sidebar-section">Reports</div>
        <a class="aurora-sidebar-item {{ Request::is('admin/reports*') ? 'active' : '' }}" href="{{ route('admin.sales_reports.index') }}">
            <i class='bx bx-bar-chart'></i>
            <span>{{ labels('admin_labels.sales_reports', 'Sales Reports') }}</span>
        </a>
    </div>
</aside>
