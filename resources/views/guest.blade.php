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
    <title>{{ config('app.name', 'Astralis') }} — Esplora l'Universo</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link rel="preconnect" href="https://images-assets.nasa.gov">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/js/guest/main.jsx', 'resources/css/app.css'])
</head>
<body class="font-sans antialiased bg-admin-bg text-admin-text">
    <div id="guest-root"></div>
</body>
</html>