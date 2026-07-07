@extends('admin.layouts.app')

@section('title', 'Galleria')
@section('page_title', 'Galleria')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm" style="color: #9CA3AF;">Gestisci le immagini della galleria dei corpi celesti</p>
        <a href="{{ route('admin.galleria.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
           style="background-color: #22D3EE; color: #0A0A1A;"
           onmouseover="this.style.backgroundColor='#1BB8D1';"
           onmouseout="this.style.backgroundColor='#22D3EE';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Immagine
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg text-sm" style="background-color: rgba(34, 197, 94, 0.15); color: #22C55E; border: 1px solid rgba(34, 197, 94, 0.2);">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-lg text-sm" style="background-color: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.2);">
            {{ session('error') }}
        </div>
    @endif

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse ($galleria as $item)
            <div class="rounded-xl overflow-hidden transition-all duration-200"
                 style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);"
                 onmouseover="this.style.borderColor='rgba(34,211,238,0.3)'; this.style.transform='translateY(-2px)';"
                 onmouseout="this.style.borderColor='rgba(34,211,238,0.1)'; this.style.transform='translateY(0)';">
                <div class="aspect-video relative overflow-hidden" style="background-color: #0A0A1A;">
                    <img loading="lazy" src="{{ $item->percorso_url }}"
                         alt="{{ $item->didascalia ?? $item->corpoCeleste->nome }}"
                         class="w-full h-full object-cover transition-transform duration-300"
                         onmouseover="this.style.transform='scale(1.05)';"
                         onmouseout="this.style.transform='scale(1)';"
                         onerror="this.style.display='none'; this.parentElement.innerHTML='<div style=\"display:flex;align-items:center;justify-content:center;height:100%;padding:1rem;text-align:center;color:#6B7280;font-size:0.75rem;\">Immagine non disponibile</div>';">
                </div>
                <div class="p-3">
                    <p class="text-sm font-medium truncate" style="color: #F0F0FA;">{{ $item->didascalia ?? 'Senza didascalia' }}</p>
                    <p class="text-xs mt-1" style="color: #22D3EE;">
                        <a href="{{ route('admin.corpi-celesti.show', $item->corpoCeleste) }}"
                           class="transition-colors duration-150"
                           onmouseover="this.style.color='#A855F7';"
                           onmouseout="this.style.color='#22D3EE';">
                            {{ $item->corpoCeleste->nome }}
                        </a>
                    </p>
                    <div class="flex items-center justify-between mt-2">
                        <div class="flex items-center gap-1">
                            <form method="POST" action="{{ route('admin.galleria.ordine', $item) }}" class="inline">
                                @csrf
                                <input type="hidden" name="direzione" value="su">
                                <button type="submit"
                                        class="p-1 rounded-lg transition-all duration-200"
                                        style="color: #6B7280;"
                                        onmouseover="this.style.color='#22D3EE'; this.style.backgroundColor='rgba(34,211,238,0.1)';"
                                        onmouseout="this.style.color='#6B7280'; this.style.backgroundColor='transparent';"
                                        title="Sposta su">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 15l7-7 7 7"/></svg>
                                </button>
                            </form>
                            <span class="text-xs font-mono" style="color: #6B7280; min-width: 1.5rem; text-align: center;">{{ $item->ordine }}</span>
                            <form method="POST" action="{{ route('admin.galleria.ordine', $item) }}" class="inline">
                                @csrf
                                <input type="hidden" name="direzione" value="giu">
                                <button type="submit"
                                        class="p-1 rounded-lg transition-all duration-200"
                                        style="color: #6B7280;"
                                        onmouseover="this.style.color='#22D3EE'; this.style.backgroundColor='rgba(34,211,238,0.1)';"
                                        onmouseout="this.style.color='#6B7280'; this.style.backgroundColor='transparent';"
                                        title="Sposta giù">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/></svg>
                                </button>
                            </form>
                        </div>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.galleria.edit', $item) }}"
                               class="p-1.5 rounded-lg transition-all duration-200"
                               style="color: #9CA3AF;"
                               onmouseover="this.style.color='#F97316'; this.style.backgroundColor='rgba(249,115,22,0.1)';"
                               onmouseout="this.style.color='#9CA3AF'; this.style.backgroundColor='transparent';"
                               title="Modifica">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.galleria.destroy', $item) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare questa immagine?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit"
                                        class="p-1.5 rounded-lg transition-all duration-200"
                                        style="color: #9CA3AF;"
                                        onmouseover="this.style.color='#EF4444'; this.style.backgroundColor='rgba(239,68,68,0.1)';"
                                        onmouseout="this.style.color='#9CA3AF'; this.style.backgroundColor='transparent';"
                                        title="Elimina">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                    @if ($item->crediti)
                        <p class="text-xs mt-1" style="color: #6B7280;">📷 {{ $item->crediti }}</p>
                    @endif
                </div>
            </div>
        @empty
            <div class="col-span-full text-center py-16">
                <p class="text-lg mb-2" style="color: #6B7280;">Nessuna immagine nella galleria</p>
                <a href="{{ route('admin.galleria.create') }}" class="text-sm font-medium transition-colors duration-150" style="color: #22D3EE;" onmouseover="this.style.color='#A855F7';" onmouseout="this.style.color='#22D3EE';">Aggiungi la prima immagine</a>
            </div>
        @endforelse
    </div>

    <div class="mt-4">
        {{ $galleria->links() }}
    </div>
@endsection
