@php
    $isEdit = isset($entity);
    $entity = $entity ?? null;
    $route = $isEdit ? route('admin.missioni.update', $entity) : route('admin.missioni.store');
@endphp
<form method="POST" action="{{ $route }}" enctype="multipart/form-data">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
        <div class="md:col-span-2">
            <label for="nome" class="block text-sm font-medium mb-2 text-admin-text">Nome <span class="text-red-500">*</span></label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $entity->nome ?? null) }}" required
                   class="admin-input">
            @error('nome')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="agenzia" class="block text-sm font-medium mb-2 text-admin-text">Agenzia</label>
            <input type="text" name="agenzia" id="agenzia" value="{{ old('agenzia', $entity->agenzia ?? null) }}" placeholder="es. NASA"
                   class="admin-input">
            @error('agenzia')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="stato" class="block text-sm font-medium mb-2 text-admin-text">Stato</label>
            <select name="stato" id="stato"
                    class="admin-input">
                @foreach (array_keys(config('admin.mission_stati')) as $statoVal)
                    <option value="{{ $statoVal }}" {{ old('stato', $entity->stato ?? null) === $statoVal ? 'selected' : '' }}>{{ $statoVal }}</option>
                @endforeach
            </select>
            @error('stato')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="data_lancio" class="block text-sm font-medium mb-2 text-admin-text">Data lancio</label>
            <input type="date" name="data_lancio" id="data_lancio" value="{{ old('data_lancio', isset($entity) && $entity->data_lancio ? $entity->data_lancio->format('Y-m-d') : null) }}"
                   class="admin-input">
            @error('data_lancio')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="durata_giorni" class="block text-sm font-medium mb-2 text-admin-text">Durata (giorni)</label>
            <input type="number" name="durata_giorni" id="durata_giorni" value="{{ old('durata_giorni', $entity->durata_giorni ?? null) }}" placeholder="es. 365"
                   class="admin-input">
            @error('durata_giorni')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="logo" class="block text-sm font-medium mb-2 text-admin-text">Logo</label>
            @if($isEdit && $entity->logo)
                <div class="flex items-center gap-3 mb-2">
                    <img loading="lazy" src="{{ Storage::url('missioni/' . $entity->logo) }}" alt="{{ $entity->nome }}" class="w-10 h-10 rounded-lg object-cover border border-admin-primary/20">
                    <span class="text-xs text-gray-500">{{ $entity->logo }}</span>
                </div>
            @endif
            <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/webp,image/svg+xml"
                   class="admin-input file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0">
            <p class="mt-1 text-xs text-gray-500">{{ $isEdit ? 'Lascia vuoto per mantenere il logo attuale. Max 1MB.' : 'Max 1MB. Formati: JPG, PNG, WebP, SVG.' }}</p>
            @error('logo')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="sito_web" class="block text-sm font-medium mb-2 text-admin-text">Sito web</label>
            <input type="url" name="sito_web" id="sito_web" value="{{ old('sito_web', $entity->sito_web ?? null) }}" placeholder="https://..."
                   class="admin-input">
            @error('sito_web')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>
    </div>

    <div class="mb-5 mt-5">
        <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione</label>
        <textarea name="descrizione" id="descrizione" rows="5"
                  class="admin-input">{{ old('descrizione', $entity->descrizione ?? null) }}</textarea>
        @error('descrizione')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
    </div>

    <div class="flex items-center gap-3">
        <button type="submit"
                class="admin-btn-primary">{{ $isEdit ? 'Aggiorna Missione' : 'Salva Missione' }}</button>
        <a href="{{ route('admin.missioni.index') }}"
           class="admin-btn-cancel">Annulla</a>
    </div>
</form>
