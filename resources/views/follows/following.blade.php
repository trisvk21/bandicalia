<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bandicalia — Siguiendo</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream text-text min-h-screen flex flex-col">

    <nav class="flex justify-between items-center px-8 py-5 bg-dark border-b border-darker">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-peach">🎸 Bandicalia</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('profile.show') }}" class="text-peach font-semibold hover:text-coral transition">Mi perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="px-4 py-2 rounded-lg border border-muted text-cream hover:border-coral hover:text-coral transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <main class="flex-1 px-8 py-10 max-w-4xl mx-auto w-full">
        <h1 class="text-3xl font-bold mb-8 text-text">Músicos que sigues</h1>

        @if($following->isEmpty())
            <p class="text-muted">Aún no sigues a nadie.</p>
        @else
            <div class="flex flex-col gap-4">
                @foreach($following as $musician)
                    <a href="{{ route('musician.show', $musician->username) }}"
                       class="bg-white border border-peach rounded-2xl p-4 flex items-center gap-4 hover:border-coral hover:shadow-md transition">

                        @if($musician->photo)
                            <img src="{{ Storage::url($musician->photo) }}"
                                 class="w-14 h-14 rounded-full object-cover border-2 border-coral">
                        @else
                            <div class="w-14 h-14 rounded-full bg-peach flex items-center justify-center text-2xl border-2 border-coral">
                                🎵
                            </div>
                        @endif

                        <div>
                            <p class="font-bold text-lg text-text">{{ $musician->username }}</p>
                            @if($musician->city)
                                <p class="text-muted text-sm">📍 {{ $musician->city }}</p>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="text-center text-muted py-6 text-sm bg-dark">© 2026 Bandicalia — TFG</footer>
</body>
</html>