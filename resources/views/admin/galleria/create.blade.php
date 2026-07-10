@extends('admin.layouts.app')

@section('title', 'Nuova Immagine')
@section('page_title', 'Nuova Immagine')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.galleria.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 hover:text-admin-primary text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.galleria.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <label for="corpo_celeste_id" class="block text-sm font-medium mb-2 text-admin-text">Corpo Celeste <span class="text-red-500">*</span></label>
                    <select name="corpo_celeste_id" id="corpo_celeste_id" required
                            class="admin-input">
                        <option value="">— Seleziona un corpo celeste —</option>
                        @foreach ($corpi as $corpo)
                            <option value="{{ $corpo->id }}" {{ old('corpo_celeste_id') == $corpo->id ? 'selected' : '' }}>
                                {{ $corpo->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('corpo_celeste_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="percorso" class="block text-sm font-medium mb-2 text-admin-text">Immagine <span class="text-red-500">*</span></label>
                    <input type="file" name="percorso" id="percorso" accept="image/jpeg,image/png,image/webp" required
                           class="admin-input file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0">
                    <p class="mt-1 text-xs text-gray-500">Max 2MB. Formati: JPG, PNG, WebP. Verrà ridimensionata a 1200px.</p>
                    @error('percorso')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="didascalia" class="block text-sm font-medium mb-2 text-admin-text">Didascalia</label>
                    <input type="text" name="didascalia" id="didascalia" value="{{ old('didascalia') }}"
                           class="admin-input">
                    @error('didascalia')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="crediti" class="block text-sm font-medium mb-2 text-admin-text">Crediti</label>
                    <input type="text" name="crediti" id="crediti" value="{{ old('crediti') }}" placeholder="es. NASA / JPL"
                           class="admin-input">
                    @error('crediti')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="ordine" class="block text-sm font-medium mb-2 text-admin-text">Ordine</label>
                    <input type="number" name="ordine" id="ordine" value="{{ old('ordine', 0) }}" min="0" max="9999"
                           class="admin-input">
                    <p class="mt-1 text-xs text-gray-500">Ordine di visualizzazione (dal più piccolo al più grande)</p>
                    @error('ordine')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="admin-btn-primary">
                        Salva Immagine
                    </button>
                    <a href="{{ route('admin.galleria.index') }}"
                       class="admin-btn-cancel">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
