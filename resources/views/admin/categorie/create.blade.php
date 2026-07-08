@extends('admin.layouts.app')

@section('title', 'Nuova Categoria')
@section('page_title', 'Nuova Categoria')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.categorie.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 text-gray-400 hover:text-admin-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.categorie.store') }}">
                @csrf

                <div class="mb-5">
                    <label for="nome" class="block text-sm font-medium mb-2 text-admin-text">Nome <span class="text-red-500">*</span></label>
                    <input type="text" name="nome" id="nome" value="{{ old('nome') }}" required
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('nome')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="icona" class="block text-sm font-medium mb-2 text-admin-text">Icona (emoji)</label>
                    <input type="text" name="icona" id="icona" value="{{ old('icona') }}" placeholder="es. 🌍"
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('icona')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="colore" class="block text-sm font-medium mb-2 text-admin-text">Colore (hex)</label>
                    <div class="flex gap-3">
                        <input type="color" name="colore" id="colore" value="{{ old('colore', '#22D3EE') }}"
                               class="h-10 w-16 rounded-lg cursor-pointer bg-admin-bg border border-admin-primary/20">
                        <input type="text" name="colore_hex" id="colore_hex" value="{{ old('colore', '#22D3EE') }}" placeholder="#22D3EE"
                               class="flex-1 px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                               style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2); font-family: monospace;"
                               onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                               onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    </div>
                    <div class="flex flex-wrap gap-2 mt-3">
                        @foreach (['#22D3EE', '#A855F7', '#F97316', '#FACC15', '#22C55E', '#EF4444', '#F472B6', '#94A3B8', '#78716C', '#6B7280'] as $c)
                            <button type="button"
                                    class="w-8 h-8 rounded-full border-2 transition-all duration-150 hover:scale-110"
                                    style="background-color: {{ $c }}; border-color: {{ old('colore', '#22D3EE') === $c ? '#F0F0FA' : 'transparent' }};"
                                    onclick="document.getElementById('colore').value='{{ $c }}'; document.getElementById('colore_hex').value='{{ $c }}'; this.style.borderColor='#F0F0FA';"
                                    aria-label="Seleziona colore {{ $c }}"></button>
                        @endforeach
                    </div>
                    <p class="mt-1 text-xs text-gray-500">Il colore del badge associato alla categoria</p>
                    @error('colore')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione</label>
                    <textarea name="descrizione" id="descrizione" rows="4"
                              class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                              style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                              onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                              onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">{{ old('descrizione') }}</textarea>
                    @error('descrizione')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:bg-[#1BB8D1]">
                        Salva Categoria
                    </button>
                    <a href="{{ route('admin.categorie.index') }}"
                       class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-400 hover:text-admin-text hover:bg-white/5">
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
