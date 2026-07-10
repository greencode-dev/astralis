@extends('admin.layouts.app')

@section('title', $curiositum->titolo)
@section('page_title', $curiositum->titolo)

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.curiosita.index') }}"
           class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 text-gray-400 hover:text-admin-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl overflow-hidden bg-admin-card border border-admin-primary/10">
            <div class="p-6 space-y-6">
                <div>
                    <h3 class="text-sm font-medium text-gray-400 mb-1">Corpo Celeste</h3>
                    <a href="{{ route('admin.corpi-celesti.show', $curiositum->corpoCeleste) }}"
                       class="text-admin-primary hover:text-admin-secondary transition-colors duration-150">
                        {{ $curiositum->corpoCeleste->nome }}
                    </a>
                </div>

                <div>
                    <h3 class="text-sm font-medium text-gray-400 mb-1">Descrizione</h3>
                    <p class="text-admin-text leading-relaxed">{{ $curiositum->descrizione }}</p>
                </div>

                @if ($curiositum->fonte)
                    <div>
                        <h3 class="text-sm font-medium text-gray-400 mb-1">Fonte</h3>
                        <p class="text-admin-text">{{ $curiositum->fonte }}</p>
                    </div>
                @endif
            </div>

            <div class="flex items-center gap-3 px-6 py-4 border-t border-admin-primary/10">
                <a href="{{ route('admin.curiosita.edit', $curiositum) }}"
                   class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-accent/15 text-admin-accent border border-admin-accent/20 hover:bg-admin-accent/25">
                    Modifica
                </a>
                <form method="POST" action="{{ route('admin.curiosita.destroy', $curiositum) }}" class="inline" onsubmit="return confirm('Sei sicuro di voler eliminare {{ $curiositum->titolo }}?');">
                    @csrf
                    @method('DELETE')
                    <button type="submit"
                            class="inline-flex items-center gap-2 px-4 py-2 rounded-lg text-sm font-medium transition-all duration-200 text-red-500 border border-red-500/20 hover:bg-red-500/10">
                        Elimina
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
