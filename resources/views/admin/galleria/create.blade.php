@extends('admin.layouts.app')

@section('title', 'Nuova Immagine')
@section('page_title', 'Nuova Immagine')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.galleria.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 hover:text-[#22D3EE] text-gray-400">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.galleria.store') }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-5">
                    <label for="corpo_celeste_id" class="block text-sm font-medium mb-2 text-admin-text">Corpo Celeste <span class="text-red-500">*</span></label>
                    <select name="corpo_celeste_id" id="corpo_celeste_id" required
                            class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                            style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                            onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                            onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                        <option value="">— Seleziona un corpo celeste —</option>
                        @foreach ($corpi as $corpo)
                            <option value="{{ $corpo->id }}" {{ old('corpo_celeste_id') == $corpo->id ? 'selected' : '' }}>
                                {{ $corpo->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('corpo_celeste_id')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="percorso" class="block text-sm font-medium mb-2 text-admin-text">Immagine <span class="text-red-500">*</span></label>
                    <input type="file" name="percorso" id="percorso" accept="image/jpeg,image/png,image/webp" required
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:text-xs file:font-medium file:border-0"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    <p class="mt-1 text-xs text-gray-500">Max 2MB. Formati: JPG, PNG, WebP. Verrà ridimensionata a 1200px.</p>
                    @error('percorso')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="didascalia" class="block text-sm font-medium mb-2 text-admin-text">Didascalia</label>
                    <input type="text" name="didascalia" id="didascalia" value="{{ old('didascalia') }}"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('didascalia')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="crediti" class="block text-sm font-medium mb-2 text-admin-text">Crediti</label>
                    <input type="text" name="crediti" id="crediti" value="{{ old('crediti') }}" placeholder="es. NASA / JPL"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('crediti')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="ordine" class="block text-sm font-medium mb-2 text-admin-text">Ordine</label>
                    <input type="number" name="ordine" id="ordine" value="{{ old('ordine', 0) }}" min="0" max="9999"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    <p class="mt-1 text-xs text-gray-500">Ordine di visualizzazione (dal più piccolo al più grande)</p>
                    @error('ordine')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:bg-[#1BB8D1] bg-admin-primary text-admin-bg">
                        Salva Immagine
                    </button>
                    <a href="{{ route('admin.galleria.index') }}"
                       class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:text-[#F0F0FA] hover:bg-[rgba(255,255,255,0.05)] text-gray-400">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
