<div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
    <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">{{ $label }}</p>
    <p class="text-sm font-medium text-admin-text{{ isset($mono) ? ' font-mono' : '' }}">{{ $value ?? '—' }}{{ $suffix ?? '' }}</p>
</div>
