<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <link rel="icon" type="image/png" href="/favicon-96x96.png?v=20260714" sizes="96x96" />
    <link rel="icon" type="image/svg+xml" href="/favicon.svg?v=20260714" />
    <link rel="shortcut icon" href="/favicon.ico?v=20260714" />
    <link rel="apple-touch-icon" sizes="180x180" href="/apple-touch-icon.png?v=20260714" />
    <link rel="manifest" href="/site.webmanifest?v=20260714" />
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'Astralis') }} Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://images-assets.nasa.gov">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|orbitron:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/admin.js'])
</head>
<body class="font-sans antialiased bg-admin-bg text-admin-text">
    <a href="#main-content" class="sr-only focus:not-sr-only focus:absolute focus:z-50 focus:px-4 focus:py-2 focus:bg-admin-primary focus:text-admin-bg focus:rounded-lg focus:m-2">
        Vai al contenuto principale
    </a>
    <div class="flex h-screen overflow-hidden" x-data="{ sidebarOpen: false }">

        <aside class="fixed inset-y-0 left-0 z-40 shrink-0 w-64 overflow-y-auto transition-transform duration-300 -translate-x-full bg-admin-card border-r border-admin-primary/10 md:relative md:translate-x-0 md:inset-auto"
               :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
               @click.away="sidebarOpen = false">

            <div class="flex items-center gap-3 px-6 py-5 border-b border-admin-primary/10">
                <img src="/astralis_solo_logo_bianco.png" alt="Astralis" class="w-18 h-12" />
                <div>
                    <h1 class="text-lg font-bold font-orbitron text-admin-primary">Astralis</h1>
                    <p class="text-xs text-admin-secondary">Backoffice</p>
                </div>
            </div>

            @include('admin.partials._sidebar-nav')

            <div class="px-3 py-4 mt-auto space-y-1 border-t border-admin-primary/10">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-admin-dim transition-all duration-200 rounded-lg hover:bg-admin-primary/8 hover:text-admin-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profilo
                </a>
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium text-admin-dim transition-all duration-200 rounded-lg hover:bg-admin-primary/8 hover:text-admin-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Torna al sito
                </a>
            </div>
        </aside>

        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-6 py-5 border-b bg-admin-card border-admin-primary/10">
                <div class="flex items-center gap-3">
                    <button @click="sidebarOpen = !sidebarOpen"
                            class="p-2 text-admin-dim rounded-lg md:hidden hover:text-admin-primary hover:bg-admin-primary/10"
                            aria-label="Apri menu">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </button>
                    <h2 class="text-lg font-semibold">@yield('page_title', 'Dashboard')</h2>
                </div>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-admin-dim">{{ Auth::user()->name }}</span>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                                class="flex items-center gap-2 px-4 py-2 text-sm font-medium transition-all duration-200 rounded-lg text-admin-text bg-admin-accent/15 hover:bg-admin-accent/30">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                            Esci
                        </button>
                    </form>
                </div>
            </header>

            <main id="main-content" class="flex-1 p-3 sm:p-4 md:p-6 lg:p-8 overflow-y-auto">
                @isset($slot)
                    {{ $slot }}
                @else
                    @include('admin.partials.flash')
                    @yield('content')
                @endisset
            </main>
        </div>
    </div>
    <script>
    document.querySelectorAll('form[data-confirm]').forEach(function(form) {
        form.addEventListener('submit', function(e) {
            if (!confirm(form.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });
    window.__astralisImgFallback = function(el) {
        var name = el.getAttribute('data-nome') || 'non disponibile';
        el.alt = 'Immagine non disponibile';
        el.style.display = 'none';
        var div = document.createElement('div');
        div.setAttribute('role', 'img');
        div.setAttribute('aria-label', 'Immagine non disponibile per ' + name);
        div.style.cssText = 'display:flex;align-items:center;justify-content:center;height:100%;padding:1rem;text-align:center;color:var(--admin-neutral);font-size:0.75rem;';
        div.textContent = 'Immagine non disponibile';
        el.parentElement.appendChild(div);
    };
    </script>
    @stack('scripts')
</body>
</html>
