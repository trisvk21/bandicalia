<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Buscar músicos</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-8 py-5 bg-gray-900 border-b border-gray-800">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-indigo-400">🎸 Bandicalia</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white transition">Mi perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg border border-gray-600 hover:border-red-400 hover:text-red-400 transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <main class="flex-1 px-8 py-10 max-w-7xl mx-auto w-full">

        <!-- Filtros -->
        <form method="GET" action="{{ route('home') }}" class="bg-gray-900 rounded-2xl p-6 mb-10 grid grid-cols-1 md:grid-cols-5 gap-4">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Usuario o nombre..."
                class="bg-gray-800 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
            <input
                type="text"
                name="city"
                value="{{ request('city') }}"
                placeholder="Ciudad..."
                class="bg-gray-800 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500"
            >
            <select name="genre" class="bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos los géneros</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
            <select name="instrument" class="bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                <option value="">Todos los instrumentos</option>
                @foreach($instruments as $instrument)
                    <option value="{{ $instrument->id }}" {{ request('instrument') == $instrument->id ? 'selected' : '' }}>
                        {{ $instrument->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 rounded-lg px-4 py-2 font-semibold transition">
                Buscar
            </button>
        </form>

        <!-- Resultados -->
        @if($musicians->isEmpty())
            <div class="text-center text-gray-500 py-20">
                <div class="text-5xl mb-4">🎵</div>
                <p class="text-xl">No se encontraron músicos con esos filtros.</p>
            </div>
        @else
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
                @foreach($musicians as $musician)
                    <a href="{{ route('profile.show', $musician->username) }}" class="bg-gray-900 rounded-2xl p-6 hover:bg-gray-800 transition flex flex-col gap-3">
                        <!-- Foto -->
                        <div class="flex items-center gap-4">
                            @if($musician->photo)
                                <img src="{{ Storage::url($musician->photo) }}" class="w-14 h-14 rounded-full object-cover">
                            @else
                                <div class="w-14 h-14 rounded-full bg-indigo-600 flex items-center justify-center text-2xl font-bold">
                                    {{ strtoupper(substr($musician->name, 0, 1)) }}
                                </div>
                            @endif
                            <div>
                                <p class="font-bold text-white">{{ $musician->full_name ?? $musician->name }}</p>
                                <p class="text-gray-400 text-sm">@{{ $musician->username }}</p>
                            </div>
                        </div>
                        <!-- Ciudad -->
                        @if($musician->city)
                            <p class="text-gray-400 text-sm">📍 {{ $musician->city }}</p>
                        @endif
                        <!-- Géneros -->
                        @if($musician->genres->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach($musician->genres->take(3) as $genre)
                                    <span class="bg-indigo-900 text-indigo-300 text-xs px-2 py-1 rounded-full">{{ $genre->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        <!-- Instrumentos -->
                        @if($musician->instruments->isNotEmpty())
                            <div class="flex flex-wrap gap-2">
                                @foreach($musician->instruments->take(3) as $instrument)
                                    <span class="bg-gray-700 text-gray-300 text-xs px-2 py-1 rounded-full">{{ $instrument->name }}</span>
                                @endforeach
                            </div>
                        @endif
                        <!-- Tiene banda -->
                        <p class="text-xs {{ $musician->has_band ? 'text-green-400' : 'text-yellow-400' }}">
                            {{ $musician->has_band ? '✅ En banda' : '🔍 Buscando banda' }}
                        </p>
                    </a>
                @endforeach
            </div>

            <!-- Paginación -->
            <div class="mt-10">
                {{ $musicians->withQueryString()->links() }}
            </div>
        @endif
    </main>

    <footer class="text-center text-gray-600 py-6 text-sm">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>