@extends('admin.layouts.app')

@section('title', $categoria->nome)
@section('page_title', $categoria->nome)

@section('content')
    <div class="max-w-4xl">
        <a href="{{ route('admin.categorie.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 hover:text-[#22D3EE]" style="color: #9CA3AF;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-xl p-6 md:col-span-1 flex flex-col items-center text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <span class="text-6xl mb-4">{{ $categoria->icona ?? '📂' }}</span>
                <h2 class="text-xl font-bold mb-2" style="color: #F0F0FA;">{{ $categoria->nome }}</h2>
                @if ($categoria->colore)
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-medium"
                          style="background-color: {{ $categoria->colore }}20; color: {{ $categoria->colore }};">
                        <span class="w-2.5 h-2.5 rounded-full" style="background-color: {{ $categoria->colore }};"></span>
                        {{ $categoria->colore }}
                    </span>
                @endif
                <div class="mt-4 flex items-center gap-2 text-sm" style="color: #9CA3AF;">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                    <span>{{ $categoria->corpi_celesti_count }} corpi celesti</span>
                </div>
            </div>

            <div class="rounded-xl p-6 md:col-span-2" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <h3 class="text-sm font-medium mb-3 uppercase tracking-wider" style="color: #9CA3AF;">Descrizione</h3>
                <p style="color: #F0F0FA; line-height: 1.7;">{{ $categoria->descrizione ?? 'Nessuna descrizione disponibile.' }}</p>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.categorie.edit', $categoria) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[rgba(249,115,22,0.3)]"
                       style="background-color: rgba(249, 115, 22, 0.15); color: #F97316;">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.categorie.destroy', $categoria) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare questa categoria?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[rgba(239,68,68,0.3)]"
                                style="background-color: rgba(239, 68, 68, 0.15); color: #EF4444;">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Elimina
                        </button>
                    </form>
                </div>
            </div>
        </div>

        @if ($categoria->corpiCelesti->count() > 0)
            <div class="rounded-xl p-6" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <h3 class="text-lg font-semibold mb-4" style="color: #F0F0FA;">Corpi Celesti in "{{ $categoria->nome }}"</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.1);">
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Nome</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Tipo</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Distanza (km)</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($categoria->corpiCelesti as $corpo)
                                <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.05);">
                                    <td class="py-3 px-4" style="color: #F0F0FA;">{{ $corpo->nome }}</td>
                                    <td class="py-3 px-4" style="color: #9CA3AF;">{{ $corpo->tipo }}</td>
                                    <td class="py-3 px-4" style="color: #9CA3AF;">{{ $corpo->distanza_km ?? '-' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
