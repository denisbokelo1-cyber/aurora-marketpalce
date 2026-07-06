@extends('admin/layout')
@section('title')
    {{ labels('admin_labels.faqs', 'Faqs') }}
@endsection
@section('content')
    <x-admin.breadcrumb :title="labels('admin_labels.faqs', 'Faqs')" :subtitle="labels(
        'admin_labels.answer_queries_with_clarity_in_the_faqs_section',
        'Answer Queries with Clarity in the FAQs Section',
    )" :breadcrumbs="[['label' => labels('admin_labels.faqs', 'Faqs')]]" />

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 col-lg-4">
                <div class="aurora-card">
                    <div class="aurora-card-body">
                        <h5 class="mb-3">
                            {{ labels('admin_labels.faqs', 'Faqs') }}
                        </h5>
                    </div>
                    <form class="form-horizontal submit_form" action="{{ route('faqs.store') }}" method="POST"
                        enctype="multipart/form-data">
                        @csrf
                        <div class="card-body pt-0">
                            <div class="mb-3">
                                <label for="question" class="form-label">{{ labels('admin_labels.question', 'Question') }}
                                    <span class='text-asterisks text-xs'>*</span></label>
                                <input type="text" class="aurora-input" id="question" name="question">
                            </div>
                            <div class="mb-3">
                                <label for="answer" class="form-label">{{ labels('admin_labels.answer', 'Answer') }}
                                    </label>
                                <textarea class="aurora-input" id="answer" name="answer"></textarea>
                            </div>

                            <div class="d-flex justify-content-end">
                                <button type="reset"
                                    class="btn mx-2 reset_button">{{ labels('admin_labels.reset', 'Réinitialiser') }}</button>
                                <button type="submit"
                                    class="btn btn-primary submit_button">{{ labels('admin_labels.add_faqs', 'Add Faqs') }}</button>
                            </div>

                        </div>
                    </form>
                </div>
            </div>
            <div
                class="col-lg-8 col-md-12 mt-md-2 mt-sm-2 {{ $user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view faq') ? '' : 'd-none' }}">
                <section class="">
                    <div class="card content-area p-4 ">
                        <div class="aurora-flex-between aurora-mb-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-md-12 col-lg-6">
                                        <h4>{{ labels('admin_labels.faqs', 'Faqs') }}
                                        </h4>
                                    </div>
                                    <div class="col-md-12 col-lg-6 d-flex justify-content-end mt-md-0 mt-sm-2">
                                        <div class="input-group me-2 search-input-grp ">
                                            <span class="search-icon"><i class='bx bx-search-alt'></i></span>
                                            <input type="text" data-table="admin_faqs_table"
                                                class="aurora-input" style="max-width:200px;display:inline-block" placeholder="{{ labels('admin_labels.search', 'Rechercher') }}">
                                            <span
                                                class="aurora-btn aurora-btn-secondary">{{ labels('admin_labels.search', 'Rechercher') }}</span>
                                        </div>
                                        <a class="aurora-toolbar-btn" id="tableFilter" data-bs-toggle="offcanvas"
                                            data-bs-target="#columnFilterOffcanvas" data-table="admin_faqs_table"
                                            dateFilter='false' orderStatusFilter='false' paymentMethodFilter='false'
                                            orderTypeFilter='false'><i class='bx bx-filter-alt'></i></a>
                                        <a class="aurora-toolbar-btn" id="tableRefresh"data-table="admin_faqs_table"><i
                                                class='bx bx-refresh'></i></a>
                                        <div class="dropdown">
                                            <a class="btn dropdown-toggle export-btn" type="button"
                                                id="exportOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class='bx bx-download'></i>
                                            </a>
                                            <ul class="aurora-dropdown-menu" aria-labelledby="exportOptionsDropdown">
                                                <li><button class="aurora-dropdown-item" type="button"
                                                        onclick="exportTableData('admin_faqs_table','csv')">{{ labels('admin_labels.csv', 'CSV') }}</button>
                                                </li>
                                                <li><button class="aurora-dropdown-item" type="button"
                                                        onclick="exportTableData('admin_faqs_table','json')">{{ labels('admin_labels.json', 'JSON') }}</button>
                                                </li>
                                                <li><button class="aurora-dropdown-item" type="button"
                                                        onclick="exportTableData('admin_faqs_table','sql')">{{ labels('admin_labels.sql', 'SQL') }}</button>
                                                </li>
                                                <li><button class="aurora-dropdown-item" type="button"
                                                        onclick="exportTableData('admin_faqs_table','excel')">{{ labels('admin_labels.excel', 'Excel') }}</button>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-6">
                                <button type="button" class="btn btn-outline-primary btn-sm delete_selected_data"
                                    data-table-id="admin_faqs_table"
                                    data-delete-url="{{ route('faqs.delete') }}">{{ labels('admin_labels.delete_selected', 'Delete Selected') }}</button>
                            </div>
                            <div class="col-md-12">
                                <div class="pt-0">
                                    <div class="table-responsive">
                                        <table class='table' id="admin_faqs_table" data-toggle="table"
                                            data-loading-template="loadingTemplate" data-url="{{ route('faqs.list') }}"
                                            data-click-to-select="true" data-side-pagination="server" data-pagination="true"
                                            data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false"
                                            data-show-columns="false" data-show-refresh="false"
                                            data-trim-on-search="false" data-sort-name="id" data-sort-order="desc"
                                            data-mobile-responsive="true" data-toolbar="" data-show-export="false"
                                            data-maintain-selected="true" data-export-types='["txt","excel"]'
                                            data-query-params="queryParams">
                                            <thead>
                                                <tr>
                                                    <th data-checkbox="true" data-field="delete-checkbox">
                                                        <input name="select_all" type="checkbox">
                                                    </th>
                                                    <th data-field="id" data-sortable="true">
                                                        {{ labels('admin_labels.id', 'ID') }}
                                                    <th data-field="question" data-disabled="1" data-sortable="false">
                                                        {{ labels('admin_labels.question', 'Question') }}
                                                    </th>
                                                    <th data-field="answer" data-disabled="1" data-sortable="false">
                                                        {{ labels('admin_labels.answer', 'Answer') }}
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
            </div>
        </div>
    </div>

    <!-- edit modal -->

    <div class="modal fade submit_form_edit" id="edit_modal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered" role="document">
            <div class="modal-content">
                <div class="aurora-modal-header">
                    <h5 class="modal-title" id="editModalLabel">
                        {{ labels('admin_labels.update_product_faq', 'Update FAQ') }}
                    </h5>
                    <div class="d-flex justify-content-end"><button type="button" class="aurora-modal-close"
                            data-bs-dismiss="modal" aria-label="Fermer"></button></div>
                </div>
                <form enctype="multipart/form-data" method="POST" class="submit_form">
                    @method('PUT')
                    @csrf
                    <input type="hidden" id="edit_tax_id" name="edit_tax_id">
                    <div class="aurora-modal-body">
                        <div class="form-group">
                            <label for="edit_question"
                                class="mb-2 mt-2">{{ labels('admin_labels.question', 'Question') }}</label>
                            <input type="text" class="form-control edit_question" id=""
                                name="edit_question">
                        </div>
                        <div class="form-group">
                            <label for="edit_answer"
                                class="mb-2 mt-2">{{ labels('admin_labels.answer', 'Answer') }}</label>
                            <input type="text" class="form-control edit_answer" id="" name="edit_answer">
                        </div>
                    </div>
                    <div class="d-flex justify-content-end m-4">
                        <button type="button" class="btn mx-2 reset_button" data-bs-dismiss="modal" aria-label="Fermer">
                            {{ labels('admin_labels.close', 'Fermer') }}
                        </button>
                        <button type="submit" class="btn btn-primary submit_button"
                            id="">{{ labels('admin_labels.update_product_faq', 'Update Product FAQ') }}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
@endsection
