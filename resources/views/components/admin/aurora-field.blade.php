<div class="aurora-field {{ $class ?? '' }}">
    @isset($label)
    <label for="{{ $id ?? '' }}">
        {{ $label }}
        @if($required ?? false) <span class="required">*</span> @endif
        @isset($hint) <span class="hint">{{ $hint }}</span> @endisset
    </label>
    @endisset
    {{ $slot }}
    @isset($error)
    <span class="aurora-field-error" style="font-size:12px;color:var(--aurora-danger);">{{ $error }}</span>
    @endisset
</div>
