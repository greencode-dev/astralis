<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Astralis') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700|orbitron:400,500,600,700,800,900&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-admin-bg text-admin-text">
    <div class="flex flex-col items-center justify-center min-h-screen px-4">
        <div class="w-full max-w-md">
            <div class="mb-8 text-center">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                    <img src="/favicon.svg" alt="Astralis" class="w-24 h-24" />
                    <span class="text-2xl font-bold font-orbitron text-admin-primary">Astralis</span>
                </a>
            </div>
            <div class="p-8 border rounded-xl bg-admin-card border-admin-primary/10">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
