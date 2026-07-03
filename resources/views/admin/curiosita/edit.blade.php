@extends('admin.layouts.app')

@section('title', 'Modifica Curiosità')
@section('page_title', 'Modifica Curiosità')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.curiosita.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150" style="color: #9CA3AF;" onmouseover="this.style.color='#22D3EE';" onmouseout="this.style.color='#9CA3AF';">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
            <form method="POST" action="{{ route('admin.curiosita.update', $curiositum) }}">
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
                            <option value="{{ $corpo->id }}" {{ old('corpo_celeste_id', $curiositum->corpo_celeste_id) == $corpo->id ? 'selected' : '' }}>
                                {{ $corpo->nome }}
                            </option>
                        @endforeach
                    </select>
                    @error('corpo_celeste_id')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="titolo" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Titolo <span style="color: #EF4444;">*</span></label>
                    <input type="text" name="titolo" id="titolo" value="{{ old('titolo', $curiositum->titolo) }}" required
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('titolo')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="descrizione" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Descrizione <span style="color: #EF4444;">*</span></label>
                    <textarea name="descrizione" id="descrizione" rows="6"
                              class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                              style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                              onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                              onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">{{ old('descrizione', $curiositum->descrizione) }}</textarea>
                    @error('descrizione')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="fonte" class="block text-sm font-medium mb-2" style="color: #F0F0FA;">Fonte</label>
                    <input type="text" name="fonte" id="fonte" value="{{ old('fonte', $curiositum->fonte) }}" placeholder="es. NASA, Wikipedia, ..."
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('fonte')
                        <p class="mt-1 text-sm" style="color: #EF4444;">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200"
                            style="background-color: #22D3EE; color: #0A0A1A;"
                            onmouseover="this.style.backgroundColor='#1BB8D1';"
                            onmouseout="this.style.backgroundColor='#22D3EE';">
                        Aggiorna Curiosità
                    </button>
                    <a href="{{ route('admin.curiosita.index') }}"
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
