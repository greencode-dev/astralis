<x-guest-layout>
    <form method="POST" action="{{ route('login') }}" class="space-y-6">
        @csrf

        <h2 class="text-2xl font-bold text-center text-admin-text">Accedi</h2>

        <div>
            <label for="email" class="block text-sm font-medium mb-2 text-admin-dim">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus autocomplete="username"
                   class="admin-input" placeholder="nome@esempio.it">
            @error('email')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="password" class="block text-sm font-medium mb-2 text-admin-dim">Password</label>
            <input id="password" type="password" name="password" required autocomplete="current-password"
                   class="admin-input" placeholder="La tua password">
            @error('password')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 text-sm text-admin-dim">
                <input type="checkbox" name="remember"
                       class="rounded border-admin-primary/30 bg-admin-bg">
                Ricordami
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm font-medium hover:underline text-admin-primary">
                    Password dimenticata?
                </a>
            @endif
        </div>

        <button type="submit" class="admin-btn-primary w-full py-3">
            Accedi
        </button>

        @if (Route::has('register'))
            <p class="text-center text-sm text-gray-400">
                Non hai un account?
                <a href="{{ route('register') }}" class="font-medium hover:underline text-admin-secondary">Registrati</a>
            </p>
        @endif
    </form>
</x-guest-layout>
