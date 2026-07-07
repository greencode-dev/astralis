<x-guest-layout>
    <div class="space-y-6">
        <h2 class="text-2xl font-bold text-center" style="color: #F0F0FA;">Verifica email</h2>

        <p class="text-sm text-center" style="color: #9CA3AF;">
            Grazie per esserti registrato! Prima di iniziare, verifica il tuo indirizzo email cliccando sul link che ti abbiamo inviato.
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="text-sm text-center" style="color: #22C55E;">
                Un nuovo link di verifica è stato inviato al tuo indirizzo email.
            </p>
        @endif

        <div class="flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="py-3 px-4 rounded-lg text-sm font-bold transition-all duration-200"
                        style="background-color: #22D3EE; color: #0A0A1A;"
                        onmouseover="this.style.backgroundColor='#1BBFE0'"
                        onmouseout="this.style.backgroundColor='#22D3EE'">
                    Reinvia email di verifica
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="py-3 px-4 rounded-lg text-sm font-medium transition-all duration-200"
                        style="color: #9CA3AF; border: 1px solid rgba(34, 211, 238, 0.2);"
                        onmouseover="this.style.color='#F97316'; this.style.borderColor='#F97316'"
                        onmouseout="this.style.color='#9CA3AF'; this.style.borderColor='rgba(34,211,238,0.2)'">
                    Esci
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
