@php
    $navItems = config('admin.nav_items');
    $currentRoute = request()->route()?->getName();
@endphp

<nav class="px-3 mt-4 space-y-1">
    @foreach ($navItems as $item)
        @php
            $isActive = request()->routeIs($item['route'] . '.*');
            if ($item['route'] === 'admin.dashboard') {
                $isActive = request()->routeIs('admin.dashboard');
            }
        @endphp
        <a href="{{ route($item['route']) }}"
           @if ($isActive)
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all duration-200 rounded-lg bg-admin-primary/15 text-admin-primary"
                aria-current="page"
            @else
                class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-gray-400 transition-all duration-200 rounded-lg hover:bg-admin-primary/8 hover:text-admin-primary"
            @endif>
            <svg class="flex-shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
            </svg>
            {{ $item['label'] }}
        </a>
    @endforeach
</nav>
