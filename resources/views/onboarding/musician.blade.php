<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Completa tu perfil</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-darker font-sans flex flex-col">

    <nav class="flex justify-between items-center px-8 py-5 border-b border-brand/20">
        <span class="font-serif text-2xl font-extrabold text-brand tracking-tight">BANDICALIA</span>
        <span class="text-white/40 text-sm">Paso 2 de 2 — Completa tu perfil</span>
    </nav>

    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-2xl">

            <div class="mb-8 text-center">
                <h1 class="font-serif text-3xl font-extrabold text-cream mb-2">Cuéntanos sobre ti</h1>
                <p class="text-white/50 text-sm">Todos los campos son opcionales, pero cuanto más rellenes mejor te encontrarán.</p>
            </div>

            <form method="POST" action="{{ route('onboarding.store') }}" class="space-y-6">
                @csrf

                <!-- Provincia y edad -->
                <div class="grid grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Provincia</label>
                        <select name="city"
                            class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition">
                            <option value="">Selecciona provincia...</option>
                            @foreach(['Álava', 'Albacete', 'Alicante', 'Almería', 'Asturias', 'Ávila', 'Badajoz', 'Barcelona', 'Burgos', 'Cáceres', 'Cádiz', 'Cantabria', 'Castellón', 'Ciudad Real', 'Córdoba', 'Cuenca', 'Gerona', 'Granada', 'Guadalajara', 'Guipúzcoa', 'Huelva', 'Huesca', 'Islas Baleares', 'Jaén', 'La Coruña', 'La Rioja', 'Las Palmas', 'León', 'Lérida', 'Lugo', 'Madrid', 'Málaga', 'Murcia', 'Navarra', 'Orense', 'Palencia', 'Pontevedra', 'Salamanca', 'Santa Cruz de Tenerife', 'Segovia', 'Sevilla', 'Soria', 'Tarragona', 'Teruel', 'Toledo', 'Valencia', 'Valladolid', 'Vizcaya', 'Zamora', 'Zaragoza', 'Ceuta', 'Melilla'] as $provincia)
                                <option value="{{ $provincia }}" {{ old('city') === $provincia ? 'selected' : '' }}>{{ $provincia }}</option>
                            @endforeach
                        </select>
                    </div>

                <!-- Nivel general -->
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-3">Nivel general</label>
                    <div class="flex gap-3">
                        @foreach([1 => 'Principiante', 2 => 'Básico', 3 => 'Intermedio', 4 => 'Avanzado', 5 => 'Profesional'] as $val => $label)
                        <label class="flex-1 cursor-pointer">
                            <input type="radio" name="general_level" value="{{ $val }}" class="sr-only peer" {{ old('general_level') == $val ? 'checked' : '' }}>
                            <span class="block text-center py-2 px-1 rounded-xl border border-white/10 text-white/50 text-xs font-medium peer-checked:border-brand peer-checked:text-brand peer-checked:bg-brand/10 hover:border-white/30 transition">
                                {{ $label }}
                            </span>
                        </label>
                        @endforeach
                    </div>
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

                <!-- Instrumentos -->
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-3">Instrumentos que tocas</label>
                    <div class="space-y-3" id="instruments-list">
                        @foreach($instruments as $instrument)
                        <label class="flex items-center gap-4 p-3 rounded-xl border border-white/10 hover:border-white/20 cursor-pointer transition has-[:checked]:border-brand/40 has-[:checked]:bg-brand/5">
                            <input type="checkbox" name="instruments[]" value="{{ $instrument->id }}"
                                class="instrument-checkbox w-4 h-4 accent-brand"
                                {{ in_array($instrument->id, old('instruments', [])) ? 'checked' : '' }}
                                data-id="{{ $instrument->id }}">
                            <span class="text-cream text-sm flex-1">{{ $instrument->name }}</span>
                            <select name="instrument_level_{{ $instrument->id }}"
                                class="instrument-level hidden px-3 py-1 rounded-lg bg-dark border border-white/20 text-white/70 text-sm focus:outline-none focus:border-brand transition">
                                <option value="1">Principiante</option>
                                <option value="2">Básico</option>
                                <option value="3">Intermedio</option>
                                <option value="4">Avanzado</option>
                                <option value="5">Profesional</option>
                            </select>
                        </label>
                        @endforeach
                    </div>
                </div>

                <!-- Bio -->
                <div>
                    <label class="block text-sm font-medium text-white/70 mb-1">Biografía</label>
                    <textarea name="bio" rows="3" placeholder="Cuéntanos un poco sobre ti, tu estilo, tus influencias..."
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

                <!-- ¿Buscas banda? -->
                <div class="flex items-center gap-3 p-4 rounded-xl border border-white/10 bg-dark">
                    <input type="checkbox" name="has_band" id="has_band" value="1"
                        class="w-5 h-5 accent-brand"
                        {{ old('has_band') ? 'checked' : '' }}>
                    <label for="has_band" class="text-cream text-sm cursor-pointer">
                        Actualmente estoy en una banda
                    </label>
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

    <script>
        document.querySelectorAll('.instrument-checkbox').forEach(checkbox => {
            checkbox.addEventListener('change', function () {
                const select = this.closest('label').querySelector('.instrument-level');
                select.classList.toggle('hidden', !this.checked);
            });
        });
    </script>

</body>
</html>