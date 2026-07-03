@extends('admin.layouts.app')

@section('title', $corpoCeleste->nome)
@section('page_title', $corpoCeleste->nome)

@section('content')
    <div class="max-w-5xl">
        <a href="{{ route('admin.corpi-celesti.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150" style="color: #9CA3AF;" onmouseover="this.style.color='#22D3EE';" onmouseout="this.style.color='#9CA3AF';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
            <div class="rounded-xl p-6 flex flex-col items-center text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                @if ($corpoCeleste->immagine)
                    <img src="{{ Storage::url('corpi-celesti/' . $corpoCeleste->immagine) }}"
                         alt="{{ $corpoCeleste->nome }}"
                         class="w-32 h-32 rounded-full object-cover mb-4"
                         style="border: 3px solid rgba(34, 211, 238, 0.2);">
                @else
                    <div class="w-32 h-32 rounded-full flex items-center justify-center text-4xl mb-4" style="background-color: rgba(34, 211, 238, 0.1); color: #22D3EE;">
                        ★
                    </div>
                @endif
                <h2 class="text-xl font-bold mb-2" style="color: #F0F0FA;">{{ $corpoCeleste->nome }}</h2>
                @if ($corpoCeleste->categoria)
                    <span class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full text-sm font-medium"
                          style="background-color: {{ $corpoCeleste->categoria->colore }}20; color: {{ $corpoCeleste->categoria->colore }};">
                        {{ $corpoCeleste->categoria->icona ?? '' }} {{ $corpoCeleste->categoria->nome }}
                    </span>
                @endif
                @if ($corpoCeleste->in_evidenza)
                    <span class="inline-flex items-center gap-1 mt-3 px-3 py-1 rounded-full text-xs font-medium" style="background-color: rgba(250, 204, 21, 0.15); color: #FACC15;">
                        <svg class="w-3.5 h-3.5" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        In evidenza
                    </span>
                @endif
            </div>

            <div class="rounded-xl p-6 md:col-span-2" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <h3 class="text-sm font-medium mb-3 uppercase tracking-wider" style="color: #9CA3AF;">Descrizione</h3>
                <p style="color: #F0F0FA; line-height: 1.7;">{{ $corpoCeleste->descrizione ?? 'Nessuna descrizione disponibile.' }}</p>

                <div class="mt-6 flex gap-3">
                    <a href="{{ route('admin.corpi-celesti.edit', $corpoCeleste) }}"
                       class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
                       style="background-color: rgba(249, 115, 22, 0.15); color: #F97316;"
                       onmouseover="this.style.backgroundColor='rgba(249,115,22,0.3)';"
                       onmouseout="this.style.backgroundColor='rgba(249,115,22,0.15)';">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                        Modifica
                    </a>
                    <form method="POST" action="{{ route('admin.corpi-celesti.destroy', $corpoCeleste) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $corpoCeleste->nome }}?');">
                        @csrf
                        @method('DELETE')
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
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Tipo</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">{{ $corpoCeleste->tipo ?? '—' }}</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Massa</p>
                <p class="text-sm font-medium" style="color: #F0F0FA; font-family: monospace;">{{ $corpoCeleste->massa_kg ?? '—' }} kg</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Distanza</p>
                <p class="text-sm font-medium" style="color: #F0F0FA; font-family: monospace;">{{ $corpoCeleste->distanza_km ?? '—' }} km</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Diametro</p>
                <p class="text-sm font-medium" style="color: #F0F0FA; font-family: monospace;">{{ $corpoCeleste->diametro_km ?? '—' }} km</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Gravità</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">{{ $corpoCeleste->gravita ?? '—' }} m/s²</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Temperatura</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">{{ $corpoCeleste->temperatura ?? '—' }} °C</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Periodo orbitale</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">{{ $corpoCeleste->periodo_orbitale ?? '—' }} giorni</p>
            </div>
            <div class="rounded-xl p-4 text-center" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <p class="text-xs uppercase tracking-wider mb-1" style="color: #9CA3AF;">Scoperta</p>
                <p class="text-sm font-medium" style="color: #F0F0FA;">
                    @if ($corpoCeleste->scopritore || $corpoCeleste->anno_scoperta)
                        {{ $corpoCeleste->scopritore ?? '—' }}{{ $corpoCeleste->scopritore && $corpoCeleste->anno_scoperta ? ', ' : '' }}{{ $corpoCeleste->anno_scoperta ?? '' }}
                    @else
                        —
                    @endif
                </p>
            </div>
        </div>

        @if ($corpoCeleste->galleria->count() > 0)
            <div class="rounded-xl p-6 mb-8" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <h3 class="text-lg font-semibold mb-4" style="color: #F0F0FA;">Galleria ({{ $corpoCeleste->galleria->count() }})</h3>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach ($corpoCeleste->galleria as $foto)
                        <div class="rounded-lg overflow-hidden" style="border: 1px solid rgba(34, 211, 238, 0.1);">
                            <div class="aspect-square" style="background-color: #0A0A1A;">
                                <img src="{{ Storage::url($foto->percorso) }}" alt="{{ $foto->didascalia ?? '' }}" class="w-full h-full object-cover">
                            </div>
                            @if ($foto->didascalia)
                                <div class="p-2">
                                    <p class="text-xs" style="color: #9CA3AF;">{{ $foto->didascalia }}</p>
                                </div>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($corpoCeleste->curiosita->count() > 0)
            <div class="rounded-xl p-6 mb-8" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <h3 class="text-lg font-semibold mb-4" style="color: #F0F0FA;">Curiosità ({{ $corpoCeleste->curiosita->count() }})</h3>
                <div class="space-y-4">
                    @foreach ($corpoCeleste->curiosita as $curiosita)
                        <div class="p-4 rounded-lg" style="background-color: #0A0A1A; border: 1px solid rgba(168, 85, 247, 0.15);">
                            <h4 class="text-sm font-medium mb-1" style="color: #A855F7;">{{ $curiosita->titolo }}</h4>
                            <p class="text-sm" style="color: #B8B8D0;">{{ $curiosita->descrizione }}</p>
                            @if ($curiosita->fonte)
                                <p class="text-xs mt-1" style="color: #6B7280;">Fonte: {{ $curiosita->fonte }}</p>
                            @endif
                        </div>
                    @endforeach
                </div>
            </div>
        @endif

        @if ($corpoCeleste->missioni->count() > 0)
            <div class="rounded-xl p-6" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                <h3 class="text-lg font-semibold mb-4" style="color: #F0F0FA;">Missioni ({{ $corpoCeleste->missioni->count() }})</h3>
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.1);">
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Missione</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Agenzia</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Tipo esplorazione</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Anno arrivo</th>
                                <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Stato</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($corpoCeleste->missioni as $missione)
                                <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.05);">
                                    <td class="py-3 px-4" style="color: #F0F0FA;">{{ $missione->nome }}</td>
                                    <td class="py-3 px-4" style="color: #9CA3AF;">{{ $missione->agenzia }}</td>
                                    <td class="py-3 px-4" style="color: #9CA3AF;">{{ $missione->pivot->tipo_esplorazione ?? '—' }}</td>
                                    <td class="py-3 px-4" style="color: #9CA3AF;">{{ $missione->pivot->anno_arrivo ?? '—' }}</td>
                                    <td class="py-3 px-4">
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium"
                                              style="background-color: {{ $missione->stato === 'Completata' ? 'rgba(34,197,94,0.15)' : ($missione->stato === 'In corso' ? 'rgba(34,211,238,0.15)' : 'rgba(250,204,21,0.15)') }}; color: {{ $missione->stato === 'Completata' ? '#22C55E' : ($missione->stato === 'In corso' ? '#22D3EE' : '#FACC15') }};">
                                            {{ $missione->stato }}
                                        </span>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        @endif
    </div>
@endsection
