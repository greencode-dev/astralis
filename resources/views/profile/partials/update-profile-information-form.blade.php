<section class="space-y-6">
    <header>
        <h3 class="text-lg font-semibold" style="color: #F0F0FA;">Informazioni Profilo</h3>
        <p class="text-sm mt-1" style="color: #9CA3AF;">Aggiorna le informazioni del tuo account.</p>
    </header>

    <form method="POST" action="{{ route('profile.update') }}" class="space-y-4">
        @csrf
        @method('patch')

        <div>
            <label for="name" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Nome</label>
            <input id="name" type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required autofocus autocomplete="name"
                   class="w-full px-4 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                   style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                   onfocus="this.style.borderColor='#22D3EE'"
                   onblur="this.style.borderColor='rgba(34,211,238,0.2)'">
            @error('name')
                <p class="mt-2 text-sm" style="color: #F97316;">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label for="email" class="block text-sm font-medium mb-2" style="color: #B8B8D0;">Email</label>
            <input id="email" type="email" name="email" value="{{ old('email', Auth::user()->email) }}" required autocomplete="username"
                   class="w-full px-4 py-3 rounded-lg text-sm focus:outline-none focus:ring-2 transition-all duration-200"
                   style="background-color: #0A0A1A; color: #F0F0FA; border: 1px solid rgba(34, 211, 238, 0.2);"
                   onfocus="this.style.borderColor='#22D3EE'"
                   onblur="this.style.borderColor='rgba(34,211,238,0.2)'">
            @error('email')
                <p class="mt-2 text-sm" style="color: #F97316;">{{ $message }}</p>
            @enderror

            @if (Auth::user() instanceof \Illuminate\Contracts\Auth\MustVerifyEmail && ! Auth::user()->hasVerifiedEmail())
                <div class="mt-2">
                    <p class="text-sm" style="color: #9CA3AF;">
                        Il tuo indirizzo email non è verificato.
                        <form method="POST" action="{{ route('verification.send') }}" class="inline">
                            @csrf
                            <button type="submit" class="text-sm font-medium hover:underline" style="color: #22D3EE;">
                                Clicca qui per reinviare la verifica.
                            </button>
                        </form>
                    </p>
                    @if (session('status') === 'verification-link-sent')
                        <p class="mt-1 text-sm" style="color: #22C55E;">Un nuovo link di verifica è stato inviato al tuo indirizzo email.</p>
                    @endif
                </div>
            @endif
        </div>

        <div class="flex items-center gap-4">
            <button type="submit"
                    class="py-3 px-4 rounded-lg text-sm font-bold transition-all duration-200"
                    style="background-color: #22D3EE; color: #0A0A1A;"
                    onmouseover="this.style.backgroundColor='#1BBFE0'"
                    onmouseout="this.style.backgroundColor='#22D3EE'">
                Salva
            </button>

            @if (session('status') === 'profile-updated')
                <p class="text-sm" style="color: #22C55E;">Salvato.</p>
            @endif
        </div>
    </form>
</section>
