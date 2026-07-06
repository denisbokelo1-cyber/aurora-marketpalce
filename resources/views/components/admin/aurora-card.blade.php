<div class="aurora-card {{ $class ?? '' }}" {{ $attributes ?? '' }}>
    @isset($header)
    <div class="aurora-card-header">
        {{ $header }}
    </div>
    @endisset
    <div class="aurora-card-body">
        {{ $slot }}
    </div>
    @isset($footer)
    <div class="aurora-card-footer">
        {{ $footer }}
    </div>
    @endisset
</div>
