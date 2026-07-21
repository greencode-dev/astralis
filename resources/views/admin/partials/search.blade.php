<form method="GET" action="{{ $action }}" class="flex gap-2 mb-3">
    <input type="text" name="search" value="{{ request('search') }}" placeholder="{{ $placeholder ?? 'Cerca...' }}"
           class="admin-input flex-1" aria-label="{{ $placeholder ?? 'Cerca' }}">
    <button type="submit"
            class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25">
        Cerca
    </button>
    @php
        $hasFilters = request('search');
        foreach (($extraFilters ?? []) as $f) {
            if (request($f)) { $hasFilters = true; break; }
        }
    @endphp
    @if ($hasFilters)
        <a href="{{ $action }}"
           class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-gray-400 border border-gray-400/20 hover:text-admin-error hover:border-admin-error/30">
            Cancella filtro
        </a>
    @endif
</form>
