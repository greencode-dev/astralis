<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'Astralis') }} Admin</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://images-assets.nasa.gov">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
    <script defer src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="font-sans antialiased bg-admin-bg text-admin-text">
    <div class="flex h-screen overflow-hidden">

        <aside class="flex-shrink-0 w-64 overflow-y-auto bg-admin-card border-r border-admin-primary/10">

            <div class="flex items-center gap-3 px-6 py-5 border-b border-admin-primary/10">
                <span class="text-2xl">🚀</span>
                <div>
                    <h1 class="text-lg font-bold text-admin-primary">Astralis</h1>
                    <p class="text-xs text-admin-secondary">Backoffice</p>
                </div>
            </div>

            @php
                $navItems = [
                    ['route' => 'admin.dashboard', 'label' => 'Dashboard', 'icon' => 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
                    ['route' => 'admin.corpi-celesti.index', 'label' => 'Corpi Celesti', 'icon' => 'M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z'],
                    ['route' => 'admin.categorie.index', 'label' => 'Categorie', 'icon' => 'M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z'],
                    ['route' => 'admin.missioni.index', 'label' => 'Missioni', 'icon' => 'M3.055 11H5a2 2 0 012 2v1a2 2 0 002 2 2 2 0 012 2v2.945M8 3.935V5.5A2.5 2.5 0 0010.5 8h.5a2 2 0 012 2 2 2 0 104 0 2 2 0 012-2h1.064M15 20.488V18a2 2 0 012-2h3.064M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['route' => 'admin.curiosita.index', 'label' => 'Curiosità', 'icon' => 'M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
                    ['route' => 'admin.galleria.index', 'label' => 'Galleria', 'icon' => 'M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z'],
                    ['route' => 'admin.nasa-import.index', 'label' => 'NASA Import', 'icon' => 'M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15'],
                ];
                $currentRoute = request()->route()?->getName();
            @endphp

            <nav class="px-3 mt-4 space-y-1">
                @foreach ($navItems as $item)
                    @php
                        $isActive = $currentRoute && str_starts_with($currentRoute, explode('.', $item['route'])[0] . '.' . explode('.', $item['route'])[1]);
                        if ($item['route'] === 'admin.dashboard') {
                            $isActive = $currentRoute === 'admin.dashboard';
                        }
                    @endphp
                    <a href="{{ route($item['route']) }}"
                       @if ($isActive)
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all duration-200 rounded-lg bg-admin-primary/15 text-admin-primary"
                        @else
                            class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all duration-200 rounded-lg text-gray-400 hover:bg-admin-primary/8 hover:text-admin-primary"
                        @endif>
                        <svg class="flex-shrink-0 w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $item['icon'] }}"/>
                        </svg>
                        {{ $item['label'] }}
                    </a>
                @endforeach
            </nav>

            <div class="px-3 py-4 mt-auto space-y-1 border-t border-admin-primary/10">
                <a href="{{ route('profile.edit') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all duration-200 rounded-lg text-gray-400 hover:bg-admin-primary/8 hover:text-admin-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    Profilo
                </a>
                <a href="{{ route('home') }}"
                   class="flex items-center gap-3 px-4 py-3 text-sm font-medium transition-all duration-200 rounded-lg text-gray-400 hover:bg-admin-primary/8 hover:text-admin-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
                    Torna al sito
                </a>
            </div>
        </aside>

        <div class="flex flex-col flex-1 overflow-hidden">
            <header class="flex items-center justify-between px-6 py-5 bg-admin-card border-b border-admin-primary/10">
                <h2 class="text-lg font-semibold">@yield('page_title', 'Dashboard')</h2>
                <div class="flex items-center gap-4">
                    <span class="text-sm text-gray-400">{{ Auth::user()->name }}</span>
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

            <main class="flex-1 p-6 overflow-y-auto">
                @isset($slot)
                    {{ $slot }}
                @else
                    @yield('content')
                @endisset
            </main>
        </div>
    </div>
    @stack('scripts')
</body>
</html>
