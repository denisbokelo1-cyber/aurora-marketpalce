@php
    use App\Services\TranslationService;
    use App\Services\CurrencyService;
    $language_code = app(TranslationService::class)->getLanguageCode();
    $auroraOrange = '#F57C00';
    $auroraDark = '#e65100';
@endphp
<div id="page-content">

    <x-utility.breadcrumbs.breadcrumbTwo :$bread_crumb />

    <!-- Hero Banner (Offers-style) -->
    <div class="container-fluid py-5 text-center" style="background: linear-gradient(135deg, #fff 0%, #fff8f0 100%); min-height: 380px; display: flex; align-items: center; justify-content: center;">
        <div style="max-width: 850px; padding: 30px 20px;">
            <span style="display: inline-block; background: {{ $auroraOrange }}; color: #fff; padding: 5px 16px; border-radius: 4px; font-size: 11px; font-weight: 700; text-transform: uppercase; letter-spacing: 1px; margin-bottom: 16px;">Packs économiques</span>
            <h1 class="display-5 fw-bold mb-3" style="color: #1a1a2e;">
                PRODUITS <span style="color: {{ $auroraOrange }};">COMBINÉS</span>
            </h1>
            <p class="lead text-muted mx-auto" style="max-width: 650px; font-size: 1.1rem; line-height: 1.7;">
                Économisez jusqu'à 35% sur nos packs sélectionnés. Des offres exclusives conçues pour vous faire profiter des meilleurs prix.
            </p>
            <div class="mt-4">
                <a href="#combo-grid" class="btn" style="background: {{ $auroraOrange }}; color: #fff; padding: 12px 36px; border-radius: 8px; font-weight: 600; font-size: 0.95rem; text-decoration: none; display: inline-block; transition: all 0.3s; border: none; cursor: pointer;" onmouseover="this.style.background='{{ $auroraDark }}'" onmouseout="this.style.background='{{ $auroraOrange }}'">Découvrir les packs</a>
            </div>
        </div>
    </div>

    <!-- Avantages -->
    <div class="container-fluid" style="padding: 30px 0;">
        <div class="row g-3 row-cols-2 row-cols-md-4">
            @foreach([['💰','Économisez jusqu\'à 35%','Des réductions exclusives sur nos packs.'],['✅','Produits sélectionnés','Choisis avec soin par nos experts.'],['🚚','Livraison rapide','Sous 24h partout en RDC.'],['🔒','Paiement sécurisé','Transactions 100% protégées.']] as $r)
            <div class="col">
                <div class="text-center p-4" style="background:#fff;border-radius:12px;border:1px solid #f0f0f0;box-shadow:0 2px 8px rgba(0,0,0,0.04);height:100%;transition:all 0.3s;" onmouseover="this.style.transform='translateY(-3px)';this.style.boxShadow='0 8px 25px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                    <div style="font-size:2.2rem;margin-bottom:8px;">{{$r[0]}}</div>
                    <h5 style="font-size:14px;font-weight:700;color:#1a1a2e;margin-bottom:4px;">{{$r[1]}}</h5>
                    <p style="font-size:12px;color:#888;margin:0;">{{$r[2]}}</p>
                </div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Produits -->
    <div class="container-fluid" style="padding: 0 0 40px;">
        <div class="row g-4">

            <!-- Filters (Desktop) -->
            <div class="col-12 col-lg-3 d-none d-lg-block">
                <div style="background:#fff;border-radius:12px;border:1px solid #f0f0f0;padding:22px;box-shadow:0 2px 12px rgba(0,0,0,0.04);">
                    <div class="d-flex justify-content-between align-items-center mb-4 pb-3" style="border-bottom:2px solid #f5f5f5;">
                        <h3 style="font-size:16px;font-weight:700;color:#1a1a2e;margin:0;letter-spacing:0.3px;">Filtres</h3>
                    </div>
                    <div class="mb-4">
                        <h4 style="font-size:13px;font-weight:700;color:#1a1a2e;margin:0 0 10px;text-transform:uppercase;letter-spacing:0.5px;">Prix</h4>
                        <div class="d-flex gap-2"><input type="text" placeholder="Min" style="border:1px solid #e0e0e0;border-radius:6px;padding:6px 10px;width:100%;font-size:12px;color:#555;background:#fafafa;"><input type="text" placeholder="Max" style="border:1px solid #e0e0e0;border-radius:6px;padding:6px 10px;width:100%;font-size:12px;color:#555;background:#fafafa;"></div>
                    </div>
                    <div class="mb-4">
                        <h4 style="font-size:13px;font-weight:700;color:#1a1a2e;margin:0 0 8px;text-transform:uppercase;letter-spacing:0.5px;">Disponibilité</h4>
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#444;cursor:pointer;padding:3px 0;"><input type="radio" name="disp" style="accent-color:{{$auroraOrange}};width:15px;height:15px;margin:0;"> En stock</label>
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#444;cursor:pointer;padding:3px 0;"><input type="radio" name="disp" style="accent-color:{{$auroraOrange}};width:15px;height:15px;margin:0;"> Rupture</label>
                    </div>
                    <div class="mb-4">
                        <h4 style="font-size:13px;font-weight:700;color:#1a1a2e;margin:0 0 8px;text-transform:uppercase;letter-spacing:0.5px;">Promotion</h4>
                        <label style="display:flex;align-items:center;gap:8px;font-size:13px;color:#444;cursor:pointer;padding:3px 0;"><input type="checkbox" style="accent-color:{{$auroraOrange}};width:15px;height:15px;margin:0;"> En promotion</label>
                    </div>
                    <div class="d-flex gap-3 mt-4 pt-4" style="border-top:2px solid #f5f5f5;">
                        <button style="flex:1;background:{{$auroraOrange}};color:#fff;border:none;border-radius:6px;padding:10px;font-size:12px;font-weight:600;cursor:pointer;transition:all 0.3s;" onmouseover="this.style.background='{{$auroraDark}}'" onmouseout="this.style.background='{{$auroraOrange}}'">Appliquer</button>
                        <a href="#" style="flex:1;background:#f5f5f5;color:#555;border:none;border-radius:6px;padding:10px;font-size:12px;font-weight:500;text-align:center;text-decoration:none;transition:all 0.3s;" onmouseover="this.style.background='#eee'" onmouseout="this.style.background='#f5f5f5'">Réinitialiser</a>
                    </div>
                </div>
            </div>

            <!-- Products Column -->
            <div class="col-12 col-lg-9">
                @if (count($products_listing) >= 1)
                <!-- Toolbar -->
                <div style="background:#fff;border-radius:10px;border:1px solid #f0f0f0;padding:14px 20px;box-shadow:0 1px 6px rgba(0,0,0,0.03);margin-bottom:20px;">
                    <div class="row align-items-center">
                        <div class="col-12 col-md-4 text-center text-md-start mb-2 mb-md-0">
                            <span style="font-size:13px;color:#888;"><strong style="color:#1a1a2e;">{{ count($products_listing) }}</strong> packs sur <strong style="color:#1a1a2e;">{{ $total_products }}</strong></span>
                        </div>
                        <div class="col-6 col-md-4 text-center mb-2 mb-md-0">
                            <div class="d-flex align-items-center justify-content-center gap-2">
                                <label style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;margin:0;">Afficher :</label>
                                <select style="border:1px solid #e0e0e0;border-radius:6px;padding:6px 10px;font-size:12px;color:#555;background:#fafafa;cursor:pointer;">
                                    <option value="12" {{($perPage??20)==12?'selected':''}}>12</option>
                                    <option value="24" {{($perPage??20)==24?'selected':''}}>24</option>
                                    <option value="36" {{($perPage??20)==36?'selected':''}}>36</option>
                                    <option value="48" {{($perPage??20)==48?'selected':''}}>48</option>
                                </select>
                            </div>
                        </div>
                        <div class="col-6 col-md-4 text-center text-md-end">
                            <div class="d-flex align-items-center justify-content-center justify-content-md-end gap-2">
                                <label style="font-size:12px;color:#888;text-transform:uppercase;letter-spacing:0.5px;white-space:nowrap;margin:0;">Trier :</label>
                                <select style="border:1px solid #e0e0e0;border-radius:6px;padding:6px 10px;font-size:12px;color:#555;background:#fafafa;cursor:pointer;">
                                    <option value="" {{empty($sorted_by)?'selected':''}}>En vedette</option>
                                    <option value="price-asc" {{$sorted_by=='price-asc'?'selected':''}}>Prix ↑</option>
                                    <option value="price-desc" {{$sorted_by=='price-desc'?'selected':''}}>Prix ↓</option>
                                    <option value="latest-products" {{$sorted_by=='latest-products'?'selected':''}}>Nouveautés</option>
                                </select>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Product Grid -->
                <div id="combo-grid" class="row g-3 row-cols-1 row-cols-sm-2 row-cols-lg-3 row-cols-xl-4">
                    @foreach($products_listing as $combo)
                    @php $combo = (object)$combo; $title = app(TranslationService::class)->getDynamicTranslation(\App\Models\ComboProduct::class,'title',$combo->id,$language_code); $img = $combo->image ?? ''; $price = $combo->price ?? 0; $special = $combo->special_price ?? 0; $onSale = $special > 0 && $special < $price; $savings = $onSale ? round((1-$special/$price)*100) : 0; $pids = !empty($combo->product_ids) ? explode(',',$combo->product_ids) : []; $pnames = \App\Models\Product::whereIn('id',$pids)->pluck('name')->toArray(); @endphp
                    <div class="col">
                        <div style="background:#fff;border-radius:12px;border:1px solid #f0f0f0;overflow:hidden;height:100%;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:all 0.3s;display:flex;flex-direction:column;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'">
                            <div style="position:relative;overflow:hidden;">
                                <div style="position:absolute;top:8px;left:8px;z-index:2;display:flex;flex-direction:column;gap:3px;">
                                    <span style="background:{{$auroraOrange}};color:#fff;font-size:10px;font-weight:700;padding:3px 10px;border-radius:4px;text-transform:uppercase;">PACK</span>
                                    @if($onSale)<span style="background:#dc2626;color:#fff;font-size:10px;font-weight:700;padding:3px 10px;border-radius:4px;">-{{$savings}}%</span>@endif
                                </div>
                                <div style="width:100%;height:190px;overflow:hidden;">
                                    @if(!empty($img))
                                    <img src="{{$img}}" alt="{{$title}}" style="width:100%;height:100%;object-fit:cover;transition:transform 0.4s;" loading="lazy" onmouseover="this.style.transform='scale(1.06)'" onmouseout="this.style.transform='scale(1)'" onerror="this.parentElement.innerHTML='<div style=background:#f0f0f0;height:190px;display:flex;align-items:center;justify-content:center;color:#999;>Image</div>'">
                                    @else<div style="background:#f0f0f0;height:190px;display:flex;align-items:center;justify-content:center;color:#999;">Image</div>@endif
                                </div>
                            </div>
                            <div style="padding:14px;display:flex;flex-direction:column;flex:1;">
                                <h3 style="font-size:14px;font-weight:700;color:#1a1a2e;line-height:1.3;margin-bottom:6px;">{{$title}}</h3>
                                <div style="margin-bottom:4px;">
                                    @if($onSale)
                                    <span style="font-weight:700;font-size:17px;color:{{$auroraOrange}};">{{ app(CurrencyService::class)->currentCurrencyPrice($special) }}</span>
                                    <span style="font-size:12px;color:#999;text-decoration:line-through;margin-left:5px;">{{ app(CurrencyService::class)->currentCurrencyPrice($price) }}</span>
                                    @else
                                    <span style="font-weight:700;font-size:17px;color:#1a1a2e;">{{ app(CurrencyService::class)->currentCurrencyPrice($price) }}</span>
                                    @endif
                                </div>
                                @if($onSale)<div style="margin-bottom:4px;"><span style="background:#fef2f2;color:#dc2626;font-size:11px;font-weight:600;padding:2px 10px;border-radius:3px;display:inline-block;">Économisez {{$savings}}%</span></div>@endif
                                @if(count($pnames)>0)
                                <div style="margin-bottom:6px;">
                                    <p style="font-size:11px;font-weight:600;color:#555;margin:0 0 2px;">Contient :</p>
                                    <ul style="list-style:none;padding:0;margin:0;font-size:11px;color:#888;">
                                        @foreach(array_slice($pnames,0,4) as $pn)
                                        @php $d = json_decode($pn,true); $dn = is_array($d) ? ($d['en']??$d['fr']??$pn) : $pn; @endphp
                                        <li style="padding:1px 0;">• {{\Illuminate\Support\Str::limit($dn,30)}}</li>
                                        @endforeach
                                        @if(count($pnames)>4)<li style="color:{{$auroraOrange}};">+{{count($pnames)-4}} autres</li>@endif
                                    </ul>
                                </div>
                                @endif
                                <div style="font-size:12px;color:#f4a51c;margin-bottom:8px;">★★★★☆ <span style="color:#999;font-size:11px;">({{$combo->no_of_ratings??0}})</span></div>
                                <a wire:navigate href="{{ customUrl('combo-products/'.($combo->slug??'')) }}" style="display:block;background:{{$auroraOrange}};color:#fff;text-align:center;padding:9px 14px;border-radius:6px;font-size:12px;font-weight:600;text-decoration:none;transition:all 0.3s;margin-top:auto;" onmouseover="this.style.background='{{$auroraDark}}';this.style.boxShadow='0 3px 10px rgba(230,81,0,0.25)'" onmouseout="this.style.background='{{$auroraOrange}}';this.style.boxShadow='none'">AJOUTER AU PANIER</a>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                <div class="d-flex justify-content-center mt-4">{!! $links !!}</div>
                @else
                @php $title = labels('front_messages.no_product_found','Aucun pack trouvé'); @endphp
                <x-utility.others.not-found :$title />
                @endif
            </div>
        </div>
    </div>

    <!-- Packs populaires -->
    <div style="background:#fafafa;padding:30px 0;">
        <div class="container-fluid">
            <h2 class="text-center fw-bold mb-4" style="color:#1a1a2e;font-size:1.3rem;">Les packs les plus populaires</h2>
            <div class="row flex-nowrap overflow-auto pb-3 g-3 row-cols-4" style="-webkit-overflow-scrolling:touch;">
                @foreach($products_listing as $combo)@php $c=(object)$combo;$t=app(TranslationService::class)->getDynamicTranslation(\App\Models\ComboProduct::class,'title',$c->id,$language_code);$i=$c->image??'';$sp=$c->special_price??0;$pr=$c->price??0;@endphp
                <div class="col"><div style="background:#fff;border-radius:12px;border:1px solid #f0f0f0;overflow:hidden;min-width:220px;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:all 0.3s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'"><div style="height:150px;overflow:hidden;">@if(!empty($i))<img src="{{$i}}" style="width:100%;height:100%;object-fit:cover;" loading="lazy">@else<div style="height:150px;background:#f0f0f0;"></div>@endif</div><div style="padding:12px;"><h6 style="font-size:13px;font-weight:700;color:#1a1a2e;">{{$t}}</h6><span style="font-size:15px;font-weight:700;color:{{$auroraOrange}};">{{ app(CurrencyService::class)->currentCurrencyPrice($sp>0?$sp:$pr) }}</span></div></div></div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Meilleures offres -->
    <div style="padding:30px 0;">
        <div class="container-fluid">
            <h2 class="text-center fw-bold mb-4" style="color:#1a1a2e;font-size:1.3rem;">Nos meilleures offres du moment</h2>
            <div class="row g-3 row-cols-1 row-cols-md-3">
                @php $offers = [['https://images.unsplash.com/photo-1556909114-f6e7ad7d3136?w=600&h=400&fit=crop','Pack Épicerie','Économisez 25%','products'],['https://images.unsplash.com/photo-1596462502278-27bfdc403348?w=600&h=400&fit=crop','Pack Beauté','Jusqu\'à 30%','products'],['https://images.unsplash.com/photo-1468495244123-6c6c332eeece?w=600&h=400&fit=crop','Pack Tech','-35%','products']]; @endphp
                @foreach($offers as $o)
                <div class="col"><div style="background:#fff;border-radius:12px;border:1px solid #f0f0f0;overflow:hidden;height:100%;box-shadow:0 2px 8px rgba(0,0,0,0.04);transition:all 0.3s;" onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 30px rgba(0,0,0,0.1)'" onmouseout="this.style.transform='translateY(0)';this.style.boxShadow='0 2px 8px rgba(0,0,0,0.04)'"><img src="{{$o[0]}}" style="width:100%;height:180px;object-fit:cover;" loading="lazy"><div style="padding:16px;text-align:center;"><h5 style="font-size:15px;font-weight:700;color:#1a1a2e;margin-bottom:4px;">{{$o[1]}}</h5><p style="font-size:12px;color:#888;margin-bottom:12px;">{{$o[2]}}</p><a href="{{ customUrl($o[3]) }}" style="display:inline-block;background:{{$auroraOrange}};color:#fff;padding:8px 24px;border-radius:6px;font-weight:600;font-size:12px;text-decoration:none;">Découvrir</a></div></div></div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Pourquoi choisir -->
    <div style="background:#fff;padding:30px 0;">
        <div class="container-fluid">
            <h2 class="text-center fw-bold mb-4" style="color:#1a1a2e;font-size:1.3rem;">Pourquoi choisir Aurora Marketplace ?</h2>
            <div class="row g-3 row-cols-2 row-cols-md-4">
                @foreach([['🚚','Livraison rapide','Expédition sous 24h'],['✅','Qualité garantie','Produits certifiés'],['🔒','Paiement sécurisé','Vos données protégées'],['💬','Service client','24h/7j']] as $r)
                <div class="col text-center p-4"><div style="font-size:2rem;margin-bottom:6px;">{{$r[0]}}</div><h5 style="font-size:14px;font-weight:700;color:#1a1a2e;">{{$r[1]}}</h5><p style="font-size:12px;color:#888;">{{$r[2]}}</p></div>
                @endforeach
            </div>
        </div>
    </div>

    <style>
    .pagination .page-item .page-link { border-radius: 6px !important; margin: 0 3px; font-size: 13px; font-weight: 600; color: #555; border: 1px solid #eee; background: #fff; padding: 8px 14px; transition: all 0.2s; }
    .pagination .page-item.active .page-link,
    .pagination .page-item .page-link:hover { background: {{ $auroraOrange }} !important; color: #fff !important; border-color: {{ $auroraOrange }} !important; }
    </style>
</div>
