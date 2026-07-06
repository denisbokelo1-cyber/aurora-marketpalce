@extends('admin/layout')
@section('title')
    {{ labels('admin_labels.upadate_custom_field', 'Update Custom Fields') }}
@endsection
@section('content')
    <x-admin.breadcrumb :title="labels('admin_labels.upadate_custom_field', 'Update Custom Fields')" :subtitle="labels(
        'admin_labels.effortless_custom_fields_management_for_an_organized_ecommerce_universe',
        'Effortless Custom Fields Management for an Organized E-commerce Universe',
    )" :breadcrumbs="[['label' => labels('admin_labels.upadate_custom_field', 'Update Custom Fields')]]" />
    <div class="row">
        <div class="col-md-4">
            <div class="aurora-card">
                <div class="aurora-card-body">
                    <form method="POST" action="{{ route('custom_fields.update', $customField->id) }}" class="submit_form">
                        @csrf
                        @method('PUT')

                        <div class="mb-3">
                            <label class="form-label">{{ labels('admin_labels.field_name', 'Nom du champ') }}</label><span
                                class='text-asterisks text-sm'>*</span>
                            <input type="text" name="name" class="aurora-input"
                                value="{{ old('name', $customField->name) }}">
                        </div>
                        <input type="hidden" name="type" value="{{ $customField->type }}">
                        <div class="mb-3">
                            <label class="form-label">{{ labels('admin_labels.field_type', 'Type du champ') }}</label><span
                                class='text-asterisks text-sm'>*</span>
                            <select disabled name="type" class="aurora-input" id="fieldTypeSelect">
                                <option value="">{{ labels('admin_labels.select', 'Sélectionner') }}</option>
                                @foreach (['text', 'number', 'textarea', 'color', 'date', 'file', 'radio', 'dropdown', 'checkbox'] as $type)
                                    <option value="{{ $type }}" {{ $customField->type == $type ? 'selected' : '' }}>
                                        {{ labels("admin_labels.$type", ucfirst($type)) }}
                                    </option>
                                @endforeach
                            </select>
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ labels('admin_labels.field_length', 'Field Length') }}</label>
                            <input type="number" min="1" name="field_length" class="aurora-input"
                                value="{{ old('field_length', $customField->field_length) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ labels('admin_labels.min', 'Min') }}</label>
                            <input type="number" min="1" name="min" class="aurora-input"
                                value="{{ old('min', $customField->min) }}">
                        </div>

                        <div class="mb-3">
                            <label class="form-label">{{ labels('admin_labels.max', 'Max') }}</label>
                            <input type="number" min="1" name="max" class="aurora-input"
                                value="{{ old('max', $customField->max) }}">
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="required" value="1"
                                id="requiredCheck" {{ $customField->required ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="requiredCheck">{{ labels('admin_labels.required', 'Obligatoire') }}</label>
                        </div>

                        <div class="form-check mb-3">
                            <input type="checkbox" name="active" value="1" id="activeCheck"
                                {{ $customField->active ? 'checked' : '' }}>
                            <label class="form-check-label"
                                for="activeCheck">{{ labels('admin_labels.active', 'Actif') }}</label>
                        </div>

                        <div
                            class="mb-3 customOptionInput {{ in_array($customField->type, ['radio', 'dropdown', 'checkbox']) ? '' : 'd-none' }}">
                            <label class="form-label">{{ labels('admin_labels.options', 'Options') }}</label>
                            <input type="text" id="custom_options" name="options" class="aurora-input"
                                value="{{ is_array($customField->options) ? implode(', ', $customField->options) : '' }}"
                                placeholder="{{ labels('admin_labels.placeholder_options_examples', 'e.g. Small, Medium, Large') }}">
                        </div>

                        <div class="d-flex justify-content-end mt-3">
                            <a href="{{ route('admin.custom_fields.index') }}" class="btn reset-btn mx-2">
                                {{ labels('admin_labels.cancel', 'Annuler') }}
                            </a>
                            <button type="submit" class="submit_button btn btn-primary">
                                {{ labels('admin_labels.update_custom_field', 'Update Custom Field') }}
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
