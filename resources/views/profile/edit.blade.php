<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Editar perfil</title>
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-darker text-cream min-h-screen flex flex-col font-sans">

    <nav class="flex justify-between items-center px-8 py-5 bg-dark border-b border-brand/20">
        <a href="{{ route('home') }}" class="font-serif text-2xl font-extrabold text-brand tracking-tight">BANDICALIA</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('profile.show', auth()->user()->username) }}"
               class="text-white/70 hover:text-white text-sm transition">Mi perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg border border-white/20 text-white/70 hover:border-coral hover:text-coral text-sm transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <main class="flex-1 px-6 py-10 max-w-4xl mx-auto w-full">

        <div class="flex justify-between items-center mb-8">
            <h1 class="font-serif text-3xl font-extrabold text-cream">Editar perfil</h1>
        </div>

        @if(session('status') === 'profile-updated')
            <div class="bg-brand/10 border border-brand/30 text-cream px-4 py-3 rounded-xl mb-6 text-sm">
                Perfil actualizado correctamente.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="space-y-6">
            @csrf
            @method('PATCH')
            <input type="hidden" name="name" value="{{ $user->name }}">

            <!-- Información básica -->
            <div class="bg-dark rounded-2xl p-6 border border-white/10 space-y-4">
                <h2 class="font-serif text-lg font-bold text-cream">Información básica</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Nombre de usuario *</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}"
                            class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                        @error('username') <p class="text-coral text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Nombre completo</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                            class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                        @error('email') <p class="text-coral text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Ciudad</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}"
                            class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Edad</label>
                        <input type="number" name="age" value="{{ old('age', $user->age) }}" min="14" max="100"
                            class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Nivel general</label>
                        <select name="general_level"
                            class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('general_level', $user->general_level) == $i ? 'selected' : '' }}>
                                    {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$i] }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div>
                    <label class="block text-sm font-medium text-white/70 mb-1">Biografía</label>
                    <textarea name="bio" rows="3"
                        class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition resize-none">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="flex items-center gap-3 p-4 rounded-xl border border-white/10 bg-darker">
                    <input type="checkbox" name="has_band" id="has_band" value="1"
                        {{ $user->has_band ? 'checked' : '' }} class="w-5 h-5 accent-brand">
                    <label for="has_band" class="text-cream text-sm cursor-pointer">Actualmente estoy en una banda</label>
                </div>

                <div>
                    <label class="block text-sm font-medium text-white/70 mb-2">Foto de perfil</label>
                    @if($user->photo)
                        <img src="{{ Storage::url($user->photo) }}" class="w-20 h-20 rounded-xl object-cover mb-3 border-2 border-brand/30">
                    @endif
                    <input type="file" name="photo" accept="image/*" class="text-white/50 text-sm" />
                </div>
            </div>

            <!-- Redes sociales -->
            <div class="bg-dark rounded-2xl p-6 border border-white/10 space-y-4">
                <h2 class="font-serif text-lg font-bold text-cream">Redes y música</h2>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">SoundCloud URL</label>
                        <input type="url" name="soundcloud_url" value="{{ old('soundcloud_url', $user->soundcloud_url) }}"
                            placeholder="https://soundcloud.com/tu-perfil"
                            class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                        @error('soundcloud_url') <p class="text-coral text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-white/70 mb-1">Spotify URL</label>
                        <input type="url" name="spotify_url" value="{{ old('spotify_url', $user->spotify_url) }}"
                            placeholder="https://open.spotify.com/artist/..."
                            class="w-full px-4 py-3 rounded-xl bg-darker border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                        @error('spotify_url') <p class="text-coral text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                </div>
            </div>

            <!-- Géneros -->
            <div class="bg-dark rounded-2xl p-6 border border-white/10 space-y-4">
                <h2 class="font-serif text-lg font-bold text-cream">Géneros musicales</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($genres as $genre)
                    <label class="cursor-pointer">
                        <input type="checkbox" name="genres[]" value="{{ $genre->id }}" class="sr-only peer"
                            {{ $user->genres->contains($genre->id) ? 'checked' : '' }}>
                        <span class="block px-4 py-2 rounded-full border border-white/10 text-white/50 text-sm peer-checked:border-brand peer-checked:text-brand peer-checked:bg-brand/10 hover:border-white/30 transition">
                            {{ $genre->name }}
                        </span>
                    </label>
                    @endforeach
                </div>
            </div>

            <!-- Instrumentos -->
            <div class="bg-dark rounded-2xl p-6 border border-white/10 space-y-4">
                <h2 class="font-serif text-lg font-bold text-cream">Instrumentos</h2>
                <div class="space-y-3">
                    @foreach($instruments as $instrument)
                        @php
                            $pivot = $user->instruments->find($instrument->id);
                            $checked = $pivot !== null;
                            $level = $pivot ? $pivot->pivot->level : 1;
                        @endphp
                        <label class="flex items-center gap-4 p-3 rounded-xl border border-white/10 hover:border-white/20 cursor-pointer transition has-[:checked]:border-brand/40 has-[:checked]:bg-brand/5">
                            <input type="checkbox" name="instrument_ids[]" value="{{ $instrument->id }}"
                                class="instrument-checkbox w-4 h-4 accent-brand" {{ $checked ? 'checked' : '' }}
                                data-id="{{ $instrument->id }}">
                            <span class="text-cream text-sm flex-1">{{ $instrument->name }}</span>
                            <select name="instruments[{{ $instrument->id }}]"
                                class="instrument-level {{ $checked ? '' : 'hidden' }} px-3 py-1 rounded-lg bg-darker border border-white/20 text-white/70 text-sm focus:outline-none focus:border-brand transition">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $level == $i ? 'selected' : '' }}>
                                        {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$i] }}
                                    </option>
                                @endfor
                            </select>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Anuncios (solo bandas) -->
            @if($user->account_type === 'band')
            <div class="bg-dark rounded-2xl p-6 border border-white/10 space-y-4">
                <div class="flex justify-between items-center">
                    <h2 class="font-serif text-lg font-bold text-cream">Anuncios</h2>
                    <a href="{{ route('ads.create') }}"
                       class="px-4 py-2 bg-brand hover:bg-coral text-white text-sm font-semibold rounded-xl transition">
                        + Nuevo anuncio
                    </a>
                </div>
                @if($user->ads->isEmpty())
                    <p class="text-white/30 text-sm">No hay anuncios publicados todavía.</p>
                @else
                    <div class="space-y-3">
                        @foreach($user->ads as $ad)
                        <div class="bg-darker rounded-xl p-4 flex justify-between items-start gap-4 border border-white/10">
                            <div>
                                <p class="font-semibold text-cream text-sm">{{ $ad->title }}</p>
                                <p class="text-white/50 text-sm mt-1">{{ $ad->body }}</p>
                                <p class="text-white/20 text-xs mt-2">{{ $ad->created_at->diffForHumans() }}</p>
                            </div>
                            <form method="POST" action="{{ route('ads.destroy', $ad) }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-coral hover:text-brand text-sm transition">
                                    Eliminar
                                </button>
                            </form>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
            @endif

            <div class="flex gap-4 pb-6">
                <a href="{{ route('profile.show', auth()->user()->username) }}"
                   class="flex-1 py-3 text-center border border-white/20 text-white/50 hover:text-white hover:border-white/40 rounded-xl transition text-sm">
                    Cancelar
                </a>
                <button type="submit"
                    class="flex-1 py-3 bg-brand hover:bg-coral text-white font-semibold rounded-xl transition">
                    Guardar cambios
                </button>
            </div>
        </form>
    </main>

    <footer class="text-center text-white/20 py-6 text-sm bg-dark border-t border-white/5">
        © 2026 Bandicalia — TFG
    </footer>

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