@extends('admin.layouts.app')

@section('title', 'Nuova Curiosità')
@section('page_title', 'Nuova Curiosità')

@section('content')
    <div class="max-w-2xl">
        <a href="{{ route('admin.curiosita.index') }}" class="inline-flex items-center gap-2 text-sm mb-6 transition-colors duration-150 text-gray-400 hover:text-admin-primary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
            Torna alla lista
        </a>

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.curiosita.store') }}">
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
                    <label for="titolo" class="block text-sm font-medium mb-2 text-admin-text">Titolo <span class="text-red-500">*</span></label>
                    <input type="text" name="titolo" id="titolo" value="{{ old('titolo') }}" required
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('titolo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione <span class="text-red-500">*</span></label>
                    <textarea name="descrizione" id="descrizione" rows="6"
                              class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                              style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                              onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                              onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">{{ old('descrizione') }}</textarea>
                    @error('descrizione')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="fonte" class="block text-sm font-medium mb-2 text-admin-text">Fonte</label>
                    <input type="text" name="fonte" id="fonte" value="{{ old('fonte') }}" placeholder="es. NASA, Wikipedia, ..."
                           class="w-full px-4 py-2.5 rounded-lg text-sm transition-all duration-200"
                           style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                           onfocus="this.style.borderColor='#22D3EE'; this.style.boxShadow='0 0 0 3px rgba(34,211,238,0.1)';"
                           onblur="this.style.borderColor='rgba(34,211,238,0.2)'; this.style.boxShadow='none';">
                    @error('fonte')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 bg-admin-primary text-admin-bg hover:bg-[#1BB8D1]">
                        Salva Curiosità
                    </button>
                    <a href="{{ route('admin.curiosita.index') }}"
                       class="px-6 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 text-gray-400 hover:text-admin-text hover:bg-white/5">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
