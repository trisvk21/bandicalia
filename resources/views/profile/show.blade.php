<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — {{ $user->username }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-darker text-cream min-h-screen flex flex-col font-sans">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-8 py-5 bg-dark border-b border-brand/20">
        <a href="{{ route('home') }}" class="font-serif text-2xl font-extrabold text-brand tracking-tight">BANDICALIA</a>
        <div class="flex gap-4 items-center">
            @auth
                <a href="{{ route('profile.show', auth()->user()->username) }}"
                   class="text-white/70 hover:text-white text-sm transition">Mi perfil</a>
                <a href="{{ route('profile.edit') }}"
                   class="text-white/70 hover:text-white text-sm transition">Editar</a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button type="submit" class="px-4 py-2 rounded-lg border border-white/20 text-white/70 hover:border-coral hover:text-coral text-sm transition">
                        Cerrar sesión
                    </button>
                </form>
            @endauth
        </div>
    </nav>

    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-10">

        @if(session('status') === 'profile-updated')
            <div class="bg-brand/10 border border-brand/30 text-cream px-4 py-3 rounded-xl mb-6 text-sm">
                Perfil actualizado correctamente.
            </div>
        @endif

        <!-- Cabecera del perfil -->
        <div class="bg-dark rounded-2xl p-8 mb-6 border border-white/10">
            <div class="flex items-start gap-8">

                <!-- Foto -->
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}"
                         class="w-28 h-28 rounded-2xl object-cover border-2 border-brand/40 flex-shrink-0">
                @else
                    <div class="w-28 h-28 rounded-2xl bg-brand/10 border-2 border-brand/20 flex items-center justify-center flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-12 h-12 text-brand/50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M15.75 6a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.501 20.118a7.5 7.5 0 0114.998 0A17.933 17.933 0 0112 21.75c-2.676 0-5.216-.584-7.499-1.632z" />
                        </svg>
                    </div>
                @endif

                <!-- Info principal -->
                <div class="flex-1">
                    <div class="flex items-start justify-between">
                        <div>
                            <h1 class="font-serif text-3xl font-extrabold text-cream">{{ $user->username }}</h1>
                            @if($user->full_name)
                                <p class="text-white/50 mt-1">{{ $user->full_name }}</p>
                            @endif
                        </div>
                        @auth
                            @if(auth()->id() === $user->id)
                                <a href="{{ route('profile.edit') }}"
                                   class="px-5 py-2 bg-brand hover:bg-coral text-white text-sm font-semibold rounded-xl transition">
                                    Editar perfil
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div class="flex flex-wrap gap-4 mt-4 text-sm text-white/50">
                        @if($user->city)
                            <span class="flex items-center gap-1">
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10.5a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19.5 10.5c0 7.142-7.5 11.25-7.5 11.25S4.5 17.642 4.5 10.5a7.5 7.5 0 1115 0z"/></svg>
                                {{ $user->city }}
                            </span>
                        @endif
                        @if($user->age)
                            <span>{{ $user->age }} años</span>
                        @endif
                        @if($user->general_level)
                            <span class="px-2 py-0.5 rounded-full bg-brand/10 text-brand border border-brand/20">
                                {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$user->general_level] }}
                            </span>
                        @endif
                        @if($user->account_type === 'musician')
                            <span class="px-2 py-0.5 rounded-full bg-white/5 border border-white/10">
                                {{ $user->has_band ? 'En banda' : 'Busca banda' }}
                            </span>
                        @endif
                    </div>

                    @if($user->bio)
                        <p class="mt-4 text-white/60 text-sm leading-relaxed">{{ $user->bio }}</p>
                    @endif

                    <!-- Links musicales -->
                    @if($user->soundcloud_url || $user->spotify_url)
                        <div class="flex gap-3 mt-4">
                            @if($user->soundcloud_url)
                                <a href="{{ $user->soundcloud_url }}" target="_blank"
                                   class="px-4 py-1.5 rounded-lg bg-white/5 border border-white/10 hover:border-brand/40 text-white/60 hover:text-white text-xs transition">
                                    SoundCloud
                                </a>
                            @endif
                            @if($user->spotify_url)
                                <a href="{{ $user->spotify_url }}" target="_blank"
                                   class="px-4 py-1.5 rounded-lg bg-white/5 border border-white/10 hover:border-brand/40 text-white/60 hover:text-white text-xs transition">
                                    Spotify
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

            <!-- Géneros -->
            @if($user->genres->isNotEmpty())
            <div class="bg-dark rounded-2xl p-6 border border-white/10">
                <h2 class="font-serif text-lg font-bold text-cream mb-4">Géneros musicales</h2>
                <div class="flex flex-wrap gap-2">
                    @foreach($user->genres as $genre)
                        <span class="px-3 py-1.5 rounded-full bg-brand/10 border border-brand/20 text-brand text-sm">
                            {{ $genre->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- Instrumentos -->
            @if($user->instruments->isNotEmpty())
            <div class="bg-dark rounded-2xl p-6 border border-white/10">
                <h2 class="font-serif text-lg font-bold text-cream mb-4">Instrumentos</h2>
                <div class="space-y-3">
                    @foreach($user->instruments as $instrument)
                        <div class="flex items-center justify-between">
                            <span class="text-white/80 text-sm">{{ $instrument->name }}</span>
                            <span class="px-3 py-1 rounded-lg bg-white/5 border border-white/10 text-white/50 text-xs">
                                {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$instrument->pivot->level] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </main>

    <footer class="text-center text-white/20 py-6 text-sm bg-dark border-t border-white/5">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>