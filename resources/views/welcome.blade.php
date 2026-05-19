<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Encuentra tu banda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-8 py-5">
        <span class="text-2xl font-bold text-indigo-400">🎸 Bandicalia</span>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg border border-indigo-400 text-indigo-400 hover:bg-indigo-400 hover:text-white transition">
                Iniciar sesión
            </a>
            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-indigo-500 hover:bg-indigo-600 text-white transition">
                Registrarse
            </a>
        </div>
    </nav>

    <!-- Hero -->
    <main class="flex-1 flex flex-col items-center justify-center text-center px-6 py-20">
        <h1 class="text-5xl font-extrabold mb-6 leading-tight">
            Encuentra a los músicos<br>que necesitas
        </h1>
        <p class="text-gray-400 text-xl max-w-xl mb-10">
            Bandicalia es la plataforma para conectar músicos. Crea tu perfil, muestra tus instrumentos y géneros favoritos, y forma tu banda ideal.
        </p>
        <div class="flex gap-4">
            <a href="{{ route('register') }}" class="px-8 py-3 bg-indigo-500 hover:bg-indigo-600 rounded-xl text-lg font-semibold transition">
                Empieza gratis
            </a>
            <a href="{{ route('login') }}" class="px-8 py-3 border border-gray-600 hover:border-indigo-400 rounded-xl text-lg font-semibold transition">
                Ya tengo cuenta
            </a>
        </div>
    </main>

    <!-- Features -->
    <section class="grid grid-cols-1 md:grid-cols-3 gap-8 px-12 py-16 bg-gray-900">
        <div class="text-center p-6">
            <div class="text-4xl mb-4">🎵</div>
            <h3 class="text-xl font-bold mb-2">Tu perfil musical</h3>
            <p class="text-gray-400">Añade tus instrumentos con tu nivel, géneros favoritos y tu historial de bandas.</p>
        </div>
        <div class="text-center p-6">
            <div class="text-4xl mb-4">🔍</div>
            <h3 class="text-xl font-bold mb-2">Busca músicos</h3>
            <p class="text-gray-400">Filtra por instrumento, género musical o ciudad y encuentra al músico perfecto.</p>
        </div>
        <div class="text-center p-6">
            <div class="text-4xl mb-4">🤝</div>
            <h3 class="text-xl font-bold mb-2">Conecta y toca</h3>
            <p class="text-gray-400">Contacta con otros músicos y empieza a construir tu banda.</p>
        </div>
    </section>

    <!-- Footer -->
    <footer class="text-center text-gray-600 py-6 text-sm">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>