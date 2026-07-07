<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Astralis') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css'])
</head>
<body class="font-sans antialiased" style="background-color: #0A0A1A; color: #F0F0FA;">
    <div class="min-h-screen flex flex-col items-center justify-center px-4">
        <div class="w-full max-w-md">
            <div class="text-center mb-8">
                <a href="{{ route('home') }}" class="inline-flex items-center gap-2">
                    <span class="text-3xl">🚀</span>
                    <span class="text-2xl font-bold" style="color: #22D3EE;">Astralis</span>
                </a>
            </div>
            <div class="rounded-xl p-8" style="background-color: #111128; border: 1px solid rgba(34, 211, 238, 0.1);">
                {{ $slot }}
            </div>
        </div>
    </div>
</body>
</html>
