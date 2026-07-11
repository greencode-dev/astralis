@php
    $isEdit = isset($entity);
    $route = $isEdit ? route('admin.categorie.update', $entity) : route('admin.categorie.store');
@endphp
<form method="POST" action="{{ $route }}">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="mb-5">
        <label for="nome" class="block text-sm font-medium mb-2 text-admin-text">Nome <span class="text-red-500">*</span></label>
        <input type="text" name="nome" id="nome" value="{{ old('nome', $entity->nome ?? null) }}" required
               class="admin-input">
        @error('nome')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="mb-5">
        <label for="icona" class="block text-sm font-medium mb-2 text-admin-text">Icona (emoji)</label>
        <input type="text" name="icona" id="icona" value="{{ old('icona', $entity->icona ?? null) }}" placeholder="es. 🌍"
               class="admin-input">
        @error('icona')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    @include('admin.partials.color-picker-html', ['coloreValue' => old('colore', $entity->colore ?? 'var(--admin-primary)')])

    <div class="mb-6">
        <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione</label>
        <textarea name="descrizione" id="descrizione" rows="4"
                  class="admin-input">{{ old('descrizione', $entity->descrizione ?? null) }}</textarea>
        @error('descrizione')
            <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
        @enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="admin-btn-primary">
            {{ $isEdit ? 'Aggiorna Categoria' : 'Salva Categoria' }}
        </button>
        <a href="{{ route('admin.categorie.index') }}"
           class="admin-btn-cancel">
            Annulla
        </a>
    </div>
</form>
