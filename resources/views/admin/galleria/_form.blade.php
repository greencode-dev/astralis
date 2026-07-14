@php
    $isEdit = isset($entity);
    $entity = $entity ?? null;
    $route = $isEdit ? route('admin.galleria.update', $entity) : route('admin.galleria.store');
@endphp
<form method="POST" action="{{ $route }}" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="mb-5">
        <label for="corpo_celeste_id" class="block text-sm font-medium mb-2 text-admin-text">Corpo Celeste <span class="text-red-500">*</span></label>
        <select name="corpo_celeste_id" id="corpo_celeste_id" required
                class="admin-input">
            <option value="">— Seleziona un corpo celeste —</option>
            @foreach ($corpiCelesti as $corpo)
                <option value="{{ $corpo->id }}" {{ old('corpo_celeste_id', $entity->corpo_celeste_id ?? null) == $corpo->id ? 'selected' : '' }}>
                    {{ $corpo->nome }}
                </option>
            @endforeach
        </select>
        @error('corpo_celeste_id')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        @if($isEdit)
            <label class="block text-sm font-medium mb-2 text-admin-text">Immagine attuale</label>
            <div class="rounded-lg overflow-hidden mb-3 max-w-[300px] border border-admin-primary/10">
                <img loading="lazy" src="{{ $entity->percorso_url }}"
                     alt="{{ $entity->didascalia ?? 'Immagine' }}"
                     class="w-full h-auto">
            </div>
            <label for="percorso" class="block text-sm font-medium mb-2 text-admin-text">Sostituisci immagine</label>
        @else
            <label for="percorso" class="block text-sm font-medium mb-2 text-admin-text">Immagine <span class="text-red-500">*</span></label>
        @endif
        <input type="file" name="percorso" id="percorso" accept="image/jpeg,image/png,image/webp" {{ $isEdit ? '' : 'required' }}
               class="admin-input file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0">
        <p class="mt-1 text-xs text-gray-500">{{ $isEdit ? 'Lascia vuoto per mantenere l\'immagine corrente. Max 2MB. Formati: JPG, PNG, WebP.' : 'Max 2MB. Formati: JPG, PNG, WebP. Verrà ridimensionata a 1200px.' }}</p>
        @error('percorso')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="didascalia" class="block text-sm font-medium mb-2 text-admin-text">Didascalia</label>
        <input type="text" name="didascalia" id="didascalia" value="{{ old('didascalia', $entity->didascalia ?? null) }}"
               class="admin-input">
        @error('didascalia')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="crediti" class="block text-sm font-medium mb-2 text-admin-text">Crediti</label>
        <input type="text" name="crediti" id="crediti" value="{{ old('crediti', $entity->crediti ?? null) }}" placeholder="es. NASA / JPL"
               class="admin-input">
        @error('crediti')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="ordine" class="block text-sm font-medium mb-2 text-admin-text">Ordine</label>
        <input type="number" name="ordine" id="ordine" value="{{ old('ordine', $entity->ordine ?? 0) }}" min="0" max="9999"
               class="admin-input">
        <p class="mt-1 text-xs text-gray-500">Ordine di visualizzazione (dal più piccolo al più grande)</p>
        @error('ordine')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="admin-btn-primary">
            {{ $isEdit ? 'Aggiorna Immagine' : 'Salva Immagine' }}
        </button>
        <a href="{{ route('admin.galleria.index') }}"
           class="admin-btn-cancel">
            Annulla
        </a>
    </div>
</form>
