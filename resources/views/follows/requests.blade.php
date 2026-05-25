<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Bandicalia — Solicitudes</title>
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
        <h1 class="text-3xl font-bold mb-8 text-text">Solicitudes de seguimiento</h1>

        @if($requests->isEmpty())
            <p class="text-muted">No tienes solicitudes pendientes.</p>
        @else
            <div class="flex flex-col gap-4">
                @foreach($requests as $requester)
                    <div class="bg-white border border-peach rounded-2xl p-4 flex items-center justify-between shadow-sm">
                        <a href="{{ route('musician.show', $requester->username) }}"
                           class="flex items-center gap-4 hover:opacity-80 transition">
                            @if($requester->photo)
                                <img src="{{ Storage::url($requester->photo) }}"
                                     class="w-14 h-14 rounded-full object-cover border-2 border-coral">
                            @else
                                <div class="w-14 h-14 rounded-full bg-peach flex items-center justify-center text-2xl border-2 border-coral">🎵</div>
                            @endif
                            <p class="font-bold text-lg text-text">{{ $requester->username }}</p>
                        </a>

                        <div class="flex gap-2">
                            <form method="POST" action="{{ route('follow.accept', $requester) }}">
                                @csrf
                                <button class="px-4 py-2 bg-red hover:bg-coral text-cream rounded-lg text-sm font-semibold transition">
                                    ✅ Aceptar
                                </button>
                            </form>
                            <form method="POST" action="{{ route('follow.unfollow', $requester) }}">
                                @csrf
                                <button class="px-4 py-2 border border-muted text-muted hover:border-red hover:text-red rounded-lg text-sm transition">
                                    ❌ Rechazar
                                </button>
                            </form>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </main>

    <footer class="text-center text-muted py-6 text-sm bg-dark">© 2026 Bandicalia — TFG</footer>
</body>
</html>