@php
    $route = $route ?? null;
    $meta = $meta ?? null;
@endphp

@if($route)
    <a href="{{ route($route) }}" class="block rounded-xl p-6 bg-admin-card border border-admin-{{ $color }}/15 transition-all duration-200 hover:border-admin-{{ $color }}/40 hover:bg-admin-{{ $color }}/5 group">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-lg bg-admin-{{ $color }}/15">
                <svg class="w-6 h-6 text-admin-{{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                </svg>
            </div>
            <svg class="w-4 h-4 text-gray-500 group-hover:text-admin-{{ $color }} transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
            </svg>
        </div>
        <p class="text-3xl font-bold text-admin-{{ $color }}">{{ $value }}</p>
        <p class="text-sm mt-1 text-gray-400 group-hover:text-gray-300 transition-colors">{{ $label }}</p>
        @if($meta)
            <p class="text-xs mt-2 text-gray-500">{{ $meta }}</p>
        @endif
    </a>
@else
    <div class="rounded-xl p-6 bg-admin-card border border-admin-{{ $color }}/15">
        <div class="flex items-center justify-between mb-4">
            <div class="p-3 rounded-lg bg-admin-{{ $color }}/15">
                <svg class="w-6 h-6 text-admin-{{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                </svg>
            </div>
        </div>
        <p class="text-3xl font-bold text-admin-{{ $color }}">{{ $value }}</p>
        <p class="text-sm mt-1 text-gray-400">{{ $label }}</p>
        @if($meta)
            <p class="text-xs mt-2 text-gray-500">{{ $meta }}</p>
        @endif
    </div>
@endif
