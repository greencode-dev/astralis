@extends('admin.layouts.app')

@section('title', 'Corpi Celesti')
@section('page_title', 'Corpi Celesti')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-gray-400">Gestisci i corpi celesti del catalogo</p>
        <a href="{{ route('admin.corpi-celesti.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:bg-[#1BB8D1]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuovo Corpo Celeste
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg text-sm bg-green-500/15 text-green-500 border border-green-500/20">
            {{ session('success') }}
        </div>
    @endif

    @if (session('error'))
        <div class="mb-6 p-4 rounded-lg text-sm bg-red-500/15 text-red-500 border border-red-500/20">
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
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25">
                Cerca
            </button>
            @if (request('search'))
                <a href="{{ route('admin.corpi-celesti.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-gray-400 border border-gray-400/20 hover:text-red-500 hover:border-red-500/30">
                    Cancella filtro
                </a>
            @endif
        </form>
    </div>

    <div class="rounded-xl overflow-hidden bg-admin-card border border-admin-primary/10">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-admin-primary/10">
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Nome</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Categoria</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Tipo</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Distanza (km)</th>
                    <th class="text-center py-3 px-4 font-medium text-gray-400">Evidenza</th>
                    <th class="text-right py-3 px-4 font-medium text-gray-400">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($corpi as $corpo)
                    <tr class="border-b border-admin-primary/5 hover:bg-admin-primary/3">
                        <td class="py-3 px-4">
                            <div class="flex items-center gap-3">
                                @if ($corpo->immagine)
                                    <img loading="lazy" src="{{ $corpo->immagine_url }}"
                                         alt="{{ $corpo->nome_display }}"
                                          class="w-8 h-8 rounded-full object-cover border border-admin-primary/20">
                                @else
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center text-sm bg-admin-primary/10 text-admin-primary" role="img" aria-label="{{ $corpo->nome_display }}">
                                        ★
                                    </div>
                                @endif
                                <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="font-medium transition-colors duration-150 text-admin-text hover:text-admin-primary">
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
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-gray-400">{{ $corpo->tipo ?? '—' }}</td>
                        <td class="py-3 px-4 text-gray-400 font-mono text-[0.8rem]">{{ $corpo->distanza_km ?? '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            @if ($corpo->in_evidenza)
                                <span class="inline-flex items-center gap-1 px-2 py-0.5 rounded-full text-xs font-medium bg-yellow-400/15 text-yellow-400">
                                    <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                                    In evidenza
                                </span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.corpi-celesti.show', $corpo) }}"
                                   class="p-2 rounded-lg transition-all duration-200 text-gray-400 hover:text-admin-primary hover:bg-admin-primary/10"
                                    aria-label="Visualizza {{ $corpo->nome_display }}"
                                    title="Visualizza">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.corpi-celesti.edit', $corpo) }}"
                                   class="p-2 rounded-lg transition-all duration-200 text-gray-400 hover:text-admin-accent hover:bg-admin-accent/10"
                                   aria-label="Modifica {{ $corpo->nome_display }}"
                                   title="Modifica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.corpi-celesti.destroy', $corpo) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $corpo->nome_display }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg transition-all duration-200 text-gray-400 hover:text-red-500 hover:bg-red-500/10"
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
                            <p class="text-lg mb-2 text-gray-500">Nessun corpo celeste trovato</p>
                            <a href="{{ route('admin.corpi-celesti.create') }}" class="text-sm font-medium transition-colors duration-150 text-admin-primary hover:text-admin-secondary">Crea il primo corpo celeste</a>
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
