@extends('admin.layouts.app')

@section('title', 'Curiosità')
@section('page_title', 'Curiosità')

@section('content')
    <div class="flex justify-between items-center mb-6">
        <p class="text-sm" style="color: #9CA3AF;">Gestisci le curiosità sui corpi celesti</p>
        <a href="{{ route('admin.curiosita.create') }}"
           class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[#1BB8D1]"
           style="background-color: #22D3EE; color: #0A0A1A;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Nuova Curiosità
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
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Titolo</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Corpo Celeste</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Descrizione</th>
                    <th class="text-left py-3 px-4 font-medium" style="color: #9CA3AF;">Fonte</th>
                    <th class="text-right py-3 px-4 font-medium" style="color: #9CA3AF;">Azioni</th>
                </tr>
            </thead>
            <tbody>
                @forelse ($curiosita as $curiositum)
                    <tr style="border-bottom: 1px solid rgba(34, 211, 238, 0.05);" class="hover:bg-[rgba(34,211,238,0.03)]">
                        <td class="py-3 px-4 font-medium" style="color: #F0F0FA;">
                            <span class="inline-flex items-center gap-2">
                                <svg class="w-4 h-4 flex-shrink-0" style="color: #F97316;" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                {{ $curiositum->titolo }}
                            </span>
                        </td>
                        <td class="py-3 px-4">
                            <a href="{{ route('admin.corpi-celesti.show', $curiositum->corpoCeleste) }}"
                               class="transition-colors duration-150 hover:text-[#A855F7]"
                               style="color: #22D3EE;">
                                {{ $curiositum->corpoCeleste->nome }}
                            </a>
                        </td>
                        <td class="py-3 px-4" style="color: #9CA3AF; max-width: 300px;" class="truncate">{{ Str::limit($curiositum->descrizione, 80) }}</td>
                        <td class="py-3 px-4" style="color: #6B7280; max-width: 150px;" class="truncate">{{ $curiositum->fonte ? Str::limit($curiositum->fonte, 40) : '—' }}</td>
                        <td class="py-3 px-4 text-right">
                            <div class="flex items-center justify-end gap-2">
                                <a href="{{ route('admin.curiosita.edit', $curiositum) }}"
                                   class="p-2 rounded-lg transition-all duration-200 hover:text-[#F97316] hover:bg-[rgba(249,115,22,0.1)]"
                                   style="color: #9CA3AF;"
                                   aria-label="Modifica {{ $curiositum->titolo }}"
                                   title="Modifica">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                </a>
                                <form method="POST" action="{{ route('admin.curiosita.destroy', $curiositum) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare questa curiosità?');">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit"
                                            class="p-2 rounded-lg transition-all duration-200 hover:text-[#EF4444] hover:bg-[rgba(239,68,68,0.1)]"
                                            style="color: #9CA3AF;"
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
                            <p class="text-lg mb-2" style="color: #6B7280;">Nessuna curiosità trovata</p>
                            <a href="{{ route('admin.curiosita.create') }}" class="text-sm font-medium transition-colors duration-150 hover:text-[#A855F7]" style="color: #22D3EE;">Crea la prima curiosità</a>
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
