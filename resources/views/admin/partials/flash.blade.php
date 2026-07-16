@php
    $flashTypes = [
        ['key' => 'success', 'color' => 'admin-success', 'role' => 'status', 'ariaLive' => 'polite'],
        ['key' => 'warning', 'color' => 'admin-accent',  'role' => 'alert',  'ariaLive' => null],
        ['key' => 'error',   'color' => 'admin-error',   'role' => 'alert',  'ariaLive' => null],
    ];
@endphp

@foreach ($flashTypes as $flash)
    @if (session($flash['key']))
        <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
             x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
             class="mb-6 p-4 rounded-lg text-sm flex items-center justify-between bg-{{ $flash['color'] }}/15 text-{{ $flash['color'] }} border border-{{ $flash['color'] }}/20"
             role="{{ $flash['role'] }}" @if($flash['ariaLive']) aria-live="{{ $flash['ariaLive'] }}" @endif>
            <span>{{ session($flash['key']) }}</span>
            <button @click="show = false" class="ml-4 shrink-0 hover:opacity-70" aria-label="Chiudi">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
            </button>
        </div>
    @endif
@endforeach
