@php $coloreValue = $coloreValue ?? '#22D3EE'; @endphp
<div class="mb-5">
    <label for="colore" class="block text-sm font-medium mb-2 text-admin-text">Colore (hex)</label>
    <div class="flex gap-3">
        <input type="color" name="colore" id="colore" value="{{ old('colore', $coloreValue) }}"
               class="h-10 w-16 rounded-lg cursor-pointer bg-admin-bg border border-admin-primary/20">
        <input type="text" name="colore_hex" id="colore_hex" value="{{ old('colore', $coloreValue) }}" placeholder="#22D3EE"
               class="flex-1 admin-input-mono">
    </div>
    <div class="flex flex-wrap gap-2 mt-3">
        @foreach (config('admin.color_presets') as $c)
            <button type="button"
                    class="w-8 h-8 rounded-full border-2 transition-all duration-150 hover:scale-110"
                    style="background-color: {{ $c }}; border-color: {{ old('colore', $coloreValue) === $c ? 'var(--color-admin-text)' : 'transparent' }};"
                    onclick="document.getElementById('colore').value='{{ $c }}'; document.getElementById('colore_hex').value='{{ $c }}'; this.style.borderColor='var(--color-admin-text)';"
                    aria-label="Seleziona colore {{ $c }}"></button>
        @endforeach
    </div>
    <p class="mt-1 text-xs text-gray-500">Il colore del badge associato alla categoria</p>
    @error('colore')
        <p class="mt-1 text-sm text-red-500">{{ $message }}</p>
    @enderror
</div>
