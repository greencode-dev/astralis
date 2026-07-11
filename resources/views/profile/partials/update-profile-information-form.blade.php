<section class="space-y-6">
    <header>
        <h3 class="text-lg font-semibold text-admin-text">Informazioni Profilo</h3>
        <p class="text-sm mt-1 text-gray-400">Aggiorna le informazioni del tuo account.</p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium mb-2 text-admin-dim">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name"
                   class="admin-input">
            @error('name')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-2 text-admin-dim">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username"
                   class="admin-input">
            @error('email')
                <p class="mt-2 text-sm text-admin-accent">{{ $message }}</p>
            @enderror

            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm text-gray-400">
                        Il tuo indirizzo email non è verificato.
                        <form method="POST" action="{{ route('verification.send') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium hover:underline text-admin-primary">
                                Clicca qui per reinviare la verifica.
                            </button>
                        </form>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-sm text-green-500">Un nuovo link di verifica è stato inviato al tuo indirizzo email.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit" class="admin-btn-primary">
                Salva
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm text-green-500">Salvato.</p>
            @endif
        </div>
    </form>
</section>
