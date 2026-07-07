@extends('admin/layout')
@section('title')
    {{ labels('admin_labels.categories', 'Catégories') }}
@endsection
@section('content')
    @php
        $user = auth()->user();
        $role = auth()->user()->role->name ?? '';
        use App\Services\TranslationService;
        use App\Models\Category;
        use App\Services\MediaService;
    @endphp

    <x-admin.breadcrumb :title="labels('admin_labels.categories', 'Catégories')" :subtitle="labels(
        'admin_labels.effortless_category_management_for_an_organized_ecommerce_universe',
        'Effortless Category Management for an Organized E-commerce Universe',
    )" :breadcrumbs="[['label' => labels('admin_labels.categories', 'Catégories')]]" />

    <div class="row">
        <div class="col-lg-12">
            <div class="row">
                <div class="col-xl-4 col-md-12 mb-2">
                    <div class="aurora-card">
                        <div class="aurora-card-body">
                            <div class="tree_view_html">

                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-8 col-md-12">
                    <div class="aurora-card">
                        <form id="categoryForm" action="{{ route('categories.store') }}" class="submit_form"
                            enctype="multipart/form-data" method="POST">
                            @csrf
                            <div class="aurora-card-body">
                                <h5 class="mb-3">
                                    {{ labels('admin_labels.add_category', 'Add Category') }}
                                </h5>
                                <div class="row">
                                    <ul class="aurora-tabs" id="brandTabs" role="tablist">
                                        <li class="nav-item" role="presentation">
                                            <button class="language-nav-link nav-link active" id="tab-en"
                                                data-bs-toggle="tab" data-bs-target="#content-en" type="button"
                                                role="tab" aria-controls="content-en" aria-selected="true">
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
                                                <label for="name" class="form-label">
                                                    {{ labels('admin_labels.name', 'Nom') }}
                                                    <span class="text-asterisks text-sm">*</span>
                                                </label>
                                                <input type="text" name="name" class="aurora-input"
                                                    placeholder="{{ labels('admin_labels.fashion_placeholder', 'Fashion') }}" value="">
                                            </div>
                                        </div>

                                        <x-language.multi_language_inputs :languages="$languages" nameKey="admin_labels.name"
                                            nameValue="Nom" inputName="translated_category_name" />
                                    </div>

                                    <div class="mb-3 col-md-12">
                                        <label class="form-label" for="parent_id">
                                            {{ labels('admin_labels.select_catgeory_for_sub_categories', 'Select Category for subCategory') }}
                                        </label>
                                        <select id="parent_id" name="parent_id" class="aurora-input">
                                            <option value="">
                                                {{ labels('admin_labels.select_category', 'Select Category') }}
                                            </option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}">
                                                    {{ app(TranslationService::class)->getDynamicTranslation(Category::class, 'name', $category->id, $language_code) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row">
                                    <div class="form-group col-md-6 mb-4">
                                        <label for="category_image" class="mb-2">
                                            {{ labels('admin_labels.image', 'Image') }}
                                            <span class='text-asterisks text-sm'>*</span>
                                        </label>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="file_upload_box border file_upload_border mt-2">
                                                    <div class="mt-2">
                                                        <div class="col-md-12 text-center">
                                                            <div>
                                                                <a class="media_link" data-input="category_image"
                                                                    data-isremovable="0"
                                                                    data-is-multiple-uploads-allowed="0"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#media-upload-modal"
                                                                    value="Upload Photo">
                                                                    <h4><i class='bx bx-upload'></i> {{ labels('admin_labels.upload', 'Upload') }}</h4>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container-fluid row image-upload-section mt-2">
                                                    <div class="col-md-8 col-sm-12 p-3 bg-white rounded text-center grow image d-none">
                                                        <div class="image-upload-div">
                                                            <img class="img-fluid mb-2 category-image-preview" src="" alt="Preview">
                                                            <a class="remove-image text-danger d-none" href="#"><i class="far fa-trash-alt me-1"></i> {{ labels('admin_labels.remove', 'Remove') }}</a>
                                                        </div>
                                                        <input type="hidden" name="category_image" id="category_image" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="form-group col-md-6">
                                        <label for="banner" class="mb-2">
                                            {{ labels('admin_labels.banner', 'Bannière') }}
                                            <span class='text-asterisks text-sm'>*</span>
                                        </label>
                                        <div class="col-md-12">
                                            <div class="form-group">
                                                <div class="file_upload_box border file_upload_border mt-2">
                                                    <div class="mt-2">
                                                        <div class="col-md-12 text-center">
                                                            <div>
                                                                <a class="media_link" data-input="banner"
                                                                    data-isremovable="0"
                                                                    data-is-multiple-uploads-allowed="0"
                                                                    data-bs-toggle="modal"
                                                                    data-bs-target="#media-upload-modal"
                                                                    value="Upload Photo">
                                                                    <h4><i class='bx bx-upload'></i> {{ labels('admin_labels.upload', 'Upload') }}</h4>
                                                                </a>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="container-fluid row image-upload-section mt-2">
                                                    <div class="col-md-8 col-sm-12 p-3 bg-white rounded text-center grow image d-none">
                                                        <div class="image-upload-div">
                                                            <img class="img-fluid mb-2 banner-image-preview" src="" alt="Preview">
                                                            <a class="remove-image text-danger d-none" href="#"><i class="far fa-trash-alt me-1"></i> {{ labels('admin_labels.remove', 'Remove') }}</a>
                                                        </div>
                                                        <input type="hidden" name="banner" id="banner" value="">
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <button type="reset" class="btn mt-4 reset-btn mx-2" id="">
                                        {{ labels('admin_labels.reset', 'Réinitialiser') }}
                                    </button>
                                    <button type="submit" class="btn btn-primary mt-4 submit_button" id="">
                                        {{ labels('admin_labels.add_category', 'Add Category') }}
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-md-12 main-content mt-4">
        <section class="">
            <div class="card content-area p-4">
                <div class="aurora-flex-between aurora-mb-4">
                    <div class="col-md-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <h4>{{ labels('admin_labels.categories', 'Catégories') }}</h4>
                            </div>
                            <div class="col-sm-12 d-flex justify-content-end mt-md-0 mt-sm-2">
                                <div class="input-group me-3 search-input-grp">
                                    <span class="search-icon"><i class='bx bx-search-alt'></i></span>
                                    <input type="text" data-table="admin_category_table"
                                        class="aurora-input" style="max-width:200px;display:inline-block"
                                        placeholder="{{ labels('admin_labels.search', 'Rechercher') }}">
                                    <span class="aurora-btn aurora-btn-secondary">{{ labels('admin_labels.search', 'Rechercher') }}</span>
                                </div>
                                <a class="aurora-toolbar-btn" id="tableFilter" data-bs-toggle="offcanvas"
                                    data-bs-target="#columnFilterOffcanvas" data-table="admin_category_table"
                                    StatusFilter='true'><i class='bx bx-filter-alt'></i></a>
                                <a class="aurora-toolbar-btn" id="tableRefresh" data-table="admin_category_table"><i
                                        class='bx bx-refresh'></i></a>
                                <div class="dropdown">
                                    <button class="btn dropdown-toggle export-btn" type="button"
                                        id="exportOptionsDropdown" data-bs-toggle="dropdown" aria-expanded="false">
                                        <i class='bx bx-download'></i>
                                    </button>
                                    <ul class="aurora-dropdown-menu" aria-labelledby="exportOptionsDropdown">
                                        <li><button class="aurora-dropdown-item" type="button"
                                                onclick="exportTableData('admin_category_table','csv')">{{ labels('admin_labels.csv', 'CSV') }}</button></li>
                                        <li><button class="aurora-dropdown-item" type="button"
                                                onclick="exportTableData('admin_category_table','json')">{{ labels('admin_labels.json', 'JSON') }}</button></li>
                                        <li><button class="aurora-dropdown-item" type="button"
                                                onclick="exportTableData('admin_category_table','sql')">{{ labels('admin_labels.sql', 'SQL') }}</button></li>
                                        <li><button class="aurora-dropdown-item" type="button"
                                                onclick="exportTableData('admin_category_table','excel')">{{ labels('admin_labels.excel', 'Excel') }}</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="d-flex justify-content-start mt-2">
                    <button type="button" class="btn btn-outline-primary btn-sm delete_selected_data"
                        data-table-id="admin_category_table"
                        data-delete-url="{{ route('categories.delete') }}">{{ labels('admin_labels.delete_selected', 'Delete Selected') }}</button>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="pt-0">
                            <div class="card-body p-0 list_view_html">
                                <div class="gaps-1-5x"></div>
                                <div class="table-responsive">
                                    <table id='admin_category_table' data-toggle="table"
                                        data-loading-template="loadingTemplate" data-url="{{ route('categories.list') }}"
                                        data-side-pagination="server" data-pagination="true" data-click-to-select="true"
                                        data-page-list="[5, 10, 20, 50, 100, 200]" data-search="false"
                                        data-show-columns="false" data-show-refresh="false" data-trim-on-search="false"
                                        data-sort-name="id" data-sort-order="desc" data-mobile-responsive="true"
                                        data-toolbar="" data-show-export="false" data-maintain-selected="true"
                                        data-export-types='["txt","excel","pdf","csv"]'
                                        data-export-options='{"fileName": "categories-list","ignoreColumn": ["action"]}'
                                        data-query-params="category_query_params">
                                        <thead>
                                            <tr>
                                                <th data-checkbox="true" data-field="delete-checkbox">
                                                    <input name="select_all" type="checkbox">
                                                </th>
                                                <th data-field="id" data-sortable="true" data-visible='true'>
                                                    {{ labels('admin_labels.id', 'ID') }}
                                                </th>
                                                <th data-field="name" data-disabled="1" data-sortable="false">
                                                    {{ labels('admin_labels.name', 'Nom') }}
                                                </th>
                                                <th class="d-flex justify-content-center" data-field="image"
                                                    data-sortable="false">
                                                    {{ labels('admin_labels.image', 'Image') }}
                                                </th>
                                                <th data-field="banner" data-sortable="false">
                                                    {{ labels('admin_labels.banner', 'Banner Image') }}
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
                            <div id="" class="d-none tree_view_html"></div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>

    <!-- Commission Modal -->
    <div class="aurora-modal-overlay" style="display:none" id="commissionModal" tabindex="-1" role="dialog"
        aria-labelledby="commissionLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="aurora-modal-header">
                    <h5 class="modal-title" id="commissionLabel">
                        {{ labels('admin_labels.set_commission_and_approve_category', 'Set Commission & Approve Category') }}
                    </h5>
                    <button type="button" class="aurora-modal-close" data-bs-dismiss="modal" aria-label="Fermer"></button>
                </div>
                <form id="commissionForm">
                    <div class="aurora-modal-body">
                        <input type="hidden" id="categoryIdForCommission" name="category_id">
                        <input type="hidden" id="commissionUrl" name="url">
                        <div class="mb-3">
                            <label class="form-label">
                                {{ labels('admin_labels.commission_percentage_label', 'Commission (%)') }}
                                <span class='text-asterisks text-sm'>*</span>
                            </label>
                            <input type="number" id="commissionPercentage" name="commission" class="aurora-input"
                                placeholder="{{ labels('admin_labels.enter_commission_percentage_placeholder', 'Enter commission percentage') }}"
                                min="0" max="100" step="0.01" required>
                            <small class="form-text text-muted">
                                {{ labels('admin_labels.enter_commission_percentage_for_seller_hint', 'Enter commission percentage for the seller (0-100%)') }}
                            </small>
                        </div>
                    </div>
                    <div class="aurora-modal-footer">
                        <button type="button" class="aurora-btn aurora-btn-secondary" data-bs-dismiss="modal">
                            {{ labels('admin_labels.cancel_button', 'Annuler') }}
                        </button>
                        <button type="submit" class="aurora-btn aurora-btn-primary">
                            {{ labels('admin_labels.approve_and_set_commission', 'Approve & Set Commission') }}
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Handle commission form submission
        $('#commissionForm').on('submit', function(e) {
            e.preventDefault();

            const commission = $('#commissionPercentage').val();
            const url = $('#commissionUrl').val();

            if (!commission || commission < 0 || commission > 100) {
                iziToast.error({
                    title: 'Erreur',
                    message: 'Invalid commission percentage',
                    position: 'topRight'
                });
                return;
            }

            const modalEl = document.getElementById('commissionModal');
            const modal = bootstrap.Modal.getInstance(modalEl);
            if (modal) modal.hide();

            fetch(url + '?status=1&commission=' + commission)
                .then(res => res.json())
                .then(response => {
                    if (response.status_error) {
                        iziToast.error({
                            title: 'Erreur',
                            message: response.status_error,
                            position: 'topRight'
                        });
                    } else {
                        iziToast.success({
                            title: 'Succès',
                            message: 'Category approved and commission set',
                            position: 'topRight'
                        });
                        document.getElementById('admin_category_table')
                            .dispatchEvent(new Event('refresh'));
                    }
                })
                .catch(() => {
                    iziToast.error({
                        title: 'Erreur',
                        message: 'Request failed',
                        position: 'topRight'
                    });
                });
        });

        // Handle image preview when media is selected
        $(document).on('media-selected', function(e, data) {
            var inputName = data.input;
            var imageUrl = data.url;
            var imagePath = data.path;

            // Find the correct form group
            var $formGroup = $('[data-input="' + inputName + '"]').closest('.form-group');

            if (inputName === 'category_image') {
                $formGroup.find('.image.d-none').removeClass('d-none');
                $formGroup.find('.category-image-preview').attr('src', imageUrl);
                $('#category_image').val(imagePath);
                $formGroup.find('.remove-image').removeClass('d-none');
            } else if (inputName === 'banner') {
                $formGroup.find('.image.d-none').removeClass('d-none');
                $formGroup.find('.banner-image-preview').attr('src', imageUrl);
                $('#banner').val(imagePath);
                $formGroup.find('.remove-image').removeClass('d-none');
            }
        });

        // Handle remove image
        $(document).on('click', '.remove-image', function(e) {
            e.preventDefault();
            var $container = $(this).closest('.image');
            var $formGroup = $container.closest('.form-group');
            var $input = $formGroup.find('input[type="hidden"]');

            $container.addClass('d-none');
            $container.find('img').attr('src', '');
            $input.val('');
            $(this).addClass('d-none');
        });

        // Handle form reset
        $('button[type="reset"]').on('click', function(e) {
            e.preventDefault();
            var form = $(this).closest('form');
            form[0].reset();
            form.find('.image').addClass('d-none');
            form.find('img').attr('src', '');
            form.find('input[type="hidden"]').val('');
            form.find('.remove-image').addClass('d-none');
        });
    });
    </script>
@endsection
