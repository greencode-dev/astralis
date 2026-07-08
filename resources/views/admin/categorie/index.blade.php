@extends('admin.layouts.app')

@section('title', 'Categorie')
@section('page_title', 'Categorie')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm" style="color: #9CA3AF;">Gestisci le categorie di corpi celesti</p>
        <a href="{{ route('admin.categorie.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[#1BB8D1]"
           style="background-color: #22D3EE; color: #0A0A1A;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Categoria
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

    <div class="rounded-xl overflow-hidden" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
        <table class="w-full text-sm">
            <thead>
                <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.1);">
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Icona</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Nome</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Colore</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Descrizione</th>
                    <th class="text-center py-3 px-4 font-medium" style="color: #9CA3AF;">Corpi</th>
                    <th class="text-right py-3 px-4 font-medium" style="color: #9CA3AF;">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($categorie as $categoria)
                    <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.05);" class="hover:bg-[rgba(34,211,238,0.03)]">
                        <td class="py-3 px-4 text-lg">{{ $categoria->icona ?? '📂' }}</td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.categorie.show', $categoria) }}" class="font-medium transition-colors duration-150 hover:text-[#22D3EE]" style="color: #F0F0FA;">
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
                                <span style="color: #6B7280;">—</span>
                            @endif
                        </td>
                        <td class="py-3 px-4" style="color: #9CA3AF; max-width: 300px;" class="truncate">{{ Str::limit($categoria->descrizione, 60) ?? '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            <span class="inline-flex items-center justify-center w-8 h-8 rounded-full text-xs font-bold"
                                  style="background-color: rgba(34, 211, 238, 0.15); color: #22D3EE;">
                                {{ $categoria->corpi_celesti_count }}
                            </span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.categorie.show', $categoria) }}"
                                   class="p-2 rounded-lg transition-all duration-200 hover:text-[#22D3EE] hover:bg-[rgba(34,211,238,0.1)]"
                                   style="color: #9CA3AF;"
                                   aria-label="Visualizza {{ $categoria->nome }}"
                                   title="Visualizza">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.categorie.edit', $categoria) }}"
                                   class="p-2 rounded-lg transition-all duration-200 hover:text-[#F97316] hover:bg-[rgba(249,115,22,0.1)]"
                                   style="color: #9CA3AF;"
                                   aria-label="Modifica {{ $categoria->nome }}"
                                   title="Modifica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.categorie.destroy', $categoria) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare questa categoria?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg transition-all duration-200 hover:text-[#EF4444] hover:bg-[rgba(239,68,68,0.1)]"
                                            style="color: #9CA3AF;"
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
                            <p class="text-lg mb-2" style="color: #6B7280;">Nessuna categoria trovata</p>
                            <a href="{{ route('admin.categorie.create') }}" class="text-sm font-medium transition-colors duration-150 hover:text-[#A855F7]" style="color: #22D3EE;">Crea la prima categoria</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
