@extends('admin.layouts.app')

@section('title', 'Modifica Immagine')
@section('page_title', 'Modifica Immagine')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.galleria.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 hover:text-[#22D3EE]" style="color: #9CA3AF;">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
            <form method="POST" action="{{ route('admin.galleria.update', $galleriaCorpo) }}" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="corpo_celeste_id" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Corpo Celeste <span style="color: #EF4444;">*</span></label>
                    <select name="corpo_celeste_id" id="corpo_celeste_id" required
                            class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                            style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                            onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                            onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        <option value="">— Seleziona un corpo celeste —</option>
                        @foreach ($corpi as $corpo)
                            <option value="{{ $corpo->id }}" {{ old('corpo_celeste_id', $galleriaCorpo->corpo_celeste_id) == $corpo->id ? 'selected' : '' }}>
                                {{ $corpo->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('corpo_celeste_id')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Immagine attuale</label>
                    <div class="rounded-lg overflow-hidden mb-3" style="max-width: 300px; border: 1px solid rgba(34, 211, 238, 0.1);">
                        <img loading="lazy" src="{{ $galleriaCorpo->percorso_url }}"
                             alt="{{ $galleriaCorpo->didascalia ?? 'Immagine' }}"
                             class="w-full h-auto">
                    </div>
                    <label for="percorso" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Sostituisci immagine</label>
                    <input type="file" name="percorso" id="percorso" accept="image/jpeg,image/png,image/webp"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    <p class="mt-1 text-xs" style="color: #6B7280;">Lascia vuoto per mantenere l'immagine corrente. Max 2MB. Formati: JPG, PNG, WebP.</p>
                    @error('percorso')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="didascalia" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Didascalia</label>
                    <input type="text" name="didascalia" id="didascalia" value="{{ old('didascalia', $galleriaCorpo->didascalia) }}"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('didascalia')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="crediti" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Crediti</label>
                    <input type="text" name="crediti" id="crediti" value="{{ old('crediti', $galleriaCorpo->crediti) }}" placeholder="es. NASA / JPL"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('crediti')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="ordine" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Ordine</label>
                    <input type="number" name="ordine" id="ordine" value="{{ old('ordine', $galleriaCorpo->ordine) }}" min="0" max="9999"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    <p class="mt-1 text-xs" style="color: #6B7280;">Ordine di visualizzazione (dal più piccolo al più grande)</p>
                    @error('ordine')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[#1BB8D1]"
                            style="background-color: #22D3EE; color: #0A0A1A;">
                        Aggiorna Immagine
                    </button>
                    <a href="{{ route('admin.galleria.index') }}"
                       class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:text-[#F0F0FA] hover:bg-[rgba(255,255,255,0.05)]"
                       style="color: #9CA3AF;">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
