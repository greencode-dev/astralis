@php
    $route = $route ?? null;
    $meta = $meta ?? null;
    $colorMap = [
        'primary'   => ['var' => '--color-admin-primary',   'hex' => '#22D3EE'],
        'secondary' => ['var' => '--color-admin-secondary', 'hex' => '#A855F7'],
        'accent'    => ['var' => '--color-admin-accent',    'hex' => '#F97316'],
        'warning'   => ['var' => '--color-admin-warning',   'hex' => '#FACC15'],
    ];
    $c = $colorMap[$color] ?? $colorMap['primary'];
    $cssVar = "var({$c['var']})";
    $alpha15 = $c['hex'] . '26';
    $alpha40 = $c['hex'] . '66';
    $alpha05 = $c['hex'] . '0D';
@endphp

@if($route)
    <a href="{{ route($route) }}" class="block rounded-xl p-6 bg-admin-card border transition-all duration-200 group"
       style="border-color: {{ $alpha15 }}; --hover-border: {{ $alpha40 }}; --hover-bg: {{ $alpha05 }}; --accent: {{ $cssVar }}"
       onmouseenter="this.style.borderColor='{{ $alpha40 }}'; this.style.backgroundColor='{{ $alpha05 }}'"
       onmouseleave="this.style.borderColor='{{ $alpha15 }}'; this.style.backgroundColor=''">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-lg" style="background: {{ $alpha15 }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: {{ $cssVar }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                </svg>
            </div>
            <svg class="w-4 h-4 text-gray-500 transition-colors group-hover:text-admin-text" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                 style="color: var(--color-admin-muted)">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        <p class="text-3xl font-bold" style="color: {{ $cssVar }}">{{ $value }}</p>
        <p class="text-sm mt-1 text-gray-400 group-hover:text-gray-300 transition-colors">{{ $label }}</p>
        @if($meta)
            <p class="text-xs mt-2 text-gray-500">{{ $meta }}</p>
        @endif
    </a>
@else
    <div class="rounded-xl p-6 bg-admin-card border" style="border-color: {{ $alpha15 }}">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-lg" style="background: {{ $alpha15 }}">
                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color: {{ $cssVar }}">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold" style="color: {{ $cssVar }}">{{ $value }}</p>
        <p class="text-sm mt-1 text-gray-400">{{ $label }}</p>
        @if($meta)
            <p class="text-xs mt-2 text-gray-500">{{ $meta }}</p>
        @endif
    </div>
@endif
