@extends('admin/layout')
@section('title')
    {{ labels('admin_labels.wallet_transaction', 'Seller Wallet Transaction') }}
@endsection
@section('content')
    <x-admin.breadcrumb :title="labels('admin_labels.wallet_transaction', 'Wallet Transaction')" :subtitle="labels(
        'admin_labels.track_and_manage_wallet_transactions_with_precision',
        'Track and Manage Wallet Transactions with Precision',
    )" :breadcrumbs="[
        ['label' => labels('admin_labels.sellers', 'Vendeurs'), 'url' => route('sellers.index')],
        ['label' => labels('admin_labels.wallet_transaction', 'Wallet Transaction')],
    ]" />


    {{-- table  --}}
    <section class="">
        <div class="card content-area p-4 ">
            <div class="aurora-flex-between aurora-mb-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-6">
                            <h4>{{ labels('admin_labels.manage_seller_wallet_transaction', 'Manage Seller Wallet Transactions') }}
                            </h4>
                        </div>
                        <div class="col-md-6 d-flex justify-content-end ">
                            <div class="input-group me-2 search-input-grp ">
                                <span class="search-icon"><i class='bx bx-search-alt'></i></span>
                                <input type="text" data-table="admin_seller_wallet_table"
                                    class="aurora-input" style="max-width:200px;display:inline-block" placeholder="{{ labels('admin_labels.search', 'Rechercher') }}">
                                <span class="aurora-btn aurora-btn-secondary">{{ labels('admin_labels.search', 'Rechercher') }}</span>
                            </div>
                            <a class="aurora-toolbar-btn" id="tableFilter" data-bs-toggle="offcanvas"
                                data-bs-target="#columnFilterOffcanvas" data-table="admin_seller_wallet_table"
                                dateFilter='false' orderStatusFilter='false' paymentMethodFilter='false'
                                orderTypeFilter='false'><i class='bx bx-filter-alt'></i></a>
                            <a class="aurora-toolbar-btn" id="tableRefresh"data-table="admin_seller_wallet_table"><i
                                    class='bx bx-refresh'></i></a>
                            <div class="dropdown">
                                <a class="btn dropdown-toggle export-btn" type="button" id="exportOptionsDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bx-download'></i>
                                </a>
                                <ul class="aurora-dropdown-menu" aria-labelledby="exportOptionsDropdown">
                                    <li><button class="aurora-dropdown-item" type="button"
                                            onclick="exportTableData('admin_seller_wallet_table','csv')">{{ labels('admin_labels.csv', 'CSV') }}</button></li>
                                    <li><button class="aurora-dropdown-item" type="button"
                                            onclick="exportTableData('admin_seller_wallet_table','json')">{{ labels('admin_labels.json', 'JSON') }}</button></li>
                                    <li><button class="aurora-dropdown-item" type="button"
                                            onclick="exportTableData('admin_seller_wallet_table','sql')">{{ labels('admin_labels.sql', 'SQL') }}</button></li>
                                    <li><button class="aurora-dropdown-item" type="button"
                                            onclick="exportTableData('admin_seller_wallet_table','excel')">{{ labels('admin_labels.excel', 'Excel') }}</button>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-md-12">
                    <div class="pt-0">
                        <div class="table-responsive">
                            <table class='table' id="admin_seller_wallet_table" data-toggle="table"
                                data-loading-template="loadingTemplate"
                                data-url="{{ route('admin.sellers.wallet_transactions_list') }}" data-click-to-select="true"
                                data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false" data-show-columns="false"
                                data-show-refresh="false" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="false" data-maintain-selected="true" data-export-types='["txt","excel"]'
                                data-query-params="seller_wallet_query_params">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">
                                            {{ labels('admin_labels.id', 'ID') }}
                                        <th data-field="name" data-disabled="1" data-sortable="false">
                                            {{ labels('admin_labels.user_name', 'User Name') }}
                                        </th>
                                        <th data-field="type" data-sortable="false">{{ labels('admin_labels.label_type', 'Type') }}</th>
                                        <th data-field="amount" data-disabled="1" data-sortable="false">
                                            {{ labels('admin_labels.amount', 'Amount') }}
                                        </th>
                                        <th data-field="status" data-sortable="false">
                                            {{ labels('admin_labels.status', 'Statut') }}
                                        </th>
                                        <th data-field="message" data-sortable="false">
                                            {{ labels('admin_labels.message', 'Message') }}
                                        </th>
                                        <th data-field="created_at" data-sortable="true">
                                            {{ labels('admin_labels.date', 'Date') }}
                                        </th>
                                        {{-- <th data-field="operate" data-sortable="false">
                                            {{ labels('admin_labels.action', 'Actions') }}
                                        </th> --}}
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection
