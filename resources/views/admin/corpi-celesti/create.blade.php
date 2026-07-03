@extends('admin.layouts.app')

@section('title', 'Nuovo Corpo Celeste')
@section('page_title', 'Nuovo Corpo Celeste')

@section('content')
    <div class="max-w-3xl">
        <a href="{{ route('admin.corpi-celesti.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150" style="color: #9CA3AF;" onmouseover="this.style.color='#22D3EE';" onmouseout="this.style.color='#9CA3AF';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
            <form method="POST" action="{{ route('admin.corpi-celesti.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div>
                        <label for="nome" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Nome <span style="color: #EF4444;">*</span></label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('nome')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="categoria_id" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Categoria <span style="color: #EF4444;">*</span></label>
                        <select name="categoria_id" id="categoria_id" required
                                class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                                style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                                onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                                onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                            <option value="">Seleziona categoria</option>
                            @foreach ($categorie as $categoria)
                                <option value="{{ $categoria->id }}" {{ old('categoria_id') == $categoria->id ? 'selected' : '' }}>{{ $categoria->nome }} {{ $categoria->icona }}</option>
                            @endforeach
                        </select>
                        @error('categoria_id')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="tipo" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Tipo</label>
                        <input type="text" name="tipo" id="tipo" value="{{ old('tipo') }}" placeholder="es. Pianeta roccioso"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('tipo')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="immagine" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Immagine</label>
                        <input type="file" name="immagine" id="immagine" accept="image/jpeg,image/png,image/webp"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        <p class="mt-1 text-xs" style="color: #6B7280;">Max 2MB. Formati: JPG, PNG, WebP.</p>
                        @error('immagine')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="massa_kg" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Massa (kg)</label>
                        <input type="text" name="massa_kg" id="massa_kg" value="{{ old('massa_kg') }}" placeholder="es. 5.972e24"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2); font-family: monospace;"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('massa_kg')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="distanza_km" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Distanza (km)</label>
                        <input type="text" name="distanza_km" id="distanza_km" value="{{ old('distanza_km') }}" placeholder="es. 149600000"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2); font-family: monospace;"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('distanza_km')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="diametro_km" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Diametro (km)</label>
                        <input type="text" name="diametro_km" id="diametro_km" value="{{ old('diametro_km') }}" placeholder="es. 12756"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2); font-family: monospace;"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('diametro_km')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="gravita" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Gravità (m/s²)</label>
                        <input type="number" step="0.0001" name="gravita" id="gravita" value="{{ old('gravita') }}" placeholder="es. 9.81"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('gravita')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="temperatura" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Temperatura (°C)</label>
                        <input type="number" step="0.01" name="temperatura" id="temperatura" value="{{ old('temperatura') }}" placeholder="es. 15"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('temperatura')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="periodo_orbitale" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Periodo orbitale (giorni)</label>
                        <input type="number" step="0.000001" name="periodo_orbitale" id="periodo_orbitale" value="{{ old('periodo_orbitale') }}" placeholder="es. 365.25"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('periodo_orbitale')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="scopritore" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Scopritore</label>
                        <input type="text" name="scopritore" id="scopritore" value="{{ old('scopritore') }}" placeholder="es. Galileo Galilei"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('scopritore')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="anno_scoperta" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Anno scoperta</label>
                        <input type="number" name="anno_scoperta" id="anno_scoperta" value="{{ old('anno_scoperta') }}" placeholder="es. 1781"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('anno_scoperta')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mb-5 mt-5">
                    <label for="descrizione" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" rows="5"
                              class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                              style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                              onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                              onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">{{ old('descrizione') }}</textarea>
                    @error('descrizione')<p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>@enderror
                </div>

                <div class="mb-6">
                    <label class="flex items-center gap-3 cursor-pointer">
                        <input type="checkbox" name="in_evidenza" value="1" {{ old('in_evidenza') ? 'checked' : '' }}
                               class="w-4 h-4 rounded"
                               style="background-color: #0A0A1A; border-color: rgba(34, 211, 238, 0.3); color: #22D3EE;">
                        <span class="text-sm font-medium" style="color: #F0F0FA;">In evidenza sulla homepage</span>
                    </label>
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200"
                            style="background-color: #22D3EE; color: #0A0A1A;"
                            onmouseover="this.style.backgroundColor='#1BB8D1';"
                            onmouseout="this.style.backgroundColor='#22D3EE';">
                        Salva Corpo Celeste
                    </button>
                    <a href="{{ route('admin.corpi-celesti.index') }}"
                       class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200"
                       style="color: #9CA3AF;"
                       onmouseover="this.style.color='#F0F0FA'; this.style.backgroundColor='rgba(255,255,255,0.05)';"
                       onmouseout="this.style.color='#9CA3AF'; this.style.backgroundColor='transparent';">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
