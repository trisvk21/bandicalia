<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Únete</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen flex flex-col font-sans">

    <!-- Navbar -->
    <nav class="absolute top-0 left-0 right-0 flex justify-between items-center px-8 py-5 z-10">
        <a href="{{ route('landing') }}" class="font-serif text-2xl font-extrabold text-brand tracking-tight">
            BANDICALIA
        </a>
        <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg border border-white text-white hover:bg-white hover:text-dark transition font-semibold">
            Ya tengo cuenta
        </a>
    </nav>

    <!-- Pantalla dividida -->
    <div class="flex min-h-screen">

        <!-- Músico -->
        <a href="{{ route('register.musician') }}"
            class="w-1/2 bg-darker hover:bg-dark transition-all duration-300 flex flex-col items-center justify-center gap-6 group cursor-pointer border-r border-brand/20">

            <!-- Icono SVG músico -->
            <div class="w-24 h-24 rounded-full bg-brand/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
            </div>

            <h2 class="text-cream text-4xl font-serif font-extrabold">Soy músico</h2>
            <p class="text-white/60 text-center max-w-xs px-4 text-base">
                Crea tu perfil, muestra tus instrumentos y encuentra tu banda ideal.
            </p>
            <span class="mt-4 px-8 py-3 bg-brand text-white rounded-xl font-semibold group-hover:bg-coral transition-colors duration-300">
                Registrarme como músico →
            </span>
        </a>

        <!-- Banda -->
        <a href="{{ route('register.band') }}"
            class="w-1/2 bg-dark hover:bg-darker transition-all duration-300 flex flex-col items-center justify-center gap-6 group cursor-pointer">

            <!-- Icono SVG banda -->
            <div class="w-24 h-24 rounded-full bg-brand/10 flex items-center justify-center group-hover:scale-110 transition-transform duration-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M18 18.72a9.094 9.094 0 003.741-.479 3 3 0 00-4.682-2.72m.94 3.198l.001.031c0 .225-.012.447-.037.666A11.944 11.944 0 0112 21c-2.17 0-4.207-.576-5.963-1.584A6.062 6.062 0 016 18.719m12 0a5.971 5.971 0 00-.941-3.197m0 0A5.995 5.995 0 0012 12.75a5.995 5.995 0 00-5.058 2.772m0 0a3 3 0 00-4.681 2.72 8.986 8.986 0 003.74.477m.94-3.197a5.971 5.971 0 00-.94 3.197M15 6.75a3 3 0 11-6 0 3 3 0 016 0zm6 3a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0zm-13.5 0a2.25 2.25 0 11-4.5 0 2.25 2.25 0 014.5 0z" />
                </svg>
            </div>

            <h2 class="text-cream text-4xl font-serif font-extrabold">Somos una banda</h2>
            <p class="text-white/60 text-center max-w-xs px-4 text-base">
                Crea el perfil de tu banda y publica anuncios para encontrar nuevos miembros.
            </p>
            <span class="mt-4 px-8 py-3 bg-brand text-white rounded-xl font-semibold group-hover:bg-coral transition-colors duration-300">
                Registrarme como banda →
            </span>
        </a>

    </div>

</body>
</html>