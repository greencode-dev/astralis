@extends('admin.layouts.app')

@section('title', 'Nuova Categoria')
@section('page_title', 'Nuova Categoria')

@section('content')
    <div class="max-w-2xl">
        @include('admin.partials.back-link', ['route' => 'admin.categorie.index'])

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.categorie.store') }}">
                @csrf

                <div class="mb-5">
                    <label for="nome" class="block text-sm font-medium mb-2 text-admin-text">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required
                           class="admin-input">
                    @error('nome')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="icona" class="block text-sm font-medium mb-2 text-admin-text">Icona (emoji)</label>
                    <input type="text" name="icona" id="icona" value="{{ old('icona') }}" placeholder="es. 🌍"
                           class="admin-input">
                    @error('icona')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                @include('admin.partials.color-picker-html')

                <div class="mb-6">
                    <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" rows="4"
                              class="admin-input">{{ old('descrizione') }}</textarea>
                    @error('descrizione')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="admin-btn-primary">
                        Salva Categoria
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
