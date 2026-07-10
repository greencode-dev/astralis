@extends('admin.layouts.app')

@section('title', 'Curiosità')
@section('page_title', 'Curiosità')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm text-gray-400">Gestisci le curiosità sui corpi celesti</p>
        <a href="{{ route('admin.curiosita.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:brightness-90">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Curiosità
        </a>
    </div>

    @include('admin.partials.flash')

    <div class="mb-4">
        <form method="GET" action="{{ route('admin.curiosita.index') }}" class="flex gap-2">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Cerca per titolo..."
                   class="flex-1 admin-input">
            <button type="submit"
                    class="px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25">
                Cerca
            </button>
            @if (request('search'))
                <a href="{{ route('admin.curiosita.index') }}"
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
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Titolo</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Corpo Celeste</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Descrizione</th>
                    <th class="text-left py-3 px-4 font-medium text-gray-400">Fonte</th>
                    <th class="text-right py-3 px-4 font-medium text-gray-400">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($curiosita as $curiositum)
                    <tr class="border-b border-admin-primary/5 hover:bg-admin-primary/3">
                        <td class="py-3 px-4 font-medium text-admin-text">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0 text-admin-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $curiositum->titolo }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.corpi-celesti.show', $curiositum->corpoCeleste) }}"
                               class="transition-colors duration-150 text-admin-primary hover:text-admin-secondary">
                                {{ $curiositum->corpoCeleste->nome }}
                            </a>
                        </td>
                        <td class="py-3 px-4 text-gray-400 max-w-[300px]">{{ Str::limit($curiositum->descrizione, 80) }}</td>
                        <td class="py-3 px-4 text-gray-500 max-w-[150px]">{{ $curiositum->fonte ? Str::limit($curiositum->fonte, 40) : '—' }}</td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.curiosita.edit', $curiositum) }}"
                                   class="p-2 rounded-lg transition-all duration-200 text-gray-400 hover:text-admin-accent hover:bg-admin-accent/10"
                                   aria-label="Modifica {{ $curiositum->titolo }}"
                                   title="Modifica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.curiosita.destroy', $curiositum) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $curiositum->titolo }}?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg transition-all duration-200 text-gray-400 hover:text-red-500 hover:bg-red-500/10"
                                            aria-label="Elimina {{ $curiositum->titolo }}"
                                            title="Elimina">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="5" class="py-12 text-center">
                            <p class="text-lg mb-2 text-gray-500">Nessuna curiosità trovata</p>
                            <a href="{{ route('admin.curiosita.create') }}" class="text-sm font-medium transition-colors duration-150 text-admin-primary hover:text-admin-secondary">Crea la prima curiosità</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="mt-4">
        {{ $curiosita->links() }}
    </div>
@endsection
