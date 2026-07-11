<x-guest-layout>
    <div class="space-y-6">
        <h2 class="text-2xl font-bold text-center text-admin-text">Verifica email</h2>

        <p class="text-sm text-center text-admin-chart-text">
            Grazie per esserti registrato! Prima di iniziare, verifica il tuo indirizzo email cliccando sul link che ti abbiamo inviato.
        </p>

        @if (session('status') == 'verification-link-sent')
            <p class="text-sm text-center text-admin-success">
                Un nuovo link di verifica è stato inviato al tuo indirizzo email.
            </p>
        @endif

        <div class="flex items-center justify-between">
            <form method="POST" action="{{ route('verification.send') }}">
                @csrf
                <button type="submit"
                        class="admin-btn-primary">
                    Reinvia email di verifica
                </button>
            </form>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit"
                        class="admin-btn-cancel border border-admin-primary/20">
                    Esci
                </button>
            </form>
        </div>
    </div>
</x-guest-layout>
