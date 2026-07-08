@extends('admin.layouts.app')

@section('title', 'Modifica Missione')
@section('page_title', 'Modifica ' . $missione->nome)

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.missioni.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 text-gray-400 hover:text-admin-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.missioni.update', $missione) }}" enctype="multipart/form-data">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                    <div class="md:col-span-2">
                        <label for="nome" class="block text-sm font-medium mb-2 text-admin-text">Nome <span class="text-red-500">*</span></label>
                        <input type="text" name="nome" id="nome" value="{{ old('nome', $missione->nome) }}" required
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('nome')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="agenzia" class="block text-sm font-medium mb-2 text-admin-text">Agenzia</label>
                        <input type="text" name="agenzia" id="agenzia" value="{{ old('agenzia', $missione->agenzia) }}" placeholder="es. NASA"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('agenzia')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="stato" class="block text-sm font-medium mb-2 text-admin-text">Stato</label>
                        <select name="stato" id="stato"
                                class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                                style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                                onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                                onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                            <option value="completata" {{ old('stato', $missione->stato) === 'completata' ? 'selected' : '' }}>Completata</option>
                            <option value="in corso" {{ old('stato', $missione->stato) === 'in corso' ? 'selected' : '' }}>In corso</option>
                            <option value="pianificata" {{ old('stato', $missione->stato) === 'pianificata' ? 'selected' : '' }}>Pianificata</option>
                        </select>
                        @error('stato')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="data_lancio" class="block text-sm font-medium mb-2 text-admin-text">Data lancio</label>
                        <input type="date" name="data_lancio" id="data_lancio" value="{{ old('data_lancio', $missione->data_lancio?->format('Y-m-d')) }}"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('data_lancio')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="durata_giorni" class="block text-sm font-medium mb-2 text-admin-text">Durata (giorni)</label>
                        <input type="number" name="durata_giorni" id="durata_giorni" value="{{ old('durata_giorni', $missione->durata_giorni) }}" placeholder="es. 365"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('durata_giorni')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="logo" class="block text-sm font-medium mb-2 text-admin-text">Logo</label>
                        @if ($missione->logo)
                            <div class="flex items-center gap-3 mb-2">
                                <img loading="lazy" src="{{ Storage::url('missioni/' . $missione->logo) }}" alt="{{ $missione->nome }}" class="w-10 h-10 rounded-lg object-cover border border-admin-primary/20">
                                <span class="text-xs text-gray-500">{{ $missione->logo }}</span>
                            </div>
                        @endif
                        <input type="file" name="logo" id="logo" accept="image/jpeg,image/png,image/webp,image/svg+xml"
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        <p class="mt-1 text-xs text-gray-500">Lascia vuoto per mantenere il logo attuale. Max 1MB.</p>
                        @error('logo')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>

                    <div>
                        <label for="sito_web" class="block text-sm font-medium mb-2 text-admin-text">Sito web</label>
                        <input type="url" name="sito_web" id="sito_web" value="{{ old('sito_web', $missione->sito_web) }}" placeholder="https://..."
                               class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        @error('sito_web')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                    </div>
                </div>

                <div class="mb-5 mt-5">
                    <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" rows="5"
                              class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                              style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                              onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                              onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">{{ old('descrizione', $missione->descrizione) }}</textarea>
                    @error('descrizione')<p class="mt-1 text-sm text-red-500">{{ $message }}</p>@enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                             class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:bg-[#1BB8D1]">Aggiorna Missione</button>
                    <a href="{{ route('admin.missioni.index') }}"
                       class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-400 hover:text-admin-text hover:bg-white/5">Annulla</a>
                </div>
            </form>
        </div>
    </div>
@endsection
