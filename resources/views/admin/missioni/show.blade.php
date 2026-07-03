@extends('admin.layouts.app')

@section('title', $missione->nome)
@section('page_title', $missione->nome)

@section('content')
    <div class="max-w-4xl">
        <a href="{{ route('admin.missioni.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150" style="color: #9CA3AF;" onmouseover="this.style.color='#22D3EE';" onmouseout="this.style.color='#9CA3AF';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-xl p-6 flex flex-col items-center text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                @if ($missione->logo)
                    <img src="{{ Storage::url('missioni/' . $missione->logo) }}" alt="{{ $missione->nome }}" class="w-24 h-24 rounded-xl object-cover mb-4" style="border: 2px solid rgba(34, 211, 238, 0.2);">
                @else
                    <div class="w-24 h-24 rounded-xl flex items-center justify-center text-3xl mb-4" style="background-color: rgba(34, 211, 238, 0.1); color: #22D3EE;">
                        <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                @endif
                <h2 class="text-xl font-bold mb-1" style="color: #F0F0FA;">{{ $missione->nome }}</h2>
                <p class="text-sm" style="color: #9CA3AF;">{{ $missione->agenzia ?? '—' }}</p>
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

            <div class="rounded-xl p-6 md:col-span-2" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <h3 class="text-sm font-medium mb-3 uppercase tracking-wider" style="color: #9CA3AF;">Descrizione</h3>
                <p style="color: #F0F0FA; line-height: 1.7;">{{ $missione->descrizione ?? 'Nessuna descrizione disponibile.' }}</p>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.missioni.edit', $missione) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                       style="background-color: rgba(249, 115, 22, 0.15); color: #F97316;"
                       onmouseover="this.style.backgroundColor='rgba(249,115,22,0.3)';"
                       onmouseout="this.style.backgroundColor='rgba(249,115,22,0.15)';">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.missioni.destroy', $missione) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $missione->nome }}?');">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                                style="background-color: rgba(239, 68, 68, 0.15); color: #EF4444;"
                                onmouseover="this.style.backgroundColor='rgba(239,68,68,0.3)';"
                                onmouseout="this.style.backgroundColor='rgba(239,68,68,0.15)';">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                            Elimina
                        </button>
                    </form>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Agenzia</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">{{ $missione->agenzia ?? '—' }}</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Data lancio</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">{{ $missione->data_lancio?->format('d/m/Y') ?? '—' }}</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Durata</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">{{ $missione->durata_giorni ? $missione->durata_giorni . ' giorni' : '—' }}</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Sito web</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">
                    @if ($missione->sito_web)
                        <a href="{{ $missione->sito_web }}" target="_blank" rel="noopener" class="transition-colors duration-150" style="color: #22D3EE;" onmouseover="this.style.color='#A855F7';" onmouseout="this.style.color='#22D3EE';">Visita →</a>
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

        @if ($missione->corpiCelesti->count() > 0)
            <div class="rounded-xl p-6" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <h3 class="text-lg font-semibold mb-4" style="color: #F0F0FA;">Corpi Celesti Esplorati ({{ $missione->corpiCelesti->count() }})</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.1);">
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Corpo Celeste</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Categoria</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Tipo esplorazione</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Anno arrivo</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($missione->corpiCelesti as $corpo)
                                <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.05);">
                                    <td class="py-3 px-4">
                                        <a href="{{ route('admin.corpi-celesti.show', $corpo) }}" class="transition-colors duration-150" style="color: #F0F0FA;" onmouseover="this.style.color='#22D3EE';" onmouseout="this.style.color='#F0F0FA';">{{ $corpo->nome }}</a>
                                    </td>
                                    <td class="py-3 px-4">
                                        @if ($corpo->categoria)
                                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $corpo->categoria->colore }}20; color: {{ $corpo->categoria->colore }};">{{ $corpo->categoria->nome }}</span>
                                        @else
                                            <span style="color: #6B7280;">—</span>
                                        @endif
                                    </td>
                                    <td class="py-3 px-4" style="color: #9CA3AF;">{{ $corpo->pivot->tipo_esplorazione ?? '—' }}</td>
                                    <td class="py-3 px-4" style="color: #9CA3AF;">{{ $corpo->pivot->anno_arrivo ?? '—' }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
