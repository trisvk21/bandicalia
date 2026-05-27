<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Nuevo anuncio</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-darker text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-8 py-5 bg-dark border-b border-brand/20">
        <a href="{{ route('home') }}" class="font-serif text-2xl font-extrabold text-brand tracking-tight">BANDICALIA</a>
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

    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-10">

        <h1 class="font-serif text-3xl font-extrabold text-cream">Publicar anuncio</h1>

        @if($errors->any())
            <div class="bg-red-900 text-red-200 px-4 py-3 rounded-lg mb-6">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('ads.store') }}" class="bg-dark rounded-2xl p-6 flex flex-col gap-6">
            @csrf

            <div>
                <label class="text-sm text-gray-400 mb-1 block">Título del anuncio *</label>
                <input type="text" name="title" value="{{ old('title') }}"
                    placeholder="Ej: Buscamos bajista para banda de rock en Madrid"
                    class="w-full bg-darker rounded-xl px-4 py-3 text-cream placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500 border-white/10">
            </div>

            <div>
                <label class="text-sm text-gray-400 mb-1 block">Descripción *</label>
                <textarea name="body" rows="6"
                    placeholder="Describe lo que buscáis, vuestro estilo, con qué frecuencia ensayáis..."
                    class="w-full bg-gray-800 rounded-lg px-4 py-2 text-white placeholder-gray-500 focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('body') }}</textarea>
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 rounded-xl px-8 py-3 font-semibold transition">
                    Publicar anuncio
                </button>
                <a href="{{ route('profile.edit') }}" class="border border-gray-600 hover:border-gray-400 rounded-xl px-8 py-3 font-semibold transition">
                    Cancelar
                </a>
            </div>
        </form>

    </main>

    <footer class="text-center text-gray-600 py-6 text-sm">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>