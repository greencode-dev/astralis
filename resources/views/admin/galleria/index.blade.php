@extends('admin.layouts.app')

@section('title', 'Galleria')
@section('page_title', 'Galleria')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-gray-400">Gestisci le immagini della galleria dei corpi celesti</p>
        <a href="{{ route('admin.galleria.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:brightness-90">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Immagine
        </a>
    </div>

    @include('admin.partials.flash')

    @include('admin.partials.search', ['action' => route('admin.galleria.index'), 'placeholder' => 'Cerca per nome...'])

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse ($galleria as $item)
            <div class="rounded-xl overflow-hidden transition-all duration-200 bg-admin-card border border-admin-primary/10 hover:border-admin-primary/30 hover:-translate-y-0.5">
                <div class="aspect-video relative overflow-hidden bg-admin-bg">
                    <img loading="lazy" src="{{ $item->percorso_url }}"
                         alt="{{ $item->didascalia ?? $item->corpoCeleste->nome }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                         onerror="this.alt='Immagine non disponibile'; this.style.display='none'; this.parentElement.innerHTML='<div role=\"img\" aria-label=\"Immagine non disponibile per {{ $item->corpoCeleste->nome }}\" style=\"display:flex;align-items:center;justify-content:center;height:100%;padding:1rem;text-align:center;color:var(--admin-neutral);font-size:0.75rem;\">Immagine non disponibile</div>';">
                </div>
                <div class="p-3">
                    <p class="text-sm font-medium truncate text-admin-text">{{ $item->didascalia ?? 'Senza didascalia' }}</p>
                    <p class="text-xs mt-1 text-admin-primary">
                        <a href="{{ route('admin.corpi-celesti.show', $item->corpoCeleste) }}"
                           class="transition-colors duration-150 hover:text-admin-secondary">
                            {{ $item->corpoCeleste->nome }}
                        </a>
                    </p>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center gap-1">
                            <form method="POST" action="{{ route('admin.galleria.ordine', $item) }}" class="inline">
                                @csrf
                                <input type="hidden" name="direzione" value="su">
                                        <button type="submit"
                                                class="p-1 rounded-lg transition-all duration-200 text-gray-500 hover:text-admin-primary hover:bg-admin-primary/10"
                                                aria-label="Sposta su {{ $item->didascalia ?? $item->corpoCeleste->nome }}"
                                        title="Sposta su">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                </button>
                            </form>
                            <span class="text-xs font-mono text-gray-500 min-w-[1.5rem] text-center">{{ $item->ordine }}</span>
                            <form method="POST" action="{{ route('admin.galleria.ordine', $item) }}" class="inline">
                                @csrf
                                <input type="hidden" name="direzione" value="giu">
                                        <button type="submit"
                                                class="p-1 rounded-lg transition-all duration-200 text-gray-500 hover:text-admin-primary hover:bg-admin-primary/10"
                                                aria-label="Sposta giù {{ $item->didascalia ?? $item->corpoCeleste->nome }}"
                                        title="Sposta giù">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                            </form>
                        </div>
                        @include('admin.partials.index-actions', ['size' => 'sm', 'editRoute' => route('admin.galleria.edit', $item), 'deleteRoute' => route('admin.galleria.destroy', $item), 'entityName' => $item->didascalia ?? $item->corpoCeleste->nome])
                    </div>
                    @if ($item->crediti)
                        <p class="text-xs mt-1 text-gray-500">📷 {{ $item->crediti }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <p class="text-lg mb-2 text-gray-500">Nessuna immagine nella galleria</p>
                <a href="{{ route('admin.galleria.create') }}" class="text-sm font-medium transition-colors duration-150 hover:text-admin-secondary text-admin-primary">Aggiungi la prima immagine</a>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $galleria->links() }}
    </div>
@endsection
