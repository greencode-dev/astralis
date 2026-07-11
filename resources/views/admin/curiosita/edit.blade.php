@extends('admin.layouts.app')

@section('title', 'Modifica Curiosità')
@section('page_title', 'Modifica Curiosità')

@section('content')
    <div class="max-w-2xl">
        @include('admin.partials.back-link', ['route' => 'admin.curiosita.index'])

        <div class="rounded-xl p-6 bg-admin-card border border-admin-primary/10">
            <form method="POST" action="{{ route('admin.curiosita.update', $curiositum) }}">
                @csrf
                @method('PUT')

                <div class="mb-5">
                    <label for="corpo_celeste_id" class="block text-sm font-medium mb-2 text-admin-text">Corpo Celeste <span class="text-red-500">*</span></label>
                    <select name="corpo_celeste_id" id="corpo_celeste_id" required
                            class="admin-input">
                        <option value="">— Seleziona un corpo celeste —</option>
                        @foreach ($corpi as $corpo)
                            <option value="{{ $corpo->id }}" {{ old('corpo_celeste_id', $curiositum->corpo_celeste_id) == $corpo->id ? 'selected' : '' }}>
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
                    <input type="text" name="titolo" id="titolo" value="{{ old('titolo', $curiositum->titolo) }}" required
                           class="admin-input">
                    @error('titolo')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-5">
                    <label for="descrizione" class="block text-sm font-medium mb-2 text-admin-text">Descrizione <span class="text-red-500">*</span></label>
                    <textarea name="descrizione" id="descrizione" rows="6"
                              class="admin-input">{{ old('descrizione', $curiositum->descrizione) }}</textarea>
                    @error('descrizione')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="mb-6">
                    <label for="fonte" class="block text-sm font-medium mb-2 text-admin-text">Fonte</label>
                    <input type="text" name="fonte" id="fonte" value="{{ old('fonte', $curiositum->fonte) }}" placeholder="es. NASA, Wikipedia, ..."
                           class="admin-input">
                    @error('fonte')
                        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center gap-3">
                    <button type="submit"
                            class="admin-btn-primary">
                        Aggiorna Curiosità
                    </button>
                    <a href="{{ route('admin.curiosita.index') }}"
                       class="admin-btn-cancel">
                        Annulla
                    </a>
                </div>
            </form>
        </div>
    </div>
@endsection
