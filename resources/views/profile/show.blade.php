<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Mi perfil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-8 py-5 bg-gray-900 border-b border-gray-800">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-400">🎸 Bandicalia</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('profile.show') }}" class="text-indigo-400 font-semibold">Mi perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg border border-gray-600 hover:border-red-400 hover:text-red-400 transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <main class="flex-1 px-8 py-10 max-w-4xl mx-auto w-full">

        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold">Mi perfil</h1>
            <a href="{{ route('profile.edit') }}"
               class="bg-indigo-500 hover:bg-indigo-600 rounded-xl px-6 py-2 font-semibold transition">
                ✏️ Editar perfil
            </a>
        </div>

        @if(session('status') === 'profile-updated')
            <div class="bg-green-800 text-green-200 px-4 py-3 rounded-lg mb-6">
                ✅ Perfil actualizado correctamente.
            </div>
        @endif

        <!-- Información básica -->
        <div class="bg-gray-900 rounded-2xl p-6 flex flex-col gap-4 mb-6">
            <h2 class="text-xl font-semibold text-indigo-400">Información básica</h2>

            <div class="flex items-center gap-6">
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}"
                         class="w-24 h-24 rounded-full object-cover border-2 border-indigo-500">
                @else
                    <div class="w-24 h-24 rounded-full bg-gray-700 flex items-center justify-center text-4xl">
                        🎵
                    </div>
                @endif
                <div>
                    <p class="text-2xl font-bold">{{ $user->username }}</p>
                    @if($user->full_name)
                        <p class="text-gray-400">{{ $user->full_name }}</p>
                    @endif
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mt-2">
                <div>
                    <p class="text-sm text-gray-400">Email</p>
                    <p class="text-white">{{ $user->email }}</p>
                </div>
                @if($user->city)
                <div>
                    <p class="text-sm text-gray-400">Ciudad</p>
                    <p class="text-white">{{ $user->city }}</p>
                </div>
                @endif
                @if($user->age)
                <div>
                    <p class="text-sm text-gray-400">Edad</p>
                    <p class="text-white">{{ $user->age }} años</p>
                </div>
                @endif
                <div>
                    <p class="text-sm text-gray-400">Nivel general</p>
                    <p class="text-white">
                        {{ $user->general_level }} —
                        {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$user->general_level ?? 1] }}
                    </p>
                </div>
                <div>
                    <p class="text-sm text-gray-400">En una banda</p>
                    <p class="text-white">{{ $user->has_band ? '✅ Sí' : '❌ No' }}</p>
                </div>
            </div>

            @if($user->bio)
            <div>
                <p class="text-sm text-gray-400 mb-1">Biografía</p>
                <p class="text-gray-300">{{ $user->bio }}</p>
            </div>
            @endif
        </div>

        <!-- Géneros -->
        @if($user->genres->isNotEmpty())
        <div class="bg-gray-900 rounded-2xl p-6 mb-6">
            <h2 class="text-xl font-semibold text-indigo-400 mb-4">Géneros musicales</h2>
            <div class="flex flex-wrap gap-2">
                @foreach($user->genres as $genre)
                    <span class="bg-indigo-900 text-indigo-200 px-3 py-1 rounded-full text-sm">
                        {{ $genre->name }}
                    </span>
                @endforeach
            </div>
        </div>
        @endif

        <!-- Instrumentos -->
        @if($user->instruments->isNotEmpty())
        <div class="bg-gray-900 rounded-2xl p-6">
            <h2 class="text-xl font-semibold text-indigo-400 mb-4">Instrumentos</h2>
            <div class="flex flex-col gap-3">
                @foreach($user->instruments as $instrument)
                    <div class="flex items-center justify-between">
                        <span class="text-gray-300">{{ $instrument->name }}</span>
                        <span class="bg-gray-800 text-indigo-300 px-3 py-1 rounded-lg text-sm">
                            Nivel {{ $instrument->pivot->level }} —
                            {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$instrument->pivot->level] }}
                        </span>
                    </div>
                @endforeach
            </div>
        </div>
        @endif

    </main>

    <footer class="text-center text-gray-600 py-6 text-sm">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>