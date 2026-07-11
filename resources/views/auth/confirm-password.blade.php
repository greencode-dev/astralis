<x-guest-layout>
    <form method="POST" action="{{ route('password.confirm') }}" class="space-y-6">
        @csrf

        <h2 class="text-2xl font-bold text-center text-admin-text">Conferma password</h2>

        <p class="text-sm text-center text-gray-400">
            Questa è un'area protetta. Conferma la tua password per continuare.
        </p>

        <div>
            <label for="password" class="block text-sm font-medium mb-2 text-admin-dim">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="admin-input" placeholder="La tua password">
            @error('password')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <button type="submit" class="admin-btn-primary w-full py-3">
            Conferma
        </button>
    </form>
</x-guest-layout>
