@extends('admin.layouts.app')

@section('title', 'Modifica Immagine')
@section('page_title', 'Modifica Immagine')

@section('content')
    <div class="max-w-2xl">
        @include('admin.partials.back-link', ['route' => 'admin.galleria.index'])

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.galleria.update', $galleriaCorpo) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="corpo_celeste_id" class="block text-sm font-medium mb-2 text-admin-text">Corpo Celeste <span class="text-red-500">*</span></label>
                    <select name="corpo_celeste_id" id="corpo_celeste_id" required
                            class="admin-input">
                        <option value="">— Seleziona un corpo celeste —</option>
                        @foreach ($corpi as $corpo)
                            <option value="{{ $corpo->id }}" {{ old('corpo_celeste_id', $galleriaCorpo->corpo_celeste_id) == $corpo->id ? 'selected' : '' }}>
                                {{ $corpo->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('corpo_celeste_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-2 text-admin-text">Immagine attuale</label>
                    <div class="rounded-lg overflow-hidden mb-3 max-w-[300px] border border-admin-primary/10">
                        <img loading="lazy" src="{{ $galleriaCorpo->percorso_url }}"
                             alt="{{ $galleriaCorpo->didascalia ?? 'Immagine' }}"
                             class="w-full h-auto">
                    </div>
                    <label for="percorso" class="block text-sm font-medium mb-2 text-admin-text">Sostituisci immagine</label>
                    <input type="file" name="percorso" id="percorso" accept="image/jpeg,image/png,image/webp"
                           class="admin-input file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0">
                    <p class="mt-1 text-xs text-gray-500">Lascia vuoto per mantenere l'immagine corrente. Max 2MB. Formati: JPG, PNG, WebP.</p>
                    @error('percorso')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="didascalia" class="block text-sm font-medium mb-2 text-admin-text">Didascalia</label>
                    <input type="text" name="didascalia" id="didascalia" value="{{ old('didascalia', $galleriaCorpo->didascalia) }}"
                           class="admin-input">
                    @error('didascalia')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="crediti" class="block text-sm font-medium mb-2 text-admin-text">Crediti</label>
                    <input type="text" name="crediti" id="crediti" value="{{ old('crediti', $galleriaCorpo->crediti) }}" placeholder="es. NASA / JPL"
                           class="admin-input">
                    @error('crediti')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="ordine" class="block text-sm font-medium mb-2 text-admin-text">Ordine</label>
                    <input type="number" name="ordine" id="ordine" value="{{ old('ordine', $galleriaCorpo->ordine) }}" min="0" max="9999"
                           class="admin-input">
                    <p class="mt-1 text-xs text-gray-500">Ordine di visualizzazione (dal più piccolo al più grande)</p>
                    @error('ordine')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="admin-btn-primary">
                        Aggiorna Immagine
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
