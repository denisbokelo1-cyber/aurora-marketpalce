@php
    use App\Services\MediaService;
    use App\Services\TranslationService;
    use App\Services\CurrencyService;
    $auroraOrange = '#F57C00';
    $auroraDark = '#e65100';
@endphp
<div id="page-content">
    <x-utility.breadcrumbs.breadcrumbTwo :$bread_crumb />

    <!-- Hero Banner (Aurora style) -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 850px; padding: 30px 20px;">
            <span style="display: inline-block; background: {{ $auroraOrange }}; color: #fff; padding: 5px 16px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">{{ labels('front_messages.compare', 'Comparaison') }}</span>
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                {{ labels('front_messages.compare', 'COMPARER') }} <span style="color: {{ $auroraOrange }};">{{ labels('front_messages.products', 'PRODUITS') }}</span>
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 650px; font-size: 1.1rem; line-height: 1.7;">
                {{ labels('front_messages.compare_subtitle', 'Comparez les caractéristiques, prix et avis de vos produits favoris pour faire le meilleur choix.') }}
            </p>
        </div>
    </div>

    @php
        $compare_i18n = [
            'product' => labels('front_messages.product', 'Produit'),
            'price' => labels('front_messages.price', 'Prix'),
            'category' => labels('front_messages.category', 'Catégorie'),
            'brand' => labels('front_messages.brand', 'Marque'),
            'rating' => labels('front_messages.rating', 'Note'),
            'description' => labels('front_messages.description', 'Description'),
            'view' => labels('front_messages.view_details', 'Voir le produit'),
            'remove' => labels('front_messages.remove', 'Retirer'),
            'combo' => labels('front_messages.combo_products', 'Produits combinés'),
            'add_to_cart' => labels('front_messages.add_to_cart', 'Ajouter au panier'),
            'availability' => labels('front_messages.availability', 'Disponibilité'),
            'in_stock' => labels('front_messages.in_stock', 'En stock'),
            'out_of_stock' => labels('front_messages.out_of_stock', 'Rupture de stock'),
            'best_value' => 'Meilleur prix',
            'clear_all' => 'Vider la comparaison',
        ];
    @endphp

    <div class="container-fluid" style="padding: 0 0 50px;">
        <div id="compare_container"
            data-csrf="{{ csrf_token() }}"
            data-i18n='@json($compare_i18n)'
            data-endpoint="{{ url('product/add-to-compare') }}"
            data-product-url="{{ url('products') }}"
            data-combo-url="{{ url('combo-products') }}"
            data-store-slug="{{ session('store_slug') }}">

            <!-- Empty State (shown initially / when no items) -->
            <div id="compare_empty_slot" class="text-center" style="padding: 60px 20px;">
                <div style="max-width: 500px; margin: 0 auto;">
                    <div style="font-size: 64px; margin-bottom: 20px; opacity: 0.4;">📋</div>
                    <h3 style="font-size: 22px; font-weight: 700; color: #1a1a2e; margin-bottom: 10px;">
                        {{ labels('front_messages.compare_is_currently_empty', 'Votre liste de comparaison est vide.') }}
                    </h3>
                    <p style="font-size: 14px; color: #888; margin-bottom: 24px;">
                        {{ labels('front_messages.compare_empty_message', 'Ajoutez des produits pour les comparer côte à côte.') }}
                    </p>
                    <a wire:navigate href="{{ customUrl('products') }}" class="btn" style="background: {{ $auroraOrange }}; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='{{ $auroraDark }}'" onmouseout="this.style.background='{{ $auroraOrange }}'">
                        {{ labels('front_messages.explore_now', 'Explorer les produits') }}
                    </a>
                </div>
            </div>
        </div>
    </div>

    @script
    <script>
        (function () {
            var auroraOrange = '#F57C00';
            var auroraDark = '#e65100';

            function initCompareView() {
                var container = document.getElementById('compare_container');
                if (!container) return;

                var i18n;
                try { i18n = JSON.parse(container.dataset.i18n || '{}'); } catch (_) { i18n = {}; }
                var endpoint = container.dataset.endpoint;
                var productBase = container.dataset.productUrl;
                var comboBase = container.dataset.comboUrl;
                var storeSlug = container.dataset.storeSlug || '';
                var csrf = container.dataset.csrf;

                var emptySlotHtml = (function () {
                    var slot = document.getElementById('compare_empty_slot');
                    return slot ? slot.outerHTML : '';
                })();

                function readStored() {
                    try {
                        var raw = localStorage.getItem('compare');
                        var parsed = raw ? JSON.parse(raw) : [];
                        if (!Array.isArray(parsed)) return [];
                        return parsed.filter(function (i) { return i && typeof i === 'object' && i.product_id; });
                    } catch (_) { return []; }
                }

                function saveStored(items) {
                    try { localStorage.setItem('compare', JSON.stringify(items)); } catch (_) {}
                    var countEl = document.getElementById('compare_count');
                    if (countEl) countEl.textContent = String(items.length);
                }

                function esc(s) {
                    if (s === null || s === undefined) return '';
                    return String(s)
                        .replace(/&/g, '&').replace(/</g, '<').replace(/>/g, '>')
                        .replace(/"/g, '"').replace(/'/g, ''');
                }

                function stars(rating) {
                    var r = Math.round(parseFloat(rating || 0));
                    var html = '';
                    for (var i = 1; i <= 5; i++) {
                        html += '<span style="color: #f4a51c; font-size: 14px;">' + (i <= r ? '★' : '☆') + '</span>';
                    }
                    return html;
                }

                function toNum(v) { return parseFloat(String(v || '').replace(/[^0-9.\-]/g, '')) || 0; }

                function priceHtml(item, isCombo) {
                    if (isCombo) {
                        var p = toNum(item.price), sp = toNum(item.special_price);
                        if (sp > 0 && sp < p) {
                            return '<span style="font-weight:700;color:' + auroraOrange + ';font-size:16px;">' + esc(item.special_price) + '</span> ' +
                                   '<span style="font-size:13px;color:#999;text-decoration:line-through;margin-left:5px;">' + esc(item.price) + '</span>';
                        }
                        return '<span style="font-weight:700;color:#1a1a2e;font-size:16px;">' + esc(item.price || '-') + '</span>';
                    }
                    var mm = item.min_max_price || {};
                    var max = mm.max_price, specMin = mm.special_min_price;
                    if (specMin && toNum(specMin) > 0 && toNum(specMin) < toNum(max)) {
                        return '<span style="font-weight:700;color:' + auroraOrange + ';font-size:16px;">' + esc(specMin) + '</span> ' +
                               '<span style="font-size:13px;color:#999;text-decoration:line-through;margin-left:5px;">' + esc(max) + '</span>';
                    }
                    return '<span style="font-weight:700;color:#1a1a2e;font-size:16px;">' + esc(max || '-') + '</span>';
                }

                function hrefFor(slug, isCombo) {
                    var base = (isCombo ? comboBase : productBase) + '/' + encodeURIComponent(slug || '');
                    if (storeSlug) {
                        base += (base.indexOf('?') >= 0 ? '&' : '?') + 'store=' + encodeURIComponent(storeSlug);
                    }
                    return base;
                }

                function renderEmpty() {
                    container.innerHTML = emptySlotHtml;
                }

                function renderTable(regulars, combos) {
                    if ((regulars.length + combos.length) === 0) {
                        renderEmpty();
                        return;
                    }

                    var all = regulars.map(function (p) { return { item: p, isCombo: false }; })
                        .concat(combos.map(function (p) { return { item: p, isCombo: true }; }));

                    // Find best price
                    var prices = all.map(function(e) { return toNum(e.isCombo ? (e.item.special_price || e.item.price) : ((e.item.min_max_price||{}).special_min_price || (e.item.min_max_price||{}).max_price)); });
                    var minPrice = Math.min.apply(null, prices);

                    // Actions bar
                    var html = '<div style="display:flex;justify-content:space-between;align-items:center;flex-wrap:wrap;gap:10px;margin:20px 0 10px;">';
                    html += '<span style="font-size:13px;color:#888;"><strong style="color:#1a1a2e;">' + all.length + '</strong> ' + (all.length > 1 ? 'produits' : 'produit') + ' en comparaison</span>';
                    html += '<button type="button" id="clearCompareBtn" style="background:#f5f5f5;color:#555;border:none;padding:8px 20px;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.background=\'#eee\'" onmouseout="this.style.background=\'#f5f5f5\'">' + esc(i18n.clear_all) + '</button>';
                    html += '</div>';

                    // Comparison grid
                    html += '<div style="overflow-x:auto;overflow-y:visible;padding-bottom:10px;">';
                    html += '<div style="display:flex;gap:20px;min-width:' + Math.max(600, all.length * 280) + 'px;">';

                    all.forEach(function (entry, idx) {
                        var p = entry.item, isCombo = entry.isCombo;
                        var url = hrefFor(p.slug, isCombo);
                        var priceVal = toNum(isCombo ? (p.special_price || p.price) : ((p.min_max_price||{}).special_min_price || (p.min_max_price||{}).max_price));
                        var isBestPrice = (priceVal === minPrice && priceVal > 0);

                        html += '<div style="flex:1;min-width:260px;max-width:320px;background:#fff;border-radius:12px;border:1px solid #f0f0f0;overflow:hidden;box-shadow:0 2px 8px rgba(0,0,0,0.04);display:flex;flex-direction:column;transition:all 0.3s;" onmouseover="this.style.transform=\'translateY(-4px)\';this.style.boxShadow=\'0 12px 30px rgba(0,0,0,0.1)\'" onmouseout="this.style.transform=\'translateY(0)\';this.style.boxShadow=\'0 2px 8px rgba(0,0,0,0.04)\'">';

                        // Best price badge
                        if (isBestPrice) {
                            html += '<div style="background:' + auroraOrange + ';color:#fff;font-size:10px;font-weight:700;text-transform:uppercase;padding:4px 12px;text-align:center;letter-spacing:0.5px;">' + esc(i18n.best_value) + '</div>';
                        }

                        // Image
                        html += '<div style="padding:20px 20px 0;text-align:center;">';
                        html += '<a href="' + esc(url) + '"><img src="' + esc(p.image) + '" alt="' + esc(p.name) + '" style="max-height:160px;width:auto;max-width:100%;object-fit:contain;" loading="lazy"></a>';
                        html += '</div>';

                        // Content
                        html += '<div style="padding:16px 20px 20px;display:flex;flex-direction:column;flex:1;">';
                        html += '<a href="' + esc(url) + '" style="text-decoration:none;color:#1a1a2e;"><h5 style="font-size:14px;font-weight:700;margin:0 0 8px;line-height:1.3;">' + esc(p.name) + '</h5></a>';

                        // Price
                        html += '<div style="margin-bottom:10px;">' + priceHtml(p, isCombo) + '</div>';

                        // Availability
                        html += '<div style="font-size:12px;margin-bottom:6px;"><span style="color:#888;">' + esc(i18n.availability) + ' :</span> ';
                        html += '<span style="color:#22c55e;font-weight:600;">' + esc(i18n.in_stock) + '</span></div>';

                        // Category
                        var cat = isCombo ? i18n.combo : (p.category_name || '-');
                        html += '<div style="font-size:12px;margin-bottom:6px;color:#888;"><span>' + esc(i18n.category) + ' :</span> <span style="color:#555;font-weight:500;">' + esc(cat) + '</span></div>';

                        // Brand
                        if (!isCombo) {
                            var brand = p.brand_name || '-';
                            html += '<div style="font-size:12px;margin-bottom:6px;color:#888;"><span>' + esc(i18n.brand) + ' :</span> <span style="color:#555;font-weight:500;">' + esc(brand) + '</span></div>';
                        }

                        // Rating
                        html += '<div style="font-size:12px;margin-bottom:10px;">' + stars(p.rating) + ' <span style="color:#999;margin-left:4px;">(' + (p.rating || '0') + ')</span></div>';

                        // Description
                        var raw = p.short_description || p.description || '-';
                        var text = String(raw).replace(/<[^>]*>/g, '');
                        if (text.length > 120) text = text.substring(0, 120) + '…';
                        html += '<p style="font-size:12px;color:#888;line-height:1.5;margin:0 0 12px;flex:1;">' + esc(text) + '</p>';

                        // Buttons
                        html += '<div style="display:flex;flex-direction:column;gap:6px;margin-top:auto;">';
                        html += '<a href="' + esc(url) + '" style="display:block;background:' + auroraOrange + ';color:#fff;text-align:center;padding:9px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;transition:all 0.3s;" onmouseover="this.style.background=\'' + auroraDark + '\';this.style.boxShadow=\'0 3px 10px rgba(230,81,0,0.25)\'" onmouseout="this.style.background=\'' + auroraOrange + '\';this.style.boxShadow=\'none\'">' + esc(i18n.add_to_cart) + '</a>';
                        html += '<a href="' + esc(url) + '" style="display:block;background:#fff;color:#555;text-align:center;padding:8px 14px;border-radius:6px;font-size:12px;font-weight:500;text-decoration:none;border:1px solid #e0e0e0;transition:all 0.2s;" onmouseover="this.style.borderColor=\'' + auroraOrange + '\';this.style.color=\'' + auroraOrange + '\'" onmouseout="this.style.borderColor=\'#e0e0e0\';this.style.color=\'#555\'">' + esc(i18n.view) + '</a>';
                        html += '<button type="button" class="compare-remove" data-product-id="' + esc(p.id) + '" data-product-type="' + (isCombo ? 'combo' : 'regular') + '" style="background:none;border:1px solid #f0f0f0;color:#ef4444;text-align:center;padding:8px 14px;border-radius:6px;font-size:12px;font-weight:500;cursor:pointer;transition:all 0.2s;" onmouseover="this.style.borderColor=\'#ef4444\';this.style.background=\'#fef2f2\'" onmouseout="this.style.borderColor=\'#f0f0f0\';this.style.background=\'#fff\'">× ' + esc(i18n.remove) + '</button>';
                        html += '</div>';

                        html += '</div></div>';
                    });

                    html += '</div></div>';
                    container.innerHTML = html;

                    // Attach clear handler
                    var clearBtn = document.getElementById('clearCompareBtn');
                    if (clearBtn) {
                        clearBtn.onclick = function() {
                            saveStored([]);
                            renderEmpty();
                        };
                    }
                }

                function fetchAndRender() {
                    var stored = readStored();
                    if (stored.length === 0) {
                        renderEmpty();
                        return;
                    }

                    $.ajax({
                        type: 'POST',
                        url: endpoint,
                        data: { product_id: stored, _token: csrf },
                        dataType: 'json',
                        success: function (response) {
                            if (!response || response.error) { renderEmpty(); return; }
                            var data = response.data || {};
                            var regulars = data.regular_product || [];
                            var combos = data.combo_products || [];

                            if (Array.isArray(data.valid_compare_items)) {
                                saveStored(data.valid_compare_items);
                            }

                            renderTable(regulars, combos);
                        },
                        error: function (xhr) {
                            console.warn('Compare fetch failed', xhr && xhr.status);
                            renderEmpty();
                        }
                    });
                }

                // Delegated remove
                $(document).off('click.compareView');
                $(document).on('click.compareView', '#compare_container .compare-remove', function (e) {
                    e.preventDefault();
                    var pid = String($(this).data('product-id'));
                    var ptype = String($(this).data('product-type') || 'regular');

                    var next = readStored().filter(function (i) {
                        return !(String(i.product_id) === pid && String(i.product_type || 'regular') === ptype);
                    });
                    saveStored(next);

                    if (next.length === 0) { renderEmpty(); return; }
                    fetchAndRender();
                });

                fetchAndRender();
            }

            if (document.readyState === 'loading') {
                document.addEventListener('DOMContentLoaded', initCompareView);
            } else {
                initCompareView();
            }
            document.removeEventListener('livewire:navigated', initCompareView);
            document.addEventListener('livewire:navigated', initCompareView);
        })();
    </script>
    @endscript

    <style>
    #compare_container { position: relative; }
    #compare_container .compare-remove { cursor: pointer; }
    /* Smooth scroll for horizontal overflow */
    #compare_container > div:last-child > div:first-child::-webkit-scrollbar { height: 6px; }
    #compare_container > div:last-child > div:first-child::-webkit-scrollbar-track { background: #f1f1f1; border-radius: 3px; }
    #compare_container > div:last-child > div:first-child::-webkit-scrollbar-thumb { background: #ccc; border-radius: 3px; }
    #compare_container > div:last-child > div:first-child::-webkit-scrollbar-thumb:hover { background: #aaa; }
    </style>
</div>
