@extends('admin.layouts.app')

@section('title', $missione->nome)
@section('page_title', $missione->nome)

@section('content')
    <div class="max-w-4xl">
        <a href="{{ route('admin.missioni.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 text-gray-400 hover:text-admin-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-xl p-6 flex flex-col items-center text-center bg-admin-card border border-admin-primary/10">
                @if ($missione->logo)
                    <img loading="lazy" src="{{ Storage::url('missioni/' . $missione->logo) }}" alt="{{ $missione->nome }}" class="w-24 h-24 rounded-xl object-cover mb-4 border-2 border-admin-primary/20">
                @else
                    <div class="w-24 h-24 rounded-xl flex items-center justify-center text-3xl mb-4 bg-admin-primary/10 text-admin-primary" role="img" aria-label="{{ $missione->nome }}">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                @endif
                <h2 class="text-xl font-bold mb-1 text-admin-text">{{ $missione->nome }}</h2>
                <p class="text-sm text-gray-400">{{ $missione->agenzia ?? '—' }}</p>
                @php
                    $stato = $missione->stato ?? 'completata';
                    $colors = [
                        'completata' => ['bg' => 'rgba(34,197,94,0.15)', 'text' => '#22C55E'],
                        'in corso' => ['bg' => 'rgba(34,211,238,0.15)', 'text' => '#22D3EE'],
                        'pianificata' => ['bg' => 'rgba(250,204,21,0.15)', 'text' => '#FACC15'],
                    ];
                    $c = $colors[$stato] ?? ['bg' => 'rgba(107,114,128,0.15)', 'text' => '#6B7280'];
                @endphp
                <span class="inline-flex items-center gap-1.5 mt-3 px-3 py-1 rounded-full text-xs font-medium" style="background-color: {{ $c['bg'] }}; color: {{ $c['text'] }};">
                    <span class="w-1.5 h-1.5 rounded-full" style="background-color: {{ $c['text'] }};"></span>
                    {{ ucfirst($stato) }}
                </span>
            </div>

            <div class="rounded-xl p-6 md:col-span-2 bg-admin-card border border-admin-primary/10">
                <h3 class="text-sm font-medium mb-3 uppercase tracking-wider text-gray-400">Descrizione</h3>
                <p class="text-admin-text leading-[1.7]">{{ $missione->descrizione ?? 'Nessuna descrizione disponibile.' }}</p>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.missioni.edit', $missione) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-accent/15 text-admin-accent hover:bg-admin-accent/30">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.missioni.destroy', $missione) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $missione->nome }}?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-red-500/15 text-red-500 hover:bg-red-500/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Elimina
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Agenzia</p>
                <p class="text-sm font-medium text-admin-text">{{ $missione->agenzia ?? '—' }}</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Data lancio</p>
                <p class="text-sm font-medium text-admin-text">{{ $missione->data_lancio?->format('d/m/Y') ?? '—' }}</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Durata</p>
                <p class="text-sm font-medium text-admin-text">{{ $missione->durata_giorni ? $missione->durata_giorni . ' giorni' : '—' }}</p>
            </div>
            <div class="rounded-xl p-4 text-center bg-admin-card border border-admin-primary/10">
                <p class="text-xs uppercase tracking-wider mb-1 text-gray-400">Sito web</p>
                <p class="text-sm font-medium text-admin-text">
                    @if ($missione->sito_web)
                        <a href="{{ $missione->sito_web }}" target="_blank" rel="noopener" class="transition-colors duration-150 text-admin-primary hover:text-admin-secondary">Visita →</a>
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

        @if ($missione->corpiCelesti->count() > 0)
            <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
                <h3 class="text-lg font-semibold mb-4 text-admin-text">Corpi Celesti Esplorati ({{ $missione->corpiCelesti->count() }})</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-admin-primary/10">
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Corpo Celeste</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Categoria</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Tipo esplorazione</th>
                                <th class="text-left py-3 px-4 font-medium text-gray-400">Anno arrivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($missione->corpiCelesti as $corpo)
                                <tr class="border-b border-admin-primary/5">
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="transition-colors duration-150 text-admin-text hover:text-admin-primary">{{ $corpo->nome }}</a>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($corpo->categoria)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $corpo->categoria->colore }}20; color: {{ $corpo->categoria->colore }};">{{ $corpo->categoria->nome }}</span>
                                        @else
                                            <span class="text-gray-500">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4 text-gray-400">{{ $corpo->pivot->tipo_esplorazione ?? '—' }}</td>
                                    <td class="py-3 px-4 text-gray-400">{{ $corpo->pivot->anno_arrivo ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
