<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Mi perfil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-cream text-text min-h-screen flex flex-col">

    <nav class="flex justify-between items-center px-8 py-5 bg-dark border-b border-darker">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-peach">🎸 Bandicalia</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('profile.show') }}" class="text-peach font-semibold hover:text-coral transition">Mi perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg border border-muted text-cream hover:border-coral hover:text-coral transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <main class="flex-1 px-8 py-10 max-w-4xl mx-auto w-full">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold text-text">Mi perfil</h1>
            <a href="{{ route('profile.edit') }}"
               class="bg-red hover:bg-coral text-cream rounded-xl px-6 py-2 font-semibold transition">
                ✏️ Editar perfil
            </a>
        </div>

        @if(session('status') === 'profile-updated')
            <div class="bg-peach text-text px-4 py-3 rounded-lg mb-6 border border-coral">
                ✅ Perfil actualizado correctamente.
            </div>
        @endif

        <!-- Información básica -->
        <div class="bg-white border border-peach rounded-2xl p-6 flex flex-col gap-4 mb-6 shadow-sm">
            <h2 class="text-xl font-semibold text-red">Información básica</h2>

            <div class="flex items-center gap-6">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}"
                         class="w-24 h-24 rounded-full object-cover border-2 border-coral">
                @else
                    <div class="w-24 h-24 rounded-full bg-peach flex items-center justify-center text-4xl border-2 border-coral">
                        🎵
                    </div>
                @endif
                <div>
                    <p class="text-2xl font-bold text-text">{{ $user->username }}</p>
                    @if($user->full_name)
                        <p class="text-muted">{{ $user->full_name }}</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <div>
                    <p class="text-sm text-muted">Email</p>
                    <p class="text-text">{{ $user->email }}</p>
                </div>
                @if($user->city)
                <div>
                    <p class="text-sm text-muted">Ciudad</p>
                    <p class="text-text">{{ $user->city }}</p>
                </div>
                @endif
                @if($user->age)
                <div>
                    <p class="text-sm text-muted">Edad</p>
                    <p class="text-text">{{ $user->age }} años</p>
                </div>
                @endif
                <div>
                    <p class="text-sm text-muted">Nivel general</p>
                    <p class="text-text">
                        {{ $user->general_level }} —
                        {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$user->general_level ?? 1] }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-muted">En una banda</p>
                    <p class="text-text">{{ $user->has_band ? '✅ Sí' : '❌ No' }}</p>
                </div>
            </div>

            @if($user->bio)
            <div>
                <p class="text-sm text-muted mb-1">Biografía</p>
                <p class="text-text">{{ $user->bio }}</p>
            </div>
            @endif
        </div>

        <!-- Géneros -->
        @if($user->genres->isNotEmpty())
        <div class="bg-white border border-peach rounded-2xl p-6 mb-6 shadow-sm">
            <h2 class="text-xl font-semibold text-red mb-4">Géneros musicales</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($user->genres as $genre)
                    <span class="bg-peach text-text px-3 py-1 rounded-full text-sm border border-coral">
                        {{ $genre->name }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Instrumentos -->
        @if($user->instruments->isNotEmpty())
        <div class="bg-white border border-peach rounded-2xl p-6 shadow-sm">
            <h2 class="text-xl font-semibold text-red mb-4">Instrumentos</h2>
            <div class="flex flex-col gap-3">
                @foreach($user->instruments as $instrument)
                    <div class="flex items-center justify-between">
                        <span class="text-text">{{ $instrument->name }}</span>
                        <span class="bg-cream text-text border border-peach px-3 py-1 rounded-lg text-sm">
                            Nivel {{ $instrument->pivot->level }} —
                            {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$instrument->pivot->level] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </main>

    <footer class="text-center text-muted py-6 text-sm bg-dark">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>