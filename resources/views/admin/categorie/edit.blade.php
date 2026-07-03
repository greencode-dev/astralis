@extends('admin.layouts.app')

@section('title', 'Modifica Categoria')
@section('page_title', 'Modifica Categoria')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.categorie.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150" style="color: #9CA3AF;" onmouseover="this.style.color='#22D3EE';" onmouseout="this.style.color='#9CA3AF';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
            <form method="POST" action="{{ route('admin.categorie.update', $categoria) }}">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="nome" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Nome <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="nome" id="nome" value="{{ old('nome', $categoria->nome) }}" required
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('nome')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="icona" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Icona (emoji)</label>
                    <input type="text" name="icona" id="icona" value="{{ old('icona', $categoria->icona) }}" placeholder="es. 🌍"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('icona')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="colore" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Colore (hex)</label>
                    <div class="flex gap-3">
                        <input type="color" name="colore" id="colore" value="{{ old('colore', $categoria->colore ?? '#22D3EE') }}"
                               class="h-10 w-16 rounded-lg cursor-pointer"
                               style="background-color: #0A0A1A; border: 1px solid rgba(34, 211, 238, 0.2);">
                        <input type="text" name="colore_hex" id="colore_hex" value="{{ old('colore', $categoria->colore ?? '#22D3EE') }}" placeholder="#22D3EE"
                               class="flex-1 px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2); font-family: monospace;"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach (['#22D3EE', '#A855F7', '#F97316', '#FACC15', '#22C55E', '#EF4444', '#F472B6', '#94A3B8', '#78716C', '#6B7280'] as $c)
                            <button type="button"
                                    class="w-8 h-8 rounded-full border-2 transition-all duration-150"
                                    style="background-color: {{ $c }}; border-color: {{ old('colore', $categoria->colore) === $c ? '#F0F0FA' : 'transparent' }};"
                                    onclick="document.getElementById('colore').value='{{ $c }}'; document.getElementById('colore_hex').value='{{ $c }}';"
                                    onmouseover="this.style.transform='scale(1.15)';"
                                    onmouseout="this.style.transform='scale(1)';"></button>
                        @endforeach
                    </div>
                    <p class="mt-1 text-xs" style="color: #6B7280;">Il colore del badge associato alla categoria</p>
                    @error('colore')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="descrizione" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" rows="4"
                              class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                              style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                              onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                              onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">{{ old('descrizione', $categoria->descrizione) }}</textarea>
                    @error('descrizione')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200"
                            style="background-color: #22D3EE; color: #0A0A1A;"
                            onmouseover="this.style.backgroundColor='#1BB8D1';"
                            onmouseout="this.style.backgroundColor='#22D3EE';">
                        Aggiorna Categoria
                    </button>
                    <a href="{{ route('admin.categorie.index') }}"
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

@push('scripts')
<script>
    document.getElementById('colore').addEventListener('input', function() {
        document.getElementById('colore_hex').value = this.value;
    });
    document.getElementById('colore_hex').addEventListener('input', function() {
        document.getElementById('colore').value = this.value;
    });
</script>
@endpush
