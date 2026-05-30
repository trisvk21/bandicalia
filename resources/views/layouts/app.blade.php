<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Bandicalia') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">

    <style>
        :root {
            --beige:  #FFEDCE;
            --orange: #FFC193;
            --salmon: #FF8383;
            --red:    #FF3737;
            --dark:   #1a0a00;
            --mid:    #2e1500;
            --text:   #3d1f00;
            --muted:  #a0704a;
        }

        body {
            font-family: 'DM Sans', sans-serif;
            background-color: var(--beige);
            color: var(--text);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
        }

        body::before {
            content: '';
            position: fixed;
            inset: 0;
            background-image: url("data:image/svg+xml,%3Csvg viewBox='0 0 200 200' xmlns='http://www.w3.org/2000/svg'%3E%3Cfilter id='n'%3E%3CfeTurbulence type='fractalNoise' baseFrequency='0.75' numOctaves='4' stitchTiles='stitch'/%3E%3C/filter%3E%3Crect width='100%25' height='100%25' filter='url(%23n)' opacity='0.04'/%3E%3C/svg%3E");
            pointer-events: none;
            z-index: 0;
            opacity: .5;
        }

        main {
            flex: 1;
            position: relative;
            z-index: 1;
        }

        footer {
            text-align: center;
            padding: 1.25rem;
            font-size: .8rem;
            background: var(--dark);
            color: rgba(255,237,206,.35);
            border-top: 1px solid rgba(255,193,147,.15);
            position: relative;
            z-index: 1;
        }
    </style>
</head>
@stack('scripts')
<body class="font-sans antialiased">

    @include('layouts.navigation')

    <main>
        {{ $slot }}
    </main>

    <footer>
        {{ date('Y') }} Bandicalia — TFG
    </footer>

</body>
</html>