@extends('admin/layout')
@section('title')
    {{ labels('admin_labels.brands', 'Marques') }}
@endsection
@section('content')
    <x-admin.breadcrumb :title="labels('admin_labels.brands', 'Marques')" :subtitle="labels(
        'admin_labels.elevate_your_store_with_seamless_brand_management',
        'Elevate Your Store with Seamless Brand Management',
    )" :breadcrumbs="[['label' => labels('admin_labels.brands', 'Marques')]]" />

    <div class="col-md-12">
        <div class="row">
            <div class="col-md-12 col-xl-4">
                <div class="aurora-card">
                    <div class="aurora-card-body">
                        <h5 class="mb-3">
                            {{ labels('admin_labels.add_brand', 'Add Brand') }}
                        </h5>
                    </div>
                    <form id="" action="{{ route('brands.store') }}" class="submit_form" enctype="multipart/form-data"
                        method="POST">
                        @csrf
                        <div class="card-body pt-0">
                            <ul class="aurora-tabs" id="brandTabs" role="tablist">
                                <li class="nav-item" role="presentation">
                                    <button class="language-nav-link nav-link active" id="tab-en" data-bs-toggle="tab"
                                        data-bs-target="#content-en" type="button" role="tab"
                                        aria-controls="content-en" aria-selected="true">
                                        {{ labels('admin_labels.default', 'Par défaut') }}
                                    </button>
                                </li>
                                <x-language.multi_language_tabs :languages="$languages" />
                            </ul>

                            <div class="tab-content mt-3" id="brandTabsContent">
                                <!-- Default 'en' tab content -->
                                <div class="" id="content-en" role="tabpanel"
                                    aria-labelledby="tab-en">
                                    <div class="mb-3">
                                        <label for="brand_name"
                                            class="form-label">{{ labels('admin_labels.name', 'Nom') }}<span
                                                class="text-asterisks text-sm">*</span></label>
                                        <input type="text" name="brand_name" class="aurora-input"
                                            placeholder="{{ labels('admin_labels.brand_name_placeholder', 'Brand Name') }}" value="">
                                    </div>
                                </div>
                                <x-language.multi_language_inputs :languages="$languages" nameKey="admin_labels.name" nameValue="Nom"
                                    inputName="translated_brand_name" />
                            </div>

                            <label for="" class="form-label">{{ labels('admin_labels.image', 'Image') }}<span
                                    class="text-asterisks text-sm">*</span></label>
                            <div class="col-md-12">
                                <div class="row form-group">
                                    <div class="col-md-6 file_upload_box border file_upload_border mt-4">
                                        <div class="mt-2">
                                            <div class="col-md-12  text-center">
                                                <div>
                                                    <a class="media_link" data-input="image" data-isremovable="0"
                                                        data-is-multiple-uploads-allowed="0" data-bs-toggle="modal"
                                                        data-bs-target="#media-upload-modal" value="Upload Photo">
                                                        <h4><i class='bx bx-upload'></i> Upload
                                                    </a></h4>
                                                    <p class="image_recommendation">{{ labels('admin_labels.recommended_size_180x180_pixels', 'Recommended Size: 180 x 180 pixels') }}</p>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6 container-fluid row mt-3 image-upload-section">
                                        <div
                                            class="col-md-12 col-sm-12 p-3 mb-5 bg-white rounded m-4 text-center grow image d-none">
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="reset"
                                        class="btn mx-2 reset_button">{{ labels('admin_labels.reset', 'Réinitialiser') }}</button>
                                    <button type="submit"
                                        class="btn btn-primary submit_button">{{ labels('admin_labels.add_brand', 'Add Brand') }}</button>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            {{-- table  --}}
            <div
                class="col-md-12 col-xl-8 mt-xl-0 mt-md-2 {{ $user_role == 'super_admin' || $logged_in_user->hasPermissionTo('view brands') ? '' : 'd-none' }}">
                <section class="">
                    <div class="card content-area p-4 ">
                        <div class="aurora-flex-between aurora-mb-4">
                            <div class="col-md-12">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <h4>{{ labels('admin_labels.manage_brands', 'Manage Brands') }}
                                        </h4>
                                    </div>

                                    <div class="col-sm-12 d-flex justify-content-end mt-md-0 mt-sm-2">
                                        <div class="input-group me-2 search-input-grp ">
                                            <span class="search-icon"><i class='bx bx-search-alt'></i></span>
                                            <input type="text" data-table="admin_brand_table"
                                                class="aurora-input" style="max-width:200px;display:inline-block" placeholder="{{ labels('admin_labels.search', 'Rechercher') }}">
                                            <span
                                                class="aurora-btn aurora-btn-secondary">{{ labels('admin_labels.search', 'Rechercher') }}</span>
                                        </div>
                                        <a class="aurora-toolbar-btn" id="tableFilter" data-bs-toggle="offcanvas"
                                            data-bs-target="#columnFilterOffcanvas" data-table="admin_brand_table"
                                            StatusFilter='true'><i class='bx bx-filter-alt'></i></a>
                                        <a class="aurora-toolbar-btn" id="tableRefresh" data-table="admin_brand_table"><i
                                                class='bx bx-refresh'></i></a>
                                        <div class="dropdown">
                                            <a class="btn dropdown-toggle export-btn" type="button"
                                                id="exportOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                                <i class='bx bx-download'></i>
                                            </a>
                                            <ul class="aurora-dropdown-menu" aria-labelledby="exportOptionsDropdown">
                                                <li><button class="aurora-dropdown-item" type="button"
                                                        onclick="exportTableData('admin_brand_table','csv')">{{ labels('admin_labels.csv', 'CSV') }}</button>
                                                </li>
                                                <li><button class="aurora-dropdown-item" type="button"
                                                        onclick="exportTableData('admin_brand_table','json')">{{ labels('admin_labels.json', 'JSON') }}</button>
                                                </li>
                                                <li><button class="aurora-dropdown-item" type="button"
                                                        onclick="exportTableData('admin_brand_table','sql')">{{ labels('admin_labels.sql', 'SQL') }}</button>
                                                </li>
                                                <li><button class="aurora-dropdown-item" type="button"
                                                        onclick="exportTableData('admin_brand_table','excel')">{{ labels('admin_labels.excel', 'Excel') }}</button>
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
                                    data-table-id="admin_brand_table"
                                    data-delete-url="{{ route('brands.delete') }}">{{ labels('admin_labels.delete_selected', 'Delete Selected') }}</button>
                            </div>
                            <div class="col-md-12">
                                <div class="pt-0">
                                    <div class="table-responsive">
                                        <table class='table' id="admin_brand_table" data-toggle="table"
                                            data-loading-template="loadingTemplate" data-url="{{ route('brands.list') }}"
                                            data-click-to-select="true" data-side-pagination="server"
                                            data-pagination="true" data-page-list="[5, 10, 20, 50, 100, 200]"
                                            data-search="false" data-show-columns="false" data-show-refresh="false"
                                            data-trim-on-search="false" data-sort-name="id" data-sort-order="desc"
                                            data-mobile-responsive="true" data-toolbar="" data-show-export="false"
                                            data-maintain-selected="true" data-export-types='["txt","excel"]'
                                            data-query-params="brand_query_params">
                                            <thead>
                                                <tr>
                                                    <th data-checkbox="true" data-field="delete-checkbox">
                                                        <input name="select_all" type="checkbox">
                                                    </th>
                                                    <th data-field="id" data-sortable="true" data-visible="true">
                                                        {{ labels('admin_labels.id', 'ID') }}
                                                    <th class="d-flex justify-content-center" data-field="image"
                                                        data-sortable="false">
                                                        {{ labels('admin_labels.image', 'Image') }}
                                                    </th>
                                                    <th data-field="name" data-disabled="1" data-sortable="false">
                                                        {{ labels('admin_labels.name', 'Nom') }}
                                                    </th>
                                                    <th data-field="status" data-sortable="false">
                                                        {{ labels('admin_labels.status', 'Statut') }}
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
@endsection
