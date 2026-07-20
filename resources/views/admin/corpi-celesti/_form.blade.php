@php
    $isEdit = isset($entity);
    $entity = $entity ?? null;
    $route = $isEdit ? route('admin.corpi-celesti.update', $entity) : route('admin.corpi-celesti.store');
@endphp
<form method="POST" action="{{ $route }}" enctype="multipart/form-data" x-data="corpoForm()" x-cloak>
    @csrf
    @if($isEdit) @method('PUT') @endif

    {{-- In evidenza toggle — top right --}}
    <div class="flex items-center justify-between mb-6">
        <div></div>
        <label class="flex items-center gap-2.5 cursor-pointer select-none">
            <span class="text-sm text-gray-400">In evidenza</span>
            <button type="button" role="switch" aria-checked="false"
                    @click="inEvidenza = !inEvidenza; $refs.inEvidenzaInput.value = inEvidenza ? '1' : '0'"
                    :class="inEvidenza ? 'bg-admin-primary' : 'bg-gray-600'"
                    class="relative inline-flex h-6 w-11 items-center rounded-full transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-admin-primary/50">
                <span :class="inEvidenza ? 'translate-x-5' : 'translate-x-1'"
                      class="inline-block h-4 w-4 transform rounded-full bg-white transition-transform duration-200" />
            </button>
            <input type="hidden" name="in_evidenza" :value="inEvidenza ? '1' : '0'" x-ref="inEvidenzaInput">
        </label>
    </div>

    {{-- 1. Identificazione --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Identificazione</h3>
    <div class="grid grid-cols-1 md:grid-cols-2 gap-5 mb-6">
        <div>
            <label for="nome" class="block text-sm font-medium mb-2 text-admin-text">Nome (italiano) <span class="text-red-500">*</span></label>
            <input type="text" name="nome" id="nome" value="{{ old('nome', $entity->nome ?? null) }}" required
                   class="admin-input" @input.debounce.500ms="autoTranslate()">
            @error('nome')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>

        <div>
            <label for="nome_en" class="block text-sm font-medium mb-2 text-admin-text">Nome (inglese)</label>
            <div class="flex flex-col sm:flex-row gap-2">
                <input type="text" name="nome_en" id="nome_en" x-model="nomeEn"
                       class="admin-input flex-1">
                <button type="button" id="cercaNasaBtn" @click="searchNasa()"
                        class="px-3 py-2.5 rounded-lg text-xs font-medium transition-all duration-200 whitespace-nowrap bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25 hover:border-admin-primary/40 sm:w-auto w-full"
                        :disabled="nasaLoading">
                    <span x-show="!nasaLoading">Cerca su NASA</span>
                    <span x-show="nasaLoading">Cerco...</span>
                </button>
            </div>
            <p id="suggestResult" class="mt-1 text-xs"
               :class="suggestColor"
               x-text="suggestMsg"></p>
            @error('nome_en')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- 2. Classificazione --}}
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
            @php
                $predefined = ['Pianeta roccioso','Gigante gassoso','Gigante di ghiaccio','Stella nana gialla','Galassia a spirale','Galassia a spirale barrata','Nebulosa a emissione','Satellite naturale','Satellite ghiacciato','Satellite atmosferico','Asteroide','Cometa periodica','Pianeta nano'];
                $currentTipo = old('tipo', $entity->tipo ?? null);
                $isCustomTipo = $currentTipo && !in_array($currentTipo, $predefined);
            @endphp
            <div x-data="{ customTipo: 'false' }" x-init="customTipo = '{{ $isCustomTipo ? 'true' : 'false' }}'">
                <select name="tipo" id="tipo" class="admin-input"
                        x-show="customTipo === 'false'"
                        x-on:change="if($event.target.value === '__custom__') { customTipo = 'true'; $nextTick(() => document.getElementById('tipo_custom').focus()); }">
                    <option value="">Seleziona tipo</option>
                    @foreach($predefined as $tipoOp)
                        <option value="{{ $tipoOp }}" {{ $currentTipo === $tipoOp ? 'selected' : '' }}>{{ $tipoOp }}</option>
                    @endforeach
                    <option value="__custom__">Altro (personalizzato)...</option>
                </select>
                <div x-show="customTipo === 'true'" class="flex gap-2">
                    <input type="text" name="tipo" id="tipo_custom" value="{{ $currentTipo }}"
                           placeholder="Es. Pianeta roccioso" class="admin-input flex-1">
                    <button type="button" @click="customTipo = 'false'; $el.closest('[x-data]').querySelector('select[name=tipo]').value = ''"
                            class="px-3 py-2 text-xs text-gray-400 hover:text-admin-text">← Select</button>
                </div>
            </div>
            @error('tipo')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        </div>
    </div>

    {{-- 3. Immagine --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Immagine</h3>
    <div class="mb-6" x-data="{ previewUrl: '{{ $isEdit && $entity->immagine ? $entity->immagine_url : '' }}' }">
        @if($isEdit && $entity->immagine)
            <div class="flex items-center gap-3 mb-2">
                <img loading="lazy" :src="previewUrl || '{{ $entity->immagine_url }}'" alt="{{ $entity->nome }}" class="w-10 h-10 rounded-lg object-cover border border-admin-primary/20">
                <span class="text-xs text-gray-500">Immagine attuale</span>
            </div>
        @endif
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label for="immagine_file" class="block text-sm font-medium mb-2 text-admin-text">Carica file</label>
                <input type="file" name="immagine_file" id="immagine_file" accept="image/jpeg,image/png,image/webp"
                       class="admin-input file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0"
                       onchange="if(this.files && this.files[0]) { const r = new FileReader(); r.onload = e => { document.getElementById('coverPreview').src = e.target.result; document.getElementById('coverPreviewWrap').style.display = 'block'; }; r.readAsDataURL(this.files[0]); }">
                <p class="mt-1 text-xs text-gray-500">JPG, PNG, WebP. Max 2MB.</p>
            </div>
            <div>
                <label for="immagine" class="block text-sm font-medium mb-2 text-admin-text">Oppure URL</label>
                <input type="url" name="immagine" id="immagine" value="{{ old('immagine', $entity->immagine ?? null) }}" placeholder="https://images-assets.nasa.gov/..."
                       class="admin-input">
                <p class="mt-1 text-xs text-gray-500">{{ $isEdit ? 'Lascia vuoto per mantenere l\'immagine attuale.' : 'Lascia vuoto per importare da NASA.' }}</p>
            </div>
        </div>
        <div id="coverPreviewWrap" style="display: none;" class="mt-3">
            <img id="coverPreview" class="w-20 h-20 rounded-lg object-cover border border-admin-primary/20" alt="Preview">
        </div>
        @error('immagine')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
        @error('immagine_file')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
    </div>

    {{-- 4. Proprietà fisiche --}}
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

    {{-- 5. Scoperta --}}
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

    {{-- 6. Dettagli --}}
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Dettagli</h3>
    <div class="mb-5">
        <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione</label>
        <textarea name="descrizione" id="descrizione" rows="5"
                  class="admin-input">{{ old('descrizione', $entity->descrizione ?? null) }}</textarea>
        @error('descrizione')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
    </div>

    {{-- 7. Galleria inline (solo in edit) --}}
    @if($isEdit)
    <h3 class="text-xs font-semibold uppercase tracking-wider text-admin-muted mb-3">Galleria</h3>
    <div class="mb-6" x-data="galleryInline({{ $entity->id }})">
        {{-- existing photos --}}
        @if($entity->galleria && $entity->galleria->count() > 0)
        <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3 mb-4">
            @foreach($entity->galleria as $foto)
            <div class="relative group rounded-lg overflow-hidden border border-admin-primary/10 bg-admin-bg"
                 x-data="{ hover: false }" @mouseenter="hover = true" @mouseleave="hover = false">
                <div class="aspect-square">
                    <img loading="lazy" src="{{ $foto->percorso_url }}" alt="{{ $foto->didascalia ?? '' }}" class="w-full h-full object-cover">
                </div>
                {{-- overlay buttons --}}
                <div x-show="hover" x-cloak class="absolute inset-0 bg-black/50 flex items-center justify-center gap-2 transition-opacity">
                    <form method="POST" action="{{ route('admin.corpi-celesti.set-image', [$entity, $foto]) }}">
                        @csrf
                        <button type="submit" class="px-2 py-1 text-[10px] font-medium rounded bg-admin-primary/80 text-white hover:bg-admin-primary">Copertina</button>
                    </form>
                    <button type="button" @click="removePhoto({{ $foto->id }})"
                            class="px-2 py-1 text-[10px] font-medium rounded bg-red-500/80 text-white hover:bg-red-500">Rimuovi</button>
                </div>
                @if($foto->didascalia)
                <div class="p-1.5"><p class="text-[10px] text-gray-400 truncate">{{ $foto->didascalia }}</p></div>
                @endif
            </div>
            @endforeach
        </div>
        @endif

        {{-- NASA search --}}
        <div class="rounded-lg p-3 bg-admin-bg border border-admin-primary/10">
            <div class="flex items-center gap-2 mb-2">
                <span class="text-xs font-medium text-gray-400">Aggiungi da NASA</span>
            </div>
            <div class="flex gap-2 mb-3">
                <input type="text" x-model="galleryQuery" placeholder="Cerca su NASA (es. Jupiter)..."
                       class="admin-input flex-1 text-sm"
                       @keydown.enter.prevent="searchGallery()">
                <button type="button" @click="searchGallery()" :disabled="galleryLoading"
                        class="px-3 py-2 rounded-lg text-xs font-medium bg-admin-primary/15 text-admin-primary border border-admin-primary/20 hover:bg-admin-primary/25">
                    <span x-show="!galleryLoading">Cerca</span>
                    <span x-show="galleryLoading">...</span>
                </button>
            </div>

            {{-- results grid --}}
            <div x-show="galleryResults.length > 0" class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-6 gap-2 mb-3">
                <template x-for="(item, idx) in galleryResults" :key="idx">
                    <div class="relative group rounded-lg overflow-hidden border cursor-pointer transition-all"
                         :class="item.selected ? 'border-admin-primary ring-2 ring-admin-primary/30' : 'border-admin-primary/10 hover:border-admin-primary/30'"
                         @click="item.selected = !item.selected">
                        <div class="aspect-square bg-admin-bg">
                            <img :src="item.thumbnail" :alt="item.title" class="w-full h-full object-cover" loading="lazy">
                        </div>
                        <div x-show="item.selected" x-cloak class="absolute top-1 right-1 w-5 h-5 rounded-full bg-admin-primary flex items-center justify-center">
                            <svg class="w-3 h-3 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                        </div>
                    </div>
                </template>
            </div>

            {{-- add selected --}}
            <div x-show="selectedCount > 0" class="flex items-center gap-3">
                <button type="button" @click="addSelectedToGallery()"
                        :disabled="addingToGallery"
                        class="px-4 py-2 rounded-lg text-xs font-medium bg-admin-success/15 text-admin-success border border-admin-success/20 hover:bg-admin-success/25">
                    <span x-show="!addingToGallery">Aggiungi <span x-text="selectedCount"></span> foto</span>
                    <span x-show="addingToGallery">Aggiungo...</span>
                </button>
                <button type="button" @click="galleryResults.forEach(i => i.selected = false)"
                        class="text-xs text-gray-400 hover:text-admin-text">Deseleziona tutto</button>
            </div>

            <p x-show="galleryError" x-text="galleryError" class="mt-2 text-xs text-red-500"></p>
        </div>
    </div>
    @endif

    {{-- Submit --}}
    <div class="flex flex-col sm:flex-row items-stretch sm:items-center gap-3 mt-6">
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

@php
    $jsInEvidenza = old('in_evidenza', $entity->in_evidenza ?? false) ? 'true' : 'false';
    $jsNomeEn = e(old('nome_en', $entity->nome_en ?? ''));
@endphp
@push('scripts')
<script>
function corpoForm() {
    return {
        inEvidenza: {{ $jsInEvidenza }},
        nomeEn: '{{ $jsNomeEn }}',
        nasaLoading: false,
        suggestMsg: '',
        suggestColor: 'text-gray-500',

        autoTranslate() {
            const nome = document.getElementById('nome').value.trim();
            if (!nome || nome.length < 2) return;
            this.suggestMsg = 'Traduzione automatica...';
            this.suggestColor = 'text-gray-500';

            fetch('{{ route("admin.corpi-celesti.suggest-nome") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nome: nome })
            })
            .then(r => r.json())
            .then(data => {
                if (data.success && data.nome_en) {
                    this.nomeEn = data.nome_en;
                    this.suggestMsg = 'Tradotto: ' + data.nome_en;
                    this.suggestColor = 'text-green-400';
                } else {
                    this.suggestMsg = '';
                }
            })
            .catch(() => { this.suggestMsg = ''; });
        },

        searchNasa() {
            const nome = document.getElementById('nome').value.trim();
            const nomeEn = this.nomeEn.trim();
            if (!nome && !nomeEn) {
                this.suggestMsg = 'Inserisci un nome.';
                this.suggestColor = 'text-red-400';
                return;
            }
            this.nasaLoading = true;
            this.suggestMsg = 'Cerco su NASA...';
            this.suggestColor = 'text-gray-500';

            fetch('{{ route("admin.corpi-celesti.suggest-nome") }}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({ nome: nome, nome_en: nomeEn })
            })
            .then(r => r.json())
            .then(data => {
                this.nasaLoading = false;
                if (data.success && data.nome_en) {
                    this.nomeEn = data.nome_en;
                    this.suggestMsg = 'Suggerito: ' + data.nome_en;
                    this.suggestColor = 'text-green-400';
                } else if (data.needs_manual) {
                    this.suggestMsg = data.message;
                    this.suggestColor = 'text-yellow-400';
                } else {
                    this.suggestMsg = data.message || 'Nessun risultato.';
                    this.suggestColor = 'text-red-400';
                }
            })
            .catch(() => {
                this.nasaLoading = false;
                this.suggestMsg = 'Errore di connessione.';
                this.suggestColor = 'text-red-400';
            });
        }
    };
}

