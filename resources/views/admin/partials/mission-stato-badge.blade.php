@php
    $stato = $missione->stato ?? 'completata';
    $colors = [
        'completata' => ['bg' => 'rgba(34,197,94,0.15)', 'text' => 'var(--admin-success)'],
        'in corso' => ['bg' => 'rgba(34,211,238,0.15)', 'text' => 'var(--admin-primary)'],
        'pianificata' => ['bg' => 'rgba(250,204,21,0.15)', 'text' => 'var(--admin-warning)'],
    ];
    $c = $colors[$stato] ?? ['bg' => 'rgba(107,114,128,0.15)', 'text' => 'var(--admin-neutral)'];
@endphp
<span class="inline-flex items-center{{ isset($withDot) && $withDot ? ' gap-1.5' : '' }} {{ $class ?? 'px-2.5 py-0.5 rounded-full text-xs font-medium' }}" style="background-color: {{ $c['bg'] }}; color: {{ $c['text'] }};">
    @if (isset($withDot) && $withDot)
        <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $c['text'] }};"></span>
    @endif
    {{ ucfirst($stato) }}
</span>
