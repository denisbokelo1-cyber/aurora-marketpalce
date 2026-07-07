@extends('admin/layout')
@section('title')
    {{ labels('admin_labels.update_category', 'Update Category') }}
@endsection
@section('content')
    @php
        use App\Models\Category;
        use App\Services\TranslationService;
        use App\Services\MediaService;
    @endphp
    <x-admin.breadcrumb :title="labels('admin_labels.categories', 'Catégories')" :subtitle="labels(
        'admin_labels.effortless_category_management_for_an_organized_ecommerce_universe',
        'Effortless Category Management for an Organized E-commerce Universe',
    )" :breadcrumbs="[['label' => labels('admin_labels.categories', 'Catégories')]]" />

    <div class="row">
        <div class="col-xl">
            <div class="card mb-4">
                <div class="aurora-card-body">
                    <h5 class="mb-3">
                        {{ labels('admin_labels.update_category', 'Update Category') }}
                    </h5>
                    <div class="row">
                        <div class="form-group">
                            <form action="{{ url('/admin/categories/update/' . $data->id) }}" enctype="multipart/form-data"
                                method="POST" class="submit_form">
                                @method('PUT')
                                @csrf
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
                                    <div class="tab-content mt-3" id="UpdatebrandTabsContent">
                                        <div class="" id="content-en" role="tabpanel" aria-labelledby="tab-en">
                                            <div class="mb-3">
                                                <label for="brand_name" class="form-label">
                                                    {{ labels('admin_labels.name', 'Nom') }}<span class="text-asterisks text-sm">*</span>
                                                </label>
                                                <input type="text" class="aurora-input" id="basic-default-fullname"
                                                    placeholder="{{ labels('admin_labels.gucci_placeholder', 'Gucci') }}" name="name"
                                                    value="{{ isset($data->name) ? json_decode($data->name)->en : '' }}">
                                            </div>
                                        </div>
                                        <x-language.multi_language_updateable_inputs :languages="$languages" :data="$data->name"
                                            nameKey="admin_labels.name" nameValue="Nom"
                                            inputName="translated_category_name" />
                                    </div>

                                    <div class="col-md-12">
                                        <label class="form-label" for="parent_id">
                                            {{ labels('admin_labels.select_catgeory_for_sub_categories', 'Select Category for subCategory') }}
                                        </label>
                                        <select id="parent_id" name="parent_id" class="aurora-input">
                                            <option value="">{{ labels('admin_labels.select_a_category_option', 'select a category') }}</option>
                                            @foreach ($categories as $category)
                                                <option value="{{ $category->id }}"
                                                    {{ $category->id == $data->parent_id ? 'selected' : '' }}>
                                                    {{ app(TranslationService::class)->getDynamicTranslation(Category::class, 'name', $category->id, $language_code) }}
                                                </option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>

                                <div class="row mt-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="file_upload_box border file_upload_border mt-2">
                                                <div class="mt-2">
                                                    <div class="col-md-12 text-center">
                                                        <div>
                                                            <a class="media_link" data-input="category_image"
                                                                data-isremovable="0" data-is-multiple-uploads-allowed="0"
                                                                data-bs-toggle="modal" data-bs-target="#media-upload-modal"
                                                                value="Upload Photo">
                                                                <h4><i class='bx bx-upload'></i> {{ labels('admin_labels.upload_option', 'Télécharger') }}</h4>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="" class="text-danger mt-3">*{{ labels('admin_labels.only_choose_when_update_necessary', 'Only Choose When Update is necessary') }}</label>

                                            <div class="container-fluid row image-upload-section mt-2">
                                                @if ($data->image && !empty($data->image))
                                                    <div class="col-md-8 col-sm-12 shadow p-3 mb-3 bg-white rounded text-center grow image">
                                                        <div class="image-upload-div">
                                                            <img class="img-fluid mb-2 category-image-preview"
                                                                src="{{ route('admin.dynamic_image', ['url' => app(MediaService::class)->getMediaImageUrl($data->image), 'width' => 150, 'quality' => 90]) }}"
                                                                alt="{{ labels('admin_labels.not_found_alt', 'Image') }}">
                                                        </div>
                                                        <input type="hidden" name="category_image" id="category_image" value="{{ $data->image }}">
                                                        <div class="mt-2">
                                                            <a class="remove-image text-danger" href="#"><i class="far fa-trash-alt me-1"></i> {{ labels('admin_labels.remove', 'Remove') }}</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-8 col-sm-12 p-3 bg-white rounded text-center grow image d-none">
                                                        <div class="image-upload-div">
                                                            <img class="img-fluid mb-2 category-image-preview" src="" alt="Preview">
                                                        </div>
                                                        <input type="hidden" name="category_image" id="category_image" value="">
                                                        <div class="mt-2">
                                                            <a class="remove-image text-danger d-none" href="#"><i class="far fa-trash-alt me-1"></i> {{ labels('admin_labels.remove', 'Remove') }}</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <div class="file_upload_box border file_upload_border mt-2">
                                                <div class="mt-2">
                                                    <div class="col-md-12 text-center">
                                                        <div>
                                                            <a class="media_link" data-input="banner" data-isremovable="0"
                                                                data-is-multiple-uploads-allowed="0" data-bs-toggle="modal"
                                                                data-bs-target="#media-upload-modal" value="Upload Photo">
                                                                <h4><i class='bx bx-upload'></i> {{ labels('admin_labels.upload_option', 'Télécharger') }}</h4>
                                                            </a>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <label for="" class="text-danger mt-3">*{{ labels('admin_labels.only_choose_when_update_necessary', 'Only Choose When Update is necessary') }}</label>

                                            <div class="container-fluid row image-upload-section mt-2">
                                                @if ($data->banner && !empty($data->banner))
                                                    <div class="col-md-8 col-sm-12 shadow p-3 mb-3 bg-white rounded text-center grow image">
                                                        <div class="image-upload-div">
                                                            <img class="img-fluid mb-2 banner-image-preview"
                                                                src="{{ route('admin.dynamic_image', ['url' => app(MediaService::class)->getMediaImageUrl($data->banner), 'width' => 150, 'quality' => 90]) }}"
                                                                alt="{{ labels('admin_labels.not_found_alt', 'Banner') }}">
                                                        </div>
                                                        <input type="hidden" name="banner" id="banner" value="{{ $data->banner }}">
                                                        <div class="mt-2">
                                                            <a class="remove-image text-danger" href="#"><i class="far fa-trash-alt me-1"></i> {{ labels('admin_labels.remove', 'Remove') }}</a>
                                                        </div>
                                                    </div>
                                                @else
                                                    <div class="col-md-8 col-sm-12 p-3 bg-white rounded text-center grow image d-none">
                                                        <div class="image-upload-div">
                                                            <img class="img-fluid mb-2 banner-image-preview" src="" alt="Preview">
                                                        </div>
                                                        <input type="hidden" name="banner" id="banner" value="">
                                                        <div class="mt-2">
                                                            <a class="remove-image text-danger d-none" href="#"><i class="far fa-trash-alt me-1"></i> {{ labels('admin_labels.remove', 'Remove') }}</a>
                                                        </div>
                                                    </div>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mb-3 d-flex justify-content-end">
                                    <button type="submit" class="btn btn-primary submit_button" id="">
                                        {{ labels('admin_labels.update_category', 'Update Category') }}
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script>
    $(document).ready(function() {
        // Handle image preview when media is selected
        $(document).on('media-selected', function(e, data) {
            var inputName = data.input;
            var imageUrl = data.url;
            var imagePath = data.path;

            // Find the correct form group
            var $formGroup = $('[data-input="' + inputName + '"]').closest('.form-group');

            if (inputName === 'category_image') {
                // Hide the old image container if it exists
                $formGroup.find('.image').each(function() {
                    if ($(this).find('input[name="category_image"]').length) {
                        // Show this container, update its image
                        $(this).removeClass('d-none');
                        $(this).find('.category-image-preview').attr('src', imageUrl);
                        $(this).find('input[name="category_image"]').val(imagePath);
                        $(this).find('.remove-image').removeClass('d-none');
                    }
                });
                // Fallback: find the hidden d-none container
                if ($formGroup.find('.image.d-none').length) {
                    $formGroup.find('.image.d-none').removeClass('d-none');
                    $formGroup.find('.category-image-preview').attr('src', imageUrl);
                    $('#category_image').val(imagePath);
                    $formGroup.find('.remove-image').removeClass('d-none');
                }
            } else if (inputName === 'banner') {
                $formGroup.find('.image').each(function() {
                    if ($(this).find('input[name="banner"]').length) {
                        $(this).removeClass('d-none');
                        $(this).find('.banner-image-preview').attr('src', imageUrl);
                        $(this).find('input[name="banner"]').val(imagePath);
                        $(this).find('.remove-image').removeClass('d-none');
                    }
                });
                if ($formGroup.find('.image.d-none').length) {
                    $formGroup.find('.image.d-none').removeClass('d-none');
                    $formGroup.find('.banner-image-preview').attr('src', imageUrl);
                    $('#banner').val(imagePath);
                    $formGroup.find('.remove-image').removeClass('d-none');
                }
            }
        });

        // Handle remove image
        $(document).on('click', '.remove-image', function(e) {
            e.preventDefault();
            var $container = $(this).closest('.image');
            var $formGroup = $container.closest('.form-group');
            var $input = $container.find('input[type="hidden"]');

            $container.addClass('d-none');
            $container.find('img').attr('src', '');
            $input.val('');
            $(this).addClass('d-none');
        });
    });
    </script>
@endsection