function galleryInline(corpoId) {
    return {
        galleryQuery: '',
        galleryResults: [],
        galleryLoading: false,
        galleryError: '',
        addingToGallery: false,

        get selectedCount() {
            return this.galleryResults.filter(i => i.selected).length;
        },

        searchGallery() {
            const q = this.galleryQuery.trim();
            if (!q) return;
            this.galleryLoading = true;
            this.galleryError = '';
            this.galleryResults = [];

            fetch('https://images-api.nasa.gov/search?q=' + encodeURIComponent(q) + '&media_type=image')
                .then(r => r.json())
                .then(data => {
                    this.galleryLoading = false;
                    const items = (data.collection && data.collection.items) || [];
                    this.galleryResults = items.slice(0, 24).map(item => {
                        const d = item.data && item.data[0] || {};
                        const links = item.links && item.links[0] || {};
                        return {
                            title: d.title || '',
                            nasa_id: d.nasa_id || '',
                            thumbnail: links.href || '',
                            selected: false
                        };
                    }).filter(i => i.thumbnail);
                    if (this.galleryResults.length === 0) {
                        this.galleryError = 'Nessun risultato trovato.';
                    }
                })
                .catch(() => {
                    this.galleryLoading = false;
                    this.galleryError = 'Errore di connessione.';
                });
        },

        addSelectedToGallery() {
            const toAdd = this.galleryResults.filter(i => i.selected);
            if (toAdd.length === 0) return;
            this.addingToGallery = true;

            const csrf = '{{ csrf_token() }}';
            let added = 0;
            let failed = 0;

            const promises = toAdd.map(item => {
                return fetch('/admin/corpi-celesti/' + corpoId + '/gallery-add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrf,
                        'X-Requested-With': 'XMLHttpRequest'
                    },
                    body: JSON.stringify({
                        percorso: item.thumbnail,
                        didascalia: item.title,
                        crediti: 'NASA'
                    })
                })
                .then(r => r.ok ? r.json() : Promise.reject(r))
                .then(() => { added++; })
                .catch(() => { failed++; });
            });

            Promise.all(promises).then(() => {
                this.addingToGallery = false;
                if (added > 0) {
                    window.location.reload();
                } else {
                    this.galleryError = 'Nessuna foto aggiunta.';
                }
            });
        },

        removePhoto(photoId) {
            if (!confirm('Rimuovere questa foto dalla galleria?')) return;
            const csrf = '{{ csrf_token() }}';
            fetch('/admin/galleria/' + photoId, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': csrf,
                    'X-Requested-With': 'XMLHttpRequest'
                }
            })
            .then(r => r.ok ? window.location.reload() : alert('Errore'));
        }
    };
}
</script>
@endpush
