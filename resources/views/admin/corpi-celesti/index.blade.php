@extends('admin.layouts.app')

@section('title', 'Corpi Celesti')
@section('page_title', 'Corpi Celesti')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm" style="color: #9CA3AF;">Gestisci i corpi celesti del catalogo</p>
        <a href="{{ route('admin.corpi-celesti.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[#1BB8D1]"
           style="background-color: #22D3EE; color: #0A0A1A;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuovo Corpo Celeste
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

    <div class="mb-4">
        <form method="GET" action="{{ route('admin.corpi-celesti.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cerca per nome..."
                   class="flex-1 px-4 py-2 rounded-lg text-sm transition-all duration-200"
                   style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                   onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                   onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[rgba(34,211,238,0.25)]"
                    style="background-color: rgba(34, 211, 238, 0.15); color: #22D3EE; border: 1px solid rgba(34, 211, 238, 0.2);">
                Cerca
            </button>
            @if (request('search'))
                <a href="{{ route('admin.corpi-celesti.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:text-[#EF4444] hover:border-[rgba(239,68,68,0.3)]"
                   style="color: #9CA3AF; border: 1px solid rgba(156, 163, 175, 0.2);">
                    Cancella filtro
                </a>
            @endif
        </form>
    </div>

    <div class="rounded-xl overflow-hidden" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
        <table class="w-full text-sm">
            <thead>
                <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.1);">
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Nome</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Categoria</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Tipo</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Distanza (km)</th>
                    <th class="text-center py-3 px-4 font-medium" style="color: #9CA3AF;">Evidenza</th>
                    <th class="text-right py-3 px-4 font-medium" style="color: #9CA3AF;">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($corpi as $corpo)
                    <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.05);" class="hover:bg-[rgba(34,211,238,0.03)]">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                @if ($corpo->immagine)
                                    <img loading="lazy" src="{{ $corpo->immagine_url }}"
                                         alt="{{ $corpo->nome_display }}"
                                         class="w-8 h-8 rounded-full object-cover"
                                         style="border: 1px solid rgba(34, 211, 238, 0.2);">
                                @else
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm" style="background-color: rgba(34, 211, 238, 0.1); color: #22D3EE;" role="img" aria-label="{{ $corpo->nome_display }}">
                                        ★
                                    </div>
                                @endif
                                <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="font-medium transition-colors duration-150 hover:text-[#22D3EE]" style="color: #F0F0FA;">
                                    {{ $corpo->nome_display }}
                                </a>
                            </div>
                        </td>
                        <td class="py-3 px-4">
                            @if ($corpo->categoria)
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                      style="background-color: {{ $corpo->categoria->colore }}20; color: {{ $corpo->categoria->colore }};">
                                    {{ $corpo->categoria->nome }}
                                </span>
                            @else
                                <span style="color: #6B7280;">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4" style="color: #9CA3AF;">{{ $corpo->tipo ?? '—' }}</td>
                        <td class="py-3 px-4" style="color: #9CA3AF; font-family: monospace; font-size: 0.8rem;">{{ $corpo->distanza_km ?? '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            @if ($corpo->in_evidenza)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium" style="background-color: rgba(250, 204, 21, 0.15); color: #FACC15;">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    In evidenza
                                </span>
                            @else
                                <span style="color: #6B7280;">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.corpi-celesti.show', $corpo) }}"
                                   class="p-2 rounded-lg transition-all duration-200 hover:text-[#22D3EE] hover:bg-[rgba(34,211,238,0.1)]"
                                   style="color: #9CA3AF;"
                                    aria-label="Visualizza {{ $corpo->nome_display }}"
                                    title="Visualizza">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.corpi-celesti.edit', $corpo) }}"
                                   class="p-2 rounded-lg transition-all duration-200 hover:text-[#F97316] hover:bg-[rgba(249,115,22,0.1)]"
                                   style="color: #9CA3AF;"
                                   aria-label="Modifica {{ $corpo->nome_display }}"
                                   title="Modifica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.corpi-celesti.destroy', $corpo) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $corpo->nome_display }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg transition-all duration-200 hover:text-[#EF4444] hover:bg-[rgba(239,68,68,0.1)]"
                                            style="color: #9CA3AF;"
                                            aria-label="Elimina {{ $corpo->nome_display }}"
                                            title="Elimina">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <p class="text-lg mb-2" style="color: #6B7280;">Nessun corpo celeste trovato</p>
                            <a href="{{ route('admin.corpi-celesti.create') }}" class="text-sm font-medium transition-colors duration-150 hover:text-[#A855F7]" style="color: #22D3EE;">Crea il primo corpo celeste</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $corpi->links() }}
    </div>
@endsection
