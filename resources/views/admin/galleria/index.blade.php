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

    <div class="mb-4">
        <form method="GET" action="{{ route('admin.galleria.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cerca per didascalia..."
                   class="admin-input flex-1">
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25">
                Cerca
            </button>
            @if (request('search'))
                <a href="{{ route('admin.galleria.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-gray-400 border border-gray-400/20 hover:text-red-500 hover:border-red-500/30">
                    Cancella filtro
                </a>
            @endif
        </form>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse ($galleria as $item)
            <div class="rounded-xl overflow-hidden transition-all duration-200 bg-admin-card border border-admin-primary/10 hover:border-admin-primary/30 hover:-translate-y-0.5">
                <div class="aspect-video relative overflow-hidden bg-admin-bg">
                    <img loading="lazy" src="{{ $item->percorso_url }}"
                         alt="{{ $item->didascalia ?? $item->corpoCeleste->nome }}"
                         class="w-full h-full object-cover transition-transform duration-300 hover:scale-105"
                         onerror="this.alt='Immagine non disponibile'; this.style.display='none'; this.parentElement.innerHTML='<div role=\"img\" aria-label=\"Immagine non disponibile per {{ $item->corpoCeleste->nome }}\" style=\"display:flex;align-items:center;justify-content:center;height:100%;padding:1rem;text-align:center;color:#6B7280;font-size:0.75rem;\">Immagine non disponibile</div>';">
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
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.galleria.edit', $item) }}"
                               class="p-1.5 rounded-lg transition-all duration-200 hover:text-admin-accent hover:bg-admin-accent/10 text-gray-400"
                               aria-label="Modifica {{ $item->didascalia ?? $item->corpoCeleste->nome }}"
                               title="Modifica">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.galleria.destroy', $item) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $item->didascalia ?? $item->corpoCeleste->nome }}?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 rounded-lg transition-all duration-200 hover:text-red-500 hover:bg-red-500/10 text-gray-400"
                                        aria-label="Elimina {{ $item->didascalia ?? $item->corpoCeleste->nome }}"
                                        title="Elimina">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
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
