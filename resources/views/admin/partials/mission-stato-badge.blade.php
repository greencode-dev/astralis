@php
    $stato = $missione->stato ?? 'Completata';
    $stati = config('admin.mission_stati');
    $c = $stati[$stato] ?? config('admin.mission_stato_default');
@endphp
<span class="inline-flex items-center{{ isset($withDot) && $withDot ? ' gap-1.5' : '' }} {{ $class ?? 'px-2.5 py-0.5 rounded-full text-xs font-medium' }}" style="background-color: {{ $c['bg'] }}; color: {{ $c['text'] }};">
    @if (isset($withDot) && $withDot)
        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $c['text'] }};"></span>
    @endif
    {{ ucfirst($stato) }}
</span>
