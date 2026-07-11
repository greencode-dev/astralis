@extends('admin.layouts.app')

@section('title', 'Modifica Categoria')
@section('page_title', 'Modifica Categoria')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.categorie.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 text-gray-400 hover:text-admin-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.categorie.update', $categoria) }}">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="nome" class="block text-sm font-medium mb-2 text-admin-text">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="nome" id="nome" value="{{ old('nome', $categoria->nome) }}" required
                           class="admin-input">
                    @error('nome')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="icona" class="block text-sm font-medium mb-2 text-admin-text">Icona (emoji)</label>
                    <input type="text" name="icona" id="icona" value="{{ old('icona', $categoria->icona) }}" placeholder="es. 🌍"
                           class="admin-input">
                    @error('icona')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                @include('admin.partials.color-picker-html', ['coloreValue' => $categoria->colore ?? 'var(--admin-primary)'])

                <div class="mb-6">
                    <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" rows="4"
                              class="admin-input">{{ old('descrizione', $categoria->descrizione) }}</textarea>
                    @error('descrizione')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="admin-btn-primary">
                        Aggiorna Categoria
                    </button>
                    <a href="{{ route('admin.categorie.index') }}"
                       class="admin-btn-cancel">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection

@include('admin.partials.color-picker-js')
