@extends('admin.layouts.app')

@section('title', 'Categorie')
@section('page_title', 'Categorie')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-gray-400">Gestisci le categorie di corpi celesti</p>
        <a href="{{ route('admin.categorie.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:brightness-90">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Categoria
        </a>
    </div>

    @include('admin.partials.flash')

    <div class="mb-4">
        <form method="GET" action="{{ route('admin.categorie.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cerca per nome..."
                   class="flex-1 admin-input">
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25">
                Cerca
            </button>
            @if (request('search'))
                <a href="{{ route('admin.categorie.index') }}"
                   class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-gray-400 border border-gray-400/20 hover:text-red-500 hover:border-red-500/30">
                    Cancella filtro
                </a>
            @endif
        </form>
    </div>

    <div class="rounded-xl overflow-x-auto bg-admin-card border border-admin-primary/10">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-admin-primary/10">
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Icona</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Nome</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Colore</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Descrizione</th>
                    <th class="text-center py-3 px-4 font-medium text-gray-400">Corpi</th>
                    <th class="text-right py-3 px-4 font-medium text-gray-400">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorie as $categoria)
                    <tr class="border-b border-admin-primary/5 hover:bg-admin-primary/3">
                        <td class="py-3 px-4 text-lg">{{ $categoria->icona ?? '📂' }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.categorie.show', $categoria) }}" class="font-medium transition-colors duration-150 text-admin-text hover:text-admin-primary">
                                {{ $categoria->nome }}
                            </a>
                        </td>
                        <td class="py-3 px-4">
                            @if ($categoria->colore)
                                <span class="inline-flex items-center gap-2 px-3 py-1 rounded-full text-xs font-medium"
                                      style="background-color: {{ $categoria->colore }}20; color: {{ $categoria->colore }};">
                                    <span class="w-2 h-2 rounded-full" style="background-color: {{ $categoria->colore }};"></span>
                                    {{ $categoria->colore }}
                                </span>
                            @else
                                <span class="text-gray-500">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4 text-gray-400 max-w-[300px]">{{ Str::limit($categoria->descrizione, 60) ?? '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold bg-admin-primary/15 text-admin-primary">
                                {{ $categoria->corpi_celesti_count }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categorie.show', $categoria) }}"
                                   class="p-2 rounded-lg transition-all duration-200 text-gray-400 hover:text-admin-primary hover:bg-admin-primary/10"
                                   aria-label="Visualizza {{ $categoria->nome }}"
                                   title="Visualizza">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.categorie.edit', $categoria) }}"
                                   class="p-2 rounded-lg transition-all duration-200 text-gray-400 hover:text-admin-accent hover:bg-admin-accent/10"
                                   aria-label="Modifica {{ $categoria->nome }}"
                                   title="Modifica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.categorie.destroy', $categoria) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $categoria->nome }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg transition-all duration-200 text-gray-400 hover:text-red-500 hover:bg-red-500/10"
                                            aria-label="Elimina {{ $categoria->nome }}"
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
                            <p class="text-lg mb-2 text-gray-500">Nessuna categoria trovata</p>
                            <a href="{{ route('admin.categorie.create') }}" class="text-sm font-medium transition-colors duration-150 text-admin-primary hover:text-admin-secondary">Crea la prima categoria</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $categorie->links() }}
    </div>
@endsection
