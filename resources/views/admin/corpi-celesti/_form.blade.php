@php
    $isEdit = isset($entity);
    $entity = $entity ?? null;
    $route = $isEdit ? route('admin.corpi-celesti.update', $entity) : route('admin.corpi-celesti.store');
@endphp
<form method="POST" action="{{ $route }}">
    @csrf
    @if($isEdit) @method('PUT') @endif

    {{-- Identificazione --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Identificazione</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
        <div>
            <label for="nome" class="block text-sm font-medium mb-2 text-admin-text">Nome (inglese) <span class="text-red-500">*</span></label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $entity->nome ?? null) }}" required
                   class="admin-input">
            @error('nome')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="nome_it" class="block text-sm font-medium mb-2 text-admin-text">Nome (italiano)</label>
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="nome_it" id="nome_it" value="{{ old('nome_it', $entity->nome_it ?? null) }}"
                       class="admin-input flex-1">
                <button type="button" id="cercaNasaBtn"
                        class="px-3 py-2.5 rounded-lg text-xs font-medium transition-all duration-200 whitespace-nowrap bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25 hover:border-admin-primary/40 sm:w-auto w-full">
                    Cerca su NASA
                </button>
            </div>
            <p id="suggestResult" class="mt-1 text-xs text-gray-500"></p>
            @error('nome_it')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- Classificazione --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Classificazione</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
        <div>
            <label for="categoria_id" class="block text-sm font-medium mb-2 text-admin-text">Categoria <span class="text-red-500">*</span></label>
            <select name="categoria_id" id="categoria_id" required
                    class="admin-input">
                <option value="">Seleziona categoria</option>
                @foreach ($categorie as $categoria)
                    <option value="{{ $categoria->id }}" {{ old('categoria_id', $entity->categoria_id ?? null) == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }}</option>
                @endforeach
            </select>
            @error('categoria_id')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="tipo" class="block text-sm font-medium mb-2 text-admin-text">Tipo</label>
            <input type="text" name="tipo" id="tipo" value="{{ old('tipo', $entity->tipo ?? null) }}" placeholder="es. Pianeta roccioso"
                   class="admin-input">
            @error('tipo')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- Immagine --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Immagine</h3>
    <div class="mb-6">
        <label for="immagine" class="block text-sm font-medium mb-2 text-admin-text">URL Immagine</label>
        @if($isEdit && $entity->immagine)
            <div class="flex items-center gap-3 mb-2">
                <img loading="lazy" src="{{ $entity->immagine_url }}" alt="{{ $entity->nome }}" class="w-10 h-10 rounded-lg object-cover border border-admin-primary/20">
                <span class="text-xs text-gray-500">URL attuale</span>
            </div>
        @endif
        <input type="url" name="immagine" id="immagine" value="{{ old('immagine', $entity->immagine ?? null) }}" placeholder="https://images-assets.nasa.gov/..."
               class="admin-input">
        <p class="mt-1 text-xs text-gray-500">{{ $isEdit ? 'Lascia vuoto per mantenere l\'immagine attuale.' : 'Lascia vuoto per importare automaticamente da NASA.' }}</p>
        @error('immagine')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
    </div>

    {{-- Proprietà fisiche --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Proprietà fisiche</h3>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-5 mb-6">
        <div>
            <label for="massa_kg" class="block text-sm font-medium mb-2 text-admin-text">Massa (kg)</label>
            <input type="text" name="massa_kg" id="massa_kg" value="{{ old('massa_kg', $entity->massa_kg ?? null) }}" placeholder="es. 5.972e24"
                   class="admin-input-mono">
            @error('massa_kg')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="distanza_km" class="block text-sm font-medium mb-2 text-admin-text">Distanza (km)</label>
            <input type="text" name="distanza_km" id="distanza_km" value="{{ old('distanza_km', $entity->distanza_km ?? null) }}" placeholder="es. 149600000"
                   class="admin-input-mono">
            @error('distanza_km')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="diametro_km" class="block text-sm font-medium mb-2 text-admin-text">Diametro (km)</label>
            <input type="text" name="diametro_km" id="diametro_km" value="{{ old('diametro_km', $entity->diametro_km ?? null) }}" placeholder="es. 12756"
                   class="admin-input-mono">
            @error('diametro_km')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="gravita" class="block text-sm font-medium mb-2 text-admin-text">Gravità (m/s²)</label>
            <input type="number" step="0.0001" name="gravita" id="gravita" value="{{ old('gravita', $entity->gravita ?? null) }}" placeholder="es. 9.81"
                   class="admin-input">
            @error('gravita')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="temperatura" class="block text-sm font-medium mb-2 text-admin-text">Temperatura (°C)</label>
            <input type="number" step="0.01" name="temperatura" id="temperatura" value="{{ old('temperatura', $entity->temperatura ?? null) }}" placeholder="es. 15"
                   class="admin-input">
            @error('temperatura')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="periodo_orbitale" class="block text-sm font-medium mb-2 text-admin-text">Periodo orbitale (giorni)</label>
            <input type="number" step="0.000001" name="periodo_orbitale" id="periodo_orbitale" value="{{ old('periodo_orbitale', $entity->periodo_orbitale ?? null) }}" placeholder="es. 365.25"
                   class="admin-input">
            @error('periodo_orbitale')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- Scoperta --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Scoperta</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
        <div>
            <label for="scopritore" class="block text-sm font-medium mb-2 text-admin-text">Scopritore</label>
            <input type="text" name="scopritore" id="scopritore" value="{{ old('scopritore', $entity->scopritore ?? null) }}" placeholder="es. Galileo Galilei"
                   class="admin-input">
            @error('scopritore')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="anno_scoperta" class="block text-sm font-medium mb-2 text-admin-text">Anno scoperta</label>
            <input type="number" name="anno_scoperta" id="anno_scoperta" value="{{ old('anno_scoperta', $entity->anno_scoperta ?? null) }}" placeholder="es. 1781"
                   class="admin-input">
            @error('anno_scoperta')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- Dettagli --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Dettagli</h3>
    <div class="mb-5">
        <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione</label>
        <textarea name="descrizione" id="descrizione" rows="5"
                  class="admin-input">{{ old('descrizione', $entity->descrizione ?? null) }}</textarea>
        @error('descrizione')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
    </div>

    <div class="mb-6">
        <label class="flex items-center gap-3 cursor-pointer">
            <input type="checkbox" name="in_evidenza" value="1" {{ old('in_evidenza', $entity->in_evidenza ?? null) ? 'checked' : '' }}
                   class="w-4 h-4 rounded bg-admin-bg border-admin-primary/30 text-admin-primary">
            <span class="text-sm font-medium text-admin-text">In evidenza sulla homepage</span>
        </label>
    </div>

    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3">
        <button type="submit"
                class="admin-btn-primary sm:w-auto w-full">
            {{ $isEdit ? 'Aggiorna Corpo Celeste' : 'Salva Corpo Celeste' }}
        </button>
        <a href="{{ route('admin.corpi-celesti.index') }}"
           class="admin-btn-cancel sm:w-auto w-full text-center">
            Annulla
        </a>
    </div>
</form>
