<section class="space-y-6">
    <header>
        <h3 class="text-lg font-semibold text-admin-text">Aggiorna Password</h3>
        <p class="text-sm mt-1 text-gray-400">Assicurati di usare una password lunga e sicura.</p>
    </header>

    <form method="POST" action="{{ route('password.update') }}" class="space-y-4">
        @csrf
        @method('put')

        <div>
            <label for="current_password" class="block text-sm font-medium mb-2 text-admin-dim">Password Attuale</label>
            <input id="current_password" type="password" name="current_password" required autocomplete="current-password"
                   class="admin-input">
            @error('current_password')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2 text-admin-dim">Nuova Password</label>
            <input id="password" type="password" name="password" required autocomplete="new-password"
                   class="admin-input">
            @error('password')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password_confirmation" class="block text-sm font-medium mb-2 text-admin-dim">Conferma Password</label>
            <input id="password_confirmation" type="password" name="password_confirmation" required autocomplete="new-password"
                   class="admin-input">
            @error('password_confirmation')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="admin-btn-primary">
                Salva
            </button>

            @if (session('status') === 'password-updated')
                <p class="text-sm text-green-500">Salvato.</p>
            @endif
        </div>
    </form>
</section>
