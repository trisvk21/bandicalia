<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Únete</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="absolute top-0 left-0 right-0 flex justify-between items-center px-8 py-5 z-10">
        <a href="{{ route('landing') }}" class="text-2xl font-bold text-white">🎸 Bandicalia</a>
        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg border border-white text-white hover:bg-white hover:text-gray-900 transition">
            Ya tengo cuenta
        </a>
    </nav>

    <!-- Pantalla dividida -->
    <div class="flex min-h-screen">

        <!-- Músico -->
        <a href="{{ route('register.musician') }}"
            class="w-1/2 bg-indigo-600 hover:bg-indigo-700 transition-all duration-300 flex flex-col items-center justify-center gap-6 group cursor-pointer">
            <div class="text-8xl group-hover:scale-110 transition-transform duration-300">🎸</div>
            <h2 class="text-white text-4xl font-extrabold">Soy músico</h2>
            <p class="text-indigo-200 text-center max-w-xs px-4">
                Crea tu perfil, muestra tus instrumentos y encuentra tu banda ideal.
            </p>
            <span class="mt-4 px-8 py-3 bg-white text-indigo-600 rounded-xl font-semibold group-hover:scale-105 transition-transform duration-300">
                Registrarme como músico →
            </span>
        </a>

        <!-- Banda -->
        <a href="{{ route('register.band') }}"
            class="w-1/2 bg-rose-600 hover:bg-rose-700 transition-all duration-300 flex flex-col items-center justify-center gap-6 group cursor-pointer">
            <div class="text-8xl group-hover:scale-110 transition-transform duration-300">🎵</div>
            <h2 class="text-white text-4xl font-extrabold">Somos una banda</h2>
            <p class="text-rose-200 text-center max-w-xs px-4">
                Crea el perfil de tu banda y publica anuncios para encontrar nuevos miembros.
            </p>
            <span class="mt-4 px-8 py-3 bg-white text-rose-600 rounded-xl font-semibold group-hover:scale-105 transition-transform duration-300">
                Registrarme como banda →
            </span>
        </a>

    </div>

</body>
</html>