@php
    use App\Services\MediaService;
    use App\Services\SettingService;
    $user = auth()->user();
@endphp

@extends('admin.layout')

@section('title', 'Dashboard')


@section('content')
<!-- Page Header -->
<div class="aurora-page-header">
    <div class="aurora-breadcrumb">
        <a href="{{ route('admin.home') }}">{{ labels('admin_labels.home', 'Accueil') }}</a>
        <span class="sep">›</span>
        <span class="current">{{ labels('admin_labels.dashboard', 'Dashboard') }}</span>
    </div>
    <h1>{{ labels('admin_labels.dashboard', 'Dashboard') }}</h1>
    <p>{{ labels('admin_labels.welcome_message', 'Bienvenue sur votre tableau de bord Aurora Marketplace.') }}</p>
</div>

<!-- Stats Cards -->
<div class="aurora-stats">
    <div class="aurora-stat-card">
        <div class="aurora-stat-card-top">
            <div class="aurora-stat-card-icon blue"><i class='bx bx-store'></i></div>
            <span class="aurora-stat-card-change up">+12%</span>
        </div>
        <div class="aurora-stat-card-value">{{ $total_seller ?? 0 }}</div>
        <div class="aurora-stat-card-label">{{ labels('admin_labels.sellers', 'Vendeurs') }}</div>
    </div>
    <div class="aurora-stat-card">
        <div class="aurora-stat-card-top">
            <div class="aurora-stat-card-icon green"><i class='bx bx-building'></i></div>
            <span class="aurora-stat-card-change up">+8%</span>
        </div>
        <div class="aurora-stat-card-value">{{ $total_store ?? 0 }}</div>
        <div class="aurora-stat-card-label">{{ labels('admin_labels.stores', 'Magasins') }}</div>
    </div>
    <div class="aurora-stat-card">
        <div class="aurora-stat-card-top">
            <div class="aurora-stat-card-icon orange"><i class='bx bx-package'></i></div>
            <span class="aurora-stat-card-change up">+23%</span>
        </div>
        <div class="aurora-stat-card-value">{{ $total_products ?? 0 }}</div>
        <div class="aurora-stat-card-label">{{ labels('admin_labels.products', 'Produits') }}</div>
    </div>
    <div class="aurora-stat-card">
        <div class="aurora-stat-card-top">
            <div class="aurora-stat-card-icon purple"><i class='bx bx-cart'></i></div>
            <span class="aurora-stat-card-change up">+15%</span>
        </div>
        <div class="aurora-stat-card-value">{{ $order_counter['total_orders'] ?? 0 }}</div>
        <div class="aurora-stat-card-label">{{ labels('admin_labels.orders', 'Commandes') }}</div>
    </div>
    <div class="aurora-stat-card">
        <div class="aurora-stat-card-top">
            <div class="aurora-stat-card-icon teal"><i class='bx bx-dollar'></i></div>
            <span class="aurora-stat-card-change up">+18%</span>
        </div>
        <div class="aurora-stat-card-value">{{ ($currency ?? '$') }}{{ number_format((float)($total_earnings ?? 0), 2) }}</div>
        <div class="aurora-stat-card-label">{{ labels('admin_labels.revenue', 'Revenus') }}</div>
    </div>
    <div class="aurora-stat-card">
        <div class="aurora-stat-card-top">
            <div class="aurora-stat-card-icon red"><i class='bx bx-user'></i></div>
            <span class="aurora-stat-card-change up">+5%</span>
        </div>
        <div class="aurora-stat-card-value">{{ $user_counter['total_users'] ?? 0 }}</div>
        <div class="aurora-stat-card-label">{{ labels('admin_labels.customers', 'Clients') }}</div>
    </div>
</div>

<!-- Setup Progress -->
<div class="aurora-setup-card">
    <h3>{{ labels('admin_labels.marketplace_setup', 'Configuration du Marketplace') }}</h3>
    <p>{{ labels('admin_labels.setup_description', 'Suivez les étapes pour configurer votre marketplace.') }}</p>
    <div class="aurora-progress-bar">
        <div class="aurora-progress-bar-fill" style="width: 50%;"></div>
    </div>
    <div class="aurora-setup-steps">
        <span class="aurora-setup-step done"><i class='bx bx-check-circle icon'></i> {{ labels('admin_labels.add_store', 'Ajouter un magasin') }}</span>
        <span class="aurora-setup-step done"><i class='bx bx-check-circle icon'></i> {{ labels('admin_labels.add_category', 'Ajouter une catégorie') }}</span>
        <span class="aurora-setup-step active"><i class='bx bx-time icon'></i> {{ labels('admin_labels.add_city', 'Ajouter une ville') }}</span>
        <span class="aurora-setup-step"><i class='bx bx-time icon'></i> {{ labels('admin_labels.add_zipcodes', 'Codes postaux') }}</span>
        <span class="aurora-setup-step"><i class='bx bx-time icon'></i> {{ labels('admin_labels.add_zone', 'Zone livraison') }}</span>
        <span class="aurora-setup-step done"><i class='bx bx-check-circle icon'></i> {{ labels('admin_labels.add_seller', 'Ajouter un vendeur') }}</span>
        <span class="aurora-setup-step"><i class='bx bx-time icon'></i> {{ labels('admin_labels.add_delivery_boy', 'Ajouter un livreur') }}</span>
        <span class="aurora-setup-step"><i class='bx bx-time icon'></i> {{ labels('admin_labels.add_product', 'Ajouter un produit') }}</span>
    </div>
