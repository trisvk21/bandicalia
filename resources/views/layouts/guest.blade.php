<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Bandicalia') }}</title>
        <link rel="icon" type="image/svg+xml" href="/favicon.svg">
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    </head>
    <body class="font-sans antialiased min-h-screen bg-darker flex flex-col items-center justify-center px-4">

        <!-- Logo -->
        <a href="{{ route('landing') }}" class="font-serif font-extrabold text-brand tracking-tight text-3xl mb-8 hover:text-coral transition">
            BANDICALIA
        </a>

        <!-- Card -->
        <div class="w-full max-w-md bg-dark border border-peach/20 rounded-2xl px-8 py-8 shadow-2xl">
            {{ $slot }}
        </div>

        <p class="mt-6 text-white/20 text-xs">© 2026 Bandicalia — TFG</p>

    </body>
</html>