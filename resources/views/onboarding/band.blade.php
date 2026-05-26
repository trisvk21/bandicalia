<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Completa el perfil de tu banda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-darker font-sans flex flex-col">

    <nav class="flex justify-between items-center px-8 py-5 border-b border-brand/20">
        <span class="font-serif text-2xl font-extrabold text-brand tracking-tight">BANDICALIA</span>
        <span class="text-white/40 text-sm">Paso 2 de 2 — Completa el perfil</span>
    </nav>

    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-2xl">

            <div class="mb-8 text-center">
                <h1 class="font-serif text-3xl font-extrabold text-cream mb-2">Cuéntanos sobre vuestra banda</h1>
                <p class="text-white/50 text-sm">Todos los campos son opcionales, pero cuanto más rellenes mejor os encontrarán.</p>
            </div>

            <form method="POST" action="{{ route('onboarding.store') }}" class="space-y-6">
                @csrf

                <!-- Ciudad -->
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-1">Ciudad</label>
                    <input type="text" name="city" value="{{ old('city') }}"
                        placeholder="Madrid, Barcelona..."
                        class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                </div>

                <!-- Géneros -->
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-3">Géneros musicales</label>
                    <div class="flex flex-wrap gap-2">
                        @foreach($genres as $genre)
                        <label class="cursor-pointer">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="sr-only peer"
                                {{ in_array($genre->id, old('genres', [])) ? 'checked' : '' }}>
                            <span class="block px-4 py-2 rounded-full border border-white/10 text-white/50 text-sm peer-checked:border-brand peer-checked:text-brand peer-checked:bg-brand/10 hover:border-white/30 transition">
                                {{ $genre->name }}
                            </span>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-1">Biografía</label>
                    <textarea name="bio" rows="4" placeholder="Contad un poco sobre la banda, vuestro estilo, influencias, trayectoria..."
                        class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition resize-none">{{ old('bio') }}</textarea>
                </div>

                <!-- SoundCloud / Spotify -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">SoundCloud URL</label>
                        <input type="url" name="soundcloud_url" value="{{ old('soundcloud_url') }}"
                            placeholder="https://soundcloud.com/..."
                            class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Spotify URL</label>
                        <input type="url" name="spotify_url" value="{{ old('spotify_url') }}"
                            placeholder="https://open.spotify.com/..."
                            class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    </div>
                </div>

                <div class="flex gap-4 pt-2">
                    <a href="{{ route('home') }}" class="flex-1 py-3 text-center border border-white/20 text-white/50 hover:text-white hover:border-white/40 rounded-xl transition text-sm">
                        Saltar por ahora
                    </a>
                    <button type="submit" class="flex-1 py-3 bg-brand hover:bg-coral text-white font-semibold rounded-xl transition">
                        Completar perfil
                    </button>
                </div>

            </form>
        </div>
    </div>

</body>
</html>