@extends('admin/layout')
@section('title')
    {{ labels('admin_labels.payment_request', 'Payment Request') }}
@endsection
@section('content')
    <x-admin.breadcrumb :title="labels('admin_labels.payment_request', 'Payment Request')" :subtitle="labels(
        'admin_labels.streamline_and_manage_payment_requests_with_ease',
        'Streamline and Manage Payment Requests with Ease',
    )" :breadcrumbs="[['label' => labels('admin_labels.payment_request', 'Payment Request')]]" />

    {{-- table --}}


    <section
        class="overview-data {{ $user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view payment_request') ? '' : 'd-none' }}">
        <div class="card content-area p-4 ">
            <div class="aurora-flex-between aurora-mb-4">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12 col-lg-6">
                            <h4>{{ labels('admin_labels.payment_request', 'Payment Request') }}
                            </h4>
                        </div>
                        <div class="col-md-12 col-lg-6 d-flex justify-content-end ">
                            <div class="input-group me-2 search-input-grp ">
                                <span class="search-icon"><i class='bx bx-search-alt'></i></span>
                                <input type="text" data-table="admin_payment_request_table"
                                    class="aurora-input" style="max-width:200px;display:inline-block" placeholder="{{ labels('admin_labels.search', 'Rechercher') }}">
                                <span class="aurora-btn aurora-btn-secondary">{{ labels('admin_labels.search', 'Rechercher') }}</span>
                            </div>
                            <a class="aurora-toolbar-btn" id="tableFilter" data-bs-toggle="offcanvas"
                                data-bs-target="#columnFilterOffcanvas" data-table="admin_payment_request_table"
                                dateFilter='true' paymentRequestStatusFilter='true'><i class='bx bx-filter-alt'></i></a>
                            <a class="aurora-toolbar-btn" id="tableRefresh" data-table="admin_payment_request_table"><i
                                    class='bx bx-refresh'></i></a>
                            <div class="dropdown">
                                <a class="btn dropdown-toggle export-btn" type="button" id="exportOptionsDropdown"
                                    data-bs-toggle="dropdown" aria-expanded="false">
                                    <i class='bx bx-download'></i>
                                </a>
                                <ul class="aurora-dropdown-menu" aria-labelledby="exportOptionsDropdown">
                                    <li><button class="aurora-dropdown-item" type="button"
                                            onclick="exportTableData('admin_payment_request_table','csv')">{{ labels('admin_labels.csv', 'CSV') }}</button></li>
                                    <li><button class="aurora-dropdown-item" type="button"
                                            onclick="exportTableData('admin_payment_request_table','json')">{{ labels('admin_labels.json', 'JSON') }}</button>
                                    </li>
                                    <li><button class="aurora-dropdown-item" type="button"
                                            onclick="exportTableData('admin_payment_request_table','sql')">{{ labels('admin_labels.sql', 'SQL') }}</button></li>
                                    <li><button class="aurora-dropdown-item" type="button"
                                            onclick="exportTableData('admin_payment_request_table','excel')">{{ labels('admin_labels.excel', 'Excel') }}</button>
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
                            <table class='table' id="admin_payment_request_table" data-toggle="table"
                                data-loading-template="loadingTemplate" data-url="{{ route('admin.payment_request.list') }}"
                                data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false" data-show-columns="false"
                                data-show-refresh="false" data-trim-on-search="false" data-sort-name="id"
                                data-sort-order="desc" data-mobile-responsive="true" data-toolbar=""
                                data-show-export="false" data-maintain-selected="true" data-export-types='["txt","excel"]'
                                data-query-params="queryParams">
                                <thead>
                                    <tr>
                                        <th data-field="id" data-sortable="true">
                                            {{ labels('admin_labels.id', 'ID') }}
                                        <th data-field="user_name" data-disabled="1" data-sortable="false">
                                            {{ labels('admin_labels.user_name', 'User Name') }}
                                        </th>
                                        <th data-field="payment_type" data-sortable="false">
                                            {{ labels('admin_labels.type', 'Type') }}
                                        </th>
                                        <th data-field="payment_address" data-sortable="false">
                                            {{ labels('admin_labels.payment_address', 'Payment Address') }}
                                        </th>
                                        <th data-field="amount_requested" data-sortable="false">
                                            {{ labels('admin_labels.amount_requested', 'Amount Requested') }}
                                        </th>
                                        <th data-field="remarks" data-sortable="false">
                                            {{ labels('admin_labels.remarks', 'Remarks') }}
                                        </th>
                                        <th data-field="status" data-sortable="false">
                                            {{ labels('admin_labels.status', 'Statut') }}
                                        </th>
                                        <th data-field="date_created" data-sortable="false">
                                            {{ labels('admin_labels.date_created', 'Date Created') }}
                                        </th>
                                        <th data-field="operate" data-sortable="false">
                                            {{ labels('admin_labels.action', 'Actions') }}
                                        </th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- update modal --}}

    <div class="aurora-modal-overlay" style="display:none" id="payment_request_modal" tabindex="-1" role="dialog"
        aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
        <div class="modal-dialog  modal-lg modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="aurora-modal-header">
                    <h5 class="modal-title">
                        {{ labels('admin_labels.update_payment_request', 'Update Payment Request') }}
                    </h5>
                    <div class="d-flex justify-content-end"><button type="button" class="aurora-modal-close"
                            data-bs-dismiss="modal" aria-label="Fermer"></button></div>
                </div>
                <form class="form-horizontal submit_form" action="{{ route('admin.payment_request.update') }}"
                    method="POST" enctype="multipart/form-data">
                    @method('POST')
                    @csrf
                    <input type="hidden" name="payment_request_id" id="payment_request_id">
                    <div class="aurora-modal-body">
                        <div class="mb-2 col-md-12">
                            <label for="" class="control-label">{{ labels('admin_labels.status', 'Statut') }}
                                <span class='text-asterisks text-sm'>*</span></label>
                        </div>
                        <div id="status" class="btn-group mb-2">
                            <label class="btn reset-btn mx-2" data-toggle-class="btn-primary"
                                data-toggle-passive-class="btn-default">
                                <input type="radio" name="status" value="0" class='pending mx-1'> Pending
                            </label>
                            <label class="btn btn-primary mx-2" data-toggle-class="btn-primary"
                                data-toggle-passive-class="btn-default">
                                <input type="radio" name="status" value="1" class='approved mx-1'> Approved
                            </label>
                            <label class="btn btn-danger mx-2" data-toggle-class="btn-primary"
                                data-toggle-passive-class="btn-default">
                                <input type="radio" name="status" value="2" class='rejected mx-1'> Rejected
                            </label>
                        </div>
                        <div class="form-group col-md-12">
                            <label for="" class="mb-2">{{ labels('admin_labels.remarks', 'Remark') }}</label>
                            <textarea id="update_remarks" name="update_remarks" class="form-control col-12 "></textarea>
                        </div>
                        <input type="hidden" id="id" name="id">
                        <div class="ln_solid"></div>
                    </div>
                    <div class="aurora-modal-footer">
                        <div class="d-flex justify-content-end">
                            <button type="reset"
                                class="btn mx-2 reset_button">{{ labels('admin_labels.reset', 'Réinitialiser') }}</button>
                            <button type="submit" class="btn btn-primary submit_button"
                                id="submit_btn">{{ labels('admin_labels.update_payment_request', 'Update Payment Request') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
