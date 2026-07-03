@extends('admin.layouts.app')

@section('title', 'Missioni')
@section('page_title', 'Missioni')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm" style="color: #9CA3AF;">Gestisci le missioni spaziali</p>
        <a href="{{ route('admin.missioni.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200"
           style="background-color: #22D3EE; color: #0A0A1A;"
           onmouseover="this.style.backgroundColor='#1BB8D1';"
           onmouseout="this.style.backgroundColor='#22D3EE';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Missione
        </a>
    </div>

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg text-sm" style="background-color: rgba(34, 197, 94, 0.15); color: #22C55E; border: 1px solid rgba(34, 197, 94, 0.2);">{{ session('success') }}</div>
    @endif
    @if (session('error'))
        <div class="mb-6 p-4 rounded-lg text-sm" style="background-color: rgba(239, 68, 68, 0.15); color: #EF4444; border: 1px solid rgba(239, 68, 68, 0.2);">{{ session('error') }}</div>
    @endif

    <div class="rounded-xl overflow-hidden" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
        <table class="w-full text-sm">
            <thead>
                <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.1);">
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Logo</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Nome</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Agenzia</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Lancio</th>
                    <th class="text-center py-3 px-4 font-medium" style="color: #9CA3AF;">Stato</th>
                    <th class="text-right py-3 px-4 font-medium" style="color: #9CA3AF;">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($missioni as $missione)
                    <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.05);" class="transition-colors duration-150" onmouseover="this.style.backgroundColor='rgba(34,211,238,0.03)';" onmouseout="this.style.backgroundColor='transparent';">
                        <td class="py-3 px-4">
                            @if ($missione->logo)
                                <img src="{{ Storage::url('missioni/' . $missione->logo) }}" alt="{{ $missione->nome }}" class="w-8 h-8 rounded-lg object-cover" style="border: 1px solid rgba(34, 211, 238, 0.2);">
                            @else
                                <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm" style="background-color: rgba(34, 211, 238, 0.1); color: #22D3EE;">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                </div>
                            @endif
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.missioni.show', $missione) }}" class="font-medium transition-colors duration-150" style="color: #F0F0FA;" onmouseover="this.style.color='#22D3EE';" onmouseout="this.style.color='#F0F0FA';">{{ $missione->nome }}</a>
                        </td>
                        <td class="py-3 px-4" style="color: #9CA3AF;">{{ $missione->agenzia ?? '—' }}</td>
                        <td class="py-3 px-4" style="color: #9CA3AF;">{{ $missione->data_lancio ? $missione->data_lancio->format('d/m/Y') : '—' }}</td>
                        <td class="py-3 px-4 text-center">
                            @php
                                $stato = $missione->stato ?? 'completata';
                                $colors = [
                                    'completata' => ['bg' => 'rgba(34,197,94,0.15)', 'text' => '#22C55E'],
                                    'in corso' => ['bg' => 'rgba(34,211,238,0.15)', 'text' => '#22D3EE'],
                                    'pianificata' => ['bg' => 'rgba(250,204,21,0.15)', 'text' => '#FACC15'],
                                ];
                                $c = $colors[$stato] ?? ['bg' => 'rgba(107,114,128,0.15)', 'text' => '#6B7280'];
                            @endphp
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium" style="background-color: {{ $c['bg'] }}; color: {{ $c['text'] }};">{{ ucfirst($stato) }}</span>
                        </td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.missioni.show', $missione) }}" class="p-2 rounded-lg transition-all duration-200" style="color: #9CA3AF;" onmouseover="this.style.color='#22D3EE'; this.style.backgroundColor='rgba(34,211,238,0.1)';" onmouseout="this.style.color='#9CA3AF'; this.style.backgroundColor='transparent';" title="Visualizza">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                </a>
                                <a href="{{ route('admin.missioni.edit', $missione) }}" class="p-2 rounded-lg transition-all duration-200" style="color: #9CA3AF;" onmouseover="this.style.color='#F97316'; this.style.backgroundColor='rgba(249,115,22,0.1)';" onmouseout="this.style.color='#9CA3AF'; this.style.backgroundColor='transparent';" title="Modifica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.missioni.destroy', $missione) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $missione->nome }}?');">
                                    @csrf @method('DELETE')
                                    <button type="submit" class="p-2 rounded-lg transition-all duration-200" style="color: #9CA3AF;" onmouseover="this.style.color='#EF4444'; this.style.backgroundColor='rgba(239,68,68,0.1)';" onmouseout="this.style.color='#9CA3AF'; this.style.backgroundColor='transparent';" title="Elimina">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="py-12 text-center">
                            <p class="text-lg mb-2" style="color: #6B7280;">Nessuna missione trovata</p>
                            <a href="{{ route('admin.missioni.create') }}" class="text-sm font-medium transition-colors duration-150" style="color: #22D3EE;" onmouseover="this.style.color='#A855F7';" onmouseout="this.style.color='#22D3EE';">Crea la prima missione</a>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
@endsection
