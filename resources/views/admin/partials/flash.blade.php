@if (session('success'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="mb-6 p-4 rounded-lg text-sm flex items-center justify-between bg-green-500/15 text-green-500 border border-green-500/20"
         role="status" aria-live="polite">
        <span>{{ session('success') }}</span>
        <button @click="show = false" class="ml-4 shrink-0 hover:opacity-70" aria-label="Chiudi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if (session('warning'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="mb-6 p-4 rounded-lg text-sm flex items-center justify-between bg-admin-accent/15 text-admin-accent border border-admin-accent/20"
         role="alert">
        <span>{{ session('warning') }}</span>
        <button @click="show = false" class="ml-4 shrink-0 hover:opacity-70" aria-label="Chiudi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif

@if (session('error'))
    <div x-data="{ show: true }" x-init="setTimeout(() => show = false, 5000)" x-show="show"
         x-transition:leave="transition ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="mb-6 p-4 rounded-lg text-sm flex items-center justify-between bg-red-500/15 text-red-500 border border-red-500/20"
         role="alert">
        <span>{{ session('error') }}</span>
        <button @click="show = false" class="ml-4 shrink-0 hover:opacity-70" aria-label="Chiudi">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>
@endif
