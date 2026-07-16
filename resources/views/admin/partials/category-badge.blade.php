@php
    $color = $color ?? 'var(--admin-primary)';
    $size = $size ?? 'sm';
@endphp
@if ($name)
    <span @class([
        'inline-flex items-center rounded-full font-medium',
        'gap-1.5 px-2.5 py-0.5 text-xs' => $size === 'sm',
        'gap-2 px-4 py-1.5 text-sm' => $size === 'lg',
    ]) style="background-color: {{ $color }}20; color: {{ $color }};">
        @if (isset($withDot) && $withDot)
            <span @class([
                'rounded-full',
                'w-1.5 h-1.5' => $size === 'sm',
                'w-2.5 h-2.5' => $size === 'lg',
            ]) style="background-color: {{ $color }};"></span>
        @endif
        {{ $name }}
    </span>
@endif
