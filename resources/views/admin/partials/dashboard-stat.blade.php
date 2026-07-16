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
</div>
