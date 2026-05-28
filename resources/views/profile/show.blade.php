<x-app-layout>
    <main class="max-w-4xl mx-auto px-6 py-10 w-full">

        @if(session('status') === 'profile-updated')
            <div style="background:rgba(255,55,55,.1); border:1px solid rgba(255,55,55,.3); color:var(--beige); padding:.75rem 1rem; border-radius:12px; margin-bottom:1.5rem; font-size:.9rem;">
                Perfil actualizado correctamente.
            </div>
        @endif

        <!-- Cabecera -->
        <div style="background:var(--mid); border-radius:20px; padding:2rem; margin-bottom:1.5rem; border:1px solid rgba(255,193,147,.15);">
            <div style="display:flex; align-items:flex-start; gap:2rem;">

                <!-- Foto -->
                @if($user->photo)
                    <img src="{{ Storage::url($user->photo) }}"
                         style="width:100px; height:100px; border-radius:16px; object-fit:cover; border:2px solid rgba(255,55,55,.4); flex-shrink:0;">
                @else
                    <div style="width:100px; height:100px; border-radius:16px; background:linear-gradient(135deg,var(--orange),var(--red)); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-size:2.5rem; font-weight:700; color:#fff; flex-shrink:0;">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                @endif

                <!-- Info -->
                <div style="flex:1;">
                    <div style="display:flex; align-items:flex-start; justify-content:space-between;">
                        <div>
                            <h1 style="font-family:'Playfair Display',serif; font-size:1.9rem; font-weight:900; color:var(--beige); line-height:1.1;">
                                {{ $user->username }}
                            </h1>
                            @if($user->full_name)
                                <p style="color:var(--muted); margin-top:.25rem;">{{ $user->full_name }}</p>
                            @endif
                        </div>
                        @auth
                            @if(auth()->id() === $user->id)
                                <a href="{{ route('profile.edit') }}"
                                   style="padding:.5rem 1.25rem; background:var(--red); color:#fff; border-radius:10px; font-size:.85rem; font-weight:600; text-decoration:none; transition:background .2s;"
                                   onmouseover="this.style.background='var(--salmon)'" onmouseout="this.style.background='var(--red)'">
                                    Editar perfil
                                </a>
                            @endif
                        @endauth
                    </div>

                    <div style="display:flex; flex-wrap:wrap; gap:1rem; margin-top:1rem; font-size:.85rem; color:var(--muted);">
                        @if($user->city)
                            <span>📍 {{ $user->city }}</span>
                        @endif
                        @if($user->age)
                            <span>{{ $user->age }} años</span>
                        @endif
                        @if($user->general_level)
                            <span style="padding:.2rem .75rem; border-radius:999px; background:rgba(255,55,55,.1); color:var(--red); border:1px solid rgba(255,55,55,.2);">
                                {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$user->general_level] }}
                            </span>
                        @endif
                        @if($user->account_type === 'musician')
                            <span style="padding:.2rem .75rem; border-radius:999px; background:rgba(255,193,147,.1); border:1px solid rgba(255,193,147,.2);">
                                {{ $user->has_band ? 'En banda' : 'Buscando banda' }}
                            </span>
                        @endif
                    </div>

                    @if($user->bio)
                        <p style="margin-top:1rem; color:rgba(255,237,206,.6); font-size:.9rem; line-height:1.6;">{{ $user->bio }}</p>
                    @endif

                    @if($user->soundcloud_url || $user->spotify_url)
                        <div style="display:flex; gap:.75rem; margin-top:1rem;">
                            @if($user->soundcloud_url)
                                <a href="{{ $user->soundcloud_url }}" target="_blank"
                                   style="padding:.35rem 1rem; border-radius:8px; background:rgba(255,255,255,.05); border:1px solid rgba(255,193,147,.2); color:var(--muted); font-size:.8rem; text-decoration:none; transition:border-color .2s;"
                                   onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='rgba(255,193,147,.2)'">
                                    SoundCloud
                                </a>
                            @endif
                            @if($user->spotify_url)
                                <a href="{{ $user->spotify_url }}" target="_blank"
                                   style="padding:.35rem 1rem; border-radius:8px; background:rgba(255,255,255,.05); border:1px solid rgba(255,193,147,.2); color:var(--muted); font-size:.8rem; text-decoration:none; transition:border-color .2s;"
                                   onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='rgba(255,193,147,.2)'">
                                    Spotify
                                </a>
                            @endif
                        </div>
                    @endif
                </div>
            </div>
        </div>

        <!-- Géneros e instrumentos -->
        <div style="display:grid; grid-template-columns:1fr 1fr; gap:1.5rem;">

            @if($user->genres->isNotEmpty())
            <div style="background:var(--mid); border-radius:16px; padding:1.5rem; border:1px solid rgba(255,193,147,.15);">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; color:var(--beige); margin-bottom:1rem;">Géneros musicales</h2>
                <div style="display:flex; flex-wrap:wrap; gap:.5rem;">
                    @foreach($user->genres as $genre)
                        <span style="padding:.35rem .9rem; border-radius:999px; background:rgba(255,55,55,.1); border:1px solid rgba(255,55,55,.2); color:var(--red); font-size:.82rem; font-weight:600;">
                            {{ $genre->name }}
                        </span>
                    @endforeach
                </div>
            </div>
            @endif

            @if($user->instruments->isNotEmpty())
            <div style="background:var(--mid); border-radius:16px; padding:1.5rem; border:1px solid rgba(255,193,147,.15);">
                <h2 style="font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; color:var(--beige); margin-bottom:1rem;">Instrumentos</h2>
                <div style="display:flex; flex-direction:column; gap:.75rem;">
                    @foreach($user->instruments as $instrument)
                        <div style="display:flex; justify-content:space-between; align-items:center;">
                            <span style="color:rgba(255,237,206,.8); font-size:.9rem;">{{ $instrument->name }}</span>
                            <span style="padding:.25rem .75rem; border-radius:8px; background:rgba(255,255,255,.05); border:1px solid rgba(255,193,147,.2); color:var(--muted); font-size:.78rem;">
                                {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$instrument->pivot->level] }}
                            </span>
                        </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>
    </main>
</x-app-layout>