</div>

<!-- Charts & Activities -->
<div class="aurora-charts">
    <div class="aurora-chart-card">
        <h3>{{ labels('admin_labels.revenue', 'Revenus') }}</h3>
        <div class="sub">{{ labels('admin_labels.revenue_chart_desc', 'Évolution des revenus sur la période') }}</div>
        <div class="aurora-chart-filters">
            <button class="active" data-range="today">{{ labels('admin_labels.today', "Aujourd'hui") }}</button>
            <button data-range="7d">7 {{ labels('admin_labels.days', 'jours') }}</button>
            <button data-range="30d">30 {{ labels('admin_labels.days', 'jours') }}</button>
            <button data-range="year">{{ labels('admin_labels.year', 'Année') }}</button>
        </div>
        <div class="aurora-chart-container" id="revenueChart"></div>
    </div>

    <div class="aurora-chart-card">
        <h3>{{ labels('admin_labels.recent_activities', 'Activités récentes') }}</h3>
        <div class="sub">{{ labels('admin_labels.latest_events', 'Derniers événements') }}</div>
        <div class="aurora-activities">
            <div class="aurora-activity">
                <div class="aurora-activity-avatar green"><i class='bx bx-store'></i></div>
                <div class="aurora-activity-content">
                    <p><strong>{{ labels('admin_labels.new_store', 'Nouveau magasin') }}</strong> — {{ labels('admin_labels.store_created', 'Aurora Boutique créé') }}</p>
                    <span class="time">{{ labels('admin_labels.just_now', "À l'instant") }}</span>
                </div>
            </div>
            <div class="aurora-activity">
                <div class="aurora-activity-avatar blue"><i class='bx bx-cart'></i></div>
                <div class="aurora-activity-content">
                    <p><strong>{{ labels('admin_labels.new_order', 'Nouvelle commande') }}</strong> — #{{ rand(1000,9999) }} {{ labels('admin_labels.placed', 'passée') }}</p>
                    <span class="time">5 {{ labels('admin_labels.min_ago', 'min') }}</span>
                </div>
            </div>
            <div class="aurora-activity">
                <div class="aurora-activity-avatar orange"><i class='bx bx-user-plus'></i></div>
                <div class="aurora-activity-content">
                    <p><strong>{{ labels('admin_labels.new_seller', 'Nouveau vendeur') }}</strong> — {{ labels('admin_labels.seller_registered', 'Jean Dupont inscrit') }}</p>
                    <span class="time">15 {{ labels('admin_labels.min_ago', 'min') }}</span>
                </div>
            </div>
            <div class="aurora-activity">
                <div class="aurora-activity-avatar purple"><i class='bx bx-credit-card'></i></div>
                <div class="aurora-activity-content">
                    <p><strong>{{ labels('admin_labels.payment_received', 'Paiement reçu') }}</strong> — {{ labels('admin_labels.payment_from', 'De') }} Marie Martin (€{{ rand(20,200) }})</p>
                    <span class="time">1{{ labels('admin_labels.hour_ago', 'h') }}</span>
                </div>
            </div>
            <div class="aurora-activity">
                <div class="aurora-activity-avatar green"><i class='bx bx-user-check'></i></div>
                <div class="aurora-activity-content">
                    <p><strong>{{ labels('admin_labels.new_customer', 'Nouveau client') }}</strong> — {{ labels('admin_labels.customer_registered', 'Sophie Bernard inscrite') }}</p>
                    <span class="time">2{{ labels('admin_labels.hours_ago', 'h') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Recent Orders Table -->
<div class="aurora-table-card">
    <div class="aurora-table-card-header">
        <h3>{{ labels('admin_labels.recent_orders', 'Dernières commandes') }}</h3>
        <a href="{{ route('admin.orders.index') }}">{{ labels('admin_labels.view_all', 'Voir tout') }} →</a>
    </div>
    <table class="aurora-table">
        <thead>
            <tr>
                <th>{{ labels('admin_labels.id', 'ID') }}</th>
                <th>{{ labels('admin_labels.customer', 'Client') }}</th>
                <th>{{ labels('admin_labels.seller', 'Vendeur') }}</th>
                <th>{{ labels('admin_labels.amount', 'Montant') }}</th>
                <th>{{ labels('admin_labels.status', 'Statut') }}</th>
                <th>{{ labels('admin_labels.date', 'Date') }}</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><strong>#{{ rand(1000,9999) }}</strong></td>
                <td>
                    <div class="aurora-avatar-inline">
                        <img src="{{ asset(config('constants.NO_IMAGE')) }}" alt="">
                        <span>Sophie Bernard</span>
                    </div>
                </td>
                <td>Aurora Boutique</td>
                <td>€{{ rand(20, 200) }},00</td>
                <td><span class="aurora-badge delivered">{{ labels('admin_labels.delivered', 'Livrée') }}</span></td>
                <td>{{ now()->subHours(rand(1,72))->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>#{{ rand(1000,9999) }}</strong></td>
                <td>
                    <div class="aurora-avatar-inline">
                        <img src="{{ asset(config('constants.NO_IMAGE')) }}" alt="">
                        <span>Jean Dupont</span>
                    </div>
                </td>
                <td>Premium Shop</td>
                <td>€{{ rand(50, 500) }},00</td>
                <td><span class="aurora-badge processing">{{ labels('admin_labels.processing', 'En cours') }}</span></td>
                <td>{{ now()->subHours(rand(1,72))->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>#{{ rand(1000,9999) }}</strong></td>
                <td>
                    <div class="aurora-avatar-inline">
                        <img src="{{ asset(config('constants.NO_IMAGE')) }}" alt="">
                        <span>Marie Martin</span>
                    </div>
                </td>
                <td>Bio Nature</td>
                <td>€{{ rand(10, 150) }},00</td>
                <td><span class="aurora-badge pending">{{ labels('admin_labels.pending', 'En attente') }}</span></td>
                <td>{{ now()->subHours(rand(1,72))->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>#{{ rand(1000,9999) }}</strong></td>
                <td>
                    <div class="aurora-avatar-inline">
                        <img src="{{ asset(config('constants.NO_IMAGE')) }}" alt="">
                        <span>Pierre Durand</span>
                    </div>
                </td>
                <td>Tech Store</td>
                <td>€{{ rand(100, 1000) }},00</td>
                <td><span class="aurora-badge confirmed">{{ labels('admin_labels.confirmed', 'Confirmée') }}</span></td>
                <td>{{ now()->subHours(rand(1,72))->format('d/m/Y') }}</td>
            </tr>
            <tr>
                <td><strong>#{{ rand(1000,9999) }}</strong></td>
                <td>
                    <div class="aurora-avatar-inline">
                        <img src="{{ asset(config('constants.NO_IMAGE')) }}" alt="">
                        <span>Julie Petit</span>
                    </div>
                </td>
                <td>Maison & Co</td>
                <td>€{{ rand(30, 300) }},00</td>
                <td><span class="aurora-badge cancelled">{{ labels('admin_labels.cancelled', 'Annulée') }}</span></td>
                <td>{{ now()->subHours(rand(1,72))->format('d/m/Y') }}</td>
            </tr>
        </tbody>
    </table>
</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', function() {
        // Chart filters
        document.querySelectorAll('.aurora-chart-filters button').forEach(function(btn) {
            btn.addEventListener('click', function() {
                document.querySelectorAll('.aurora-chart-filters button').forEach(function(b) { b.classList.remove('active'); });
                this.classList.add('active');
            });
        });

        // ApexCharts Revenue Chart
        if (typeof ApexCharts !== 'undefined') {
            var options = {
                series: [{
                    name: '{{ labels("admin_labels.revenue", "Revenus") }}',
                    data: [30, 45, 38, 55, 62, 78, 85, 92, 88, 105, 120, 145]
                }],
                chart: {
                    type: 'area',
                    height: 280,
                    toolbar: { show: false },
                    fontFamily: 'Inter, sans-serif',
                    foreColor: '#64748B',
                    zoom: { enabled: false }
                },
                colors: ['#F97316'],
                fill: {
                    type: 'gradient',
                    gradient: {
                        shadeIntensity: 1,
                        opacityFrom: 0.3,
                        opacityTo: 0.05,
                        stops: [0, 90, 100]
                    }
                },
                stroke: { curve: 'smooth', width: 2 },
                dataLabels: { enabled: false },
                grid: {
                    borderColor: '#E2E8F0',
                    strokeDashArray: 4,
                    xaxis: { lines: { show: true } },
                    yaxis: { lines: { show: true } }
                },
                xaxis: {
                    categories: ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun', 'Jul', 'Aoû', 'Sep', 'Oct', 'Nov', 'Déc'],
                    labels: { style: { fontSize: '12px' } }
                },
                yaxis: {
                    labels: { style: { fontSize: '12px' }, formatter: function(v) { return '$' + v; } }
                },
                tooltip: {
                    theme: 'light',
                    x: { show: true },
                    y: { formatter: function(v) { return '$' + v; } }
                }
            };
            var chart = new ApexCharts(document.querySelector('#revenueChart'), options);
            chart.render();
        }
    });
</script>
@endpush
