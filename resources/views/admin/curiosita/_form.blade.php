@php
    $isEdit = isset($entity);
    $entity = $entity ?? null;
    $route = $isEdit ? route('admin.curiosita.update', $entity) : route('admin.curiosita.store');
@endphp
<form method="POST" action="{{ $route }}">
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
        <label for="titolo" class="block text-sm font-medium mb-2 text-admin-text">Titolo <span class="text-red-500">*</span></label>
        <input type="text" name="titolo" id="titolo" value="{{ old('titolo', $entity->titolo ?? null) }}" required
               class="admin-input">
        @error('titolo')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione <span class="text-red-500">*</span></label>
        <textarea name="descrizione" id="descrizione" rows="6"
                  class="admin-input">{{ old('descrizione', $entity->descrizione ?? null) }}</textarea>
        @error('descrizione')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-6">
        <label for="fonte" class="block text-sm font-medium mb-2 text-admin-text">Fonte</label>
        <input type="text" name="fonte" id="fonte" value="{{ old('fonte', $entity->fonte ?? null) }}" placeholder="es. NASA, Wikipedia, ..."
               class="admin-input">
        @error('fonte')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="admin-btn-primary">
            {{ $isEdit ? 'Aggiorna Curiosità' : 'Salva Curiosità' }}
        </button>
        <a href="{{ route('admin.curiosita.index') }}"
           class="admin-btn-cancel">
            Annulla
        </a>
    </div>
</form>
