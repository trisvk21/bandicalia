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
    @else
        {{-- PERFIL AJENO: botón seguir --}}
        @if($followStatus === 'accepted')
    <div style="display:flex; gap:.5rem;">
        <form method="POST" action="{{ route('follow.unfollow', $user) }}">
            @csrf
            <button style="padding:.5rem 1.25rem; border-radius:10px; border:1.5px solid var(--muted); color:var(--muted); background:transparent; font-size:.85rem; font-weight:600; cursor:pointer;"
                    onmouseover="this.style.borderColor='var(--salmon)';this.style.color='var(--salmon)'"
                    onmouseout="this.style.borderColor='var(--muted)';this.style.color='var(--muted)'">
                ✓ Siguiendo
            </button>
        </form>
        <a href="{{ route('chat.show', $user) }}"
           style="padding:.5rem 1.25rem; background:rgba(255,255,255,.05); border:1.5px solid rgba(255,193,147,.3); color:var(--beige); border-radius:10px; font-size:.85rem; font-weight:600; text-decoration:none; transition:border-color .2s;"
           onmouseover="this.style.borderColor='var(--orange)'" onmouseout="this.style.borderColor='rgba(255,193,147,.3)'">
            💬 Mensaje
        </a>
    </div>
        @elseif($followStatus === 'pending')
            <form method="POST" action="{{ route('follow.unfollow', $user) }}">
                @csrf
                <button style="padding:.5rem 1.25rem; border-radius:10px; border:1.5px solid rgba(255,193,147,.3); color:rgba(255,237,206,.4); background:transparent; font-size:.85rem; font-weight:600; cursor:pointer;">
                    Solicitud enviada
                </button>
            </form>
        @else
            <form method="POST" action="{{ route('follow.send', $user) }}">
                @csrf
                <button style="padding:.5rem 1.25rem; background:var(--red); color:#fff; border-radius:10px; font-size:.85rem; font-weight:600; border:none; cursor:pointer; transition:background .2s;"
                        onmouseover="this.style.background='var(--salmon)'"
                        onmouseout="this.style.background='var(--red)'">
                    + Seguir
                </button>
            </form>
        @endif
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

        {{-- Solicitudes pendientes recibidas --}}
@auth
    @if(auth()->id() === $user->id)
        @php $pendingRequests = $user->followers()->wherePivot('status', 'pending')->get(); @endphp
        @if($pendingRequests->isNotEmpty())
            <div class="bg-dark rounded-2xl p-6 border border-brand/30 mt-6">
                <h2 class="font-serif text-lg font-bold text-cream mb-4">
                    Solicitudes de seguimiento ({{ $pendingRequests->count() }})
                </h2>
                <div class="flex flex-col gap-3">
                    @foreach($pendingRequests as $requester)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/5 border border-white/10">
                            <a href="{{ route('profile.show', $requester->username) }}"
                               class="flex items-center gap-4 hover:opacity-80 transition">
                                @if($requester->photo)
                                    <img src="{{ Storage::url($requester->photo) }}"
                                         class="w-10 h-10 rounded-xl object-cover border border-brand/20">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-lg">🎵</div>
                                @endif
                                <p class="text-cream text-sm font-semibold">{{ $requester->username }}</p>
                            </a>
                            <div class="flex gap-2">
                                <form method="POST" action="{{ route('follow.accept', $requester) }}">
                                    @csrf
                                    <button class="px-4 py-1.5 bg-brand hover:bg-coral text-white text-xs font-semibold rounded-lg transition">
                                        Aceptar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('follow.reject', $requester) }}">
                                    @csrf
                                    <button class="px-4 py-1.5 border border-white/20 text-white/40 hover:border-coral hover:text-coral text-xs rounded-lg transition">
                                        Rechazar
                                    </button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        @endif
    @endif
@endauth
        {{-- Lista de seguidos: solo visible en tu propio perfil --}}
@auth
    @if(auth()->id() === $user->id)
        @php
            $following = $user->following()->wherePivot('status', 'accepted')->get();
            $followingMusicians = $following->where('account_type', 'musician');
            $followingBands = $following->where('account_type', 'band');
        @endphp
        <div class="bg-dark rounded-2xl p-6 border border-white/10 mt-6">
            <h2 class="font-serif text-lg font-bold text-cream mb-4">
                Cuentas que sigues ({{ $following->count() }})
            </h2>
            @if($following->isEmpty())
                <p class="text-white/40 text-sm">Aún no sigues a nadie.</p>
            @else
                <div class="flex flex-col gap-3">
                    @if($followingMusicians->isNotEmpty())
                        <p class="text-white/30 text-xs uppercase tracking-widest font-semibold mt-1">Músicos</p>
                        @foreach($followingMusicians as $musician)
                            <a href="{{ route('profile.show', $musician->username) }}"
                               class="flex items-center gap-4 p-3 rounded-xl bg-white/5 border border-white/10 hover:border-brand/40 transition">
                                @if($musician->photo)
                                    <img src="{{ Storage::url($musician->photo) }}"
                                         class="w-10 h-10 rounded-xl object-cover border border-brand/20">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-lg">🎵</div>
                                @endif
                                <div>
                                    <p class="text-cream text-sm font-semibold">{{ $musician->username }}</p>
                                    @if($musician->city)
                                        <p class="text-white/40 text-xs">{{ $musician->city }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    @endif

                    @if($followingBands->isNotEmpty())
                        <p class="text-white/30 text-xs uppercase tracking-widest font-semibold mt-3">Bandas</p>
                        @foreach($followingBands as $band)
                            <a href="{{ route('profile.show', $band->username) }}"
                               class="flex items-center gap-4 p-3 rounded-xl bg-white/5 border border-white/10 hover:border-brand/40 transition">
                                @if($band->photo)
                                    <img src="{{ Storage::url($band->photo) }}"
                                         class="w-10 h-10 rounded-xl object-cover border border-brand/20">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-lg">🎵</div>
                                @endif
                                <div>
                                    <p class="text-cream text-sm font-semibold">{{ $band->username }}</p>
                                    @if($band->city)
                                        <p class="text-white/40 text-xs">{{ $band->city }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    @endif
@endauth

{{-- Lista de seguidores --}}
@auth
    @if(auth()->id() === $user->id)
        @php
            $followers = $user->followers()->wherePivot('status', 'accepted')->get();
            $followerMusicians = $followers->where('account_type', 'musician');
            $followerBands = $followers->where('account_type', 'band');
        @endphp
        <div class="bg-dark rounded-2xl p-6 border border-white/10 mt-6">
            <h2 class="font-serif text-lg font-bold text-cream mb-4">
                Seguidores ({{ $followers->count() }})
            </h2>
            @if($followers->isEmpty())
                <p class="text-white/40 text-sm">Aún no tienes seguidores.</p>
            @else
                <div class="flex flex-col gap-3">
                    @if($followerMusicians->isNotEmpty())
                        <p class="text-white/30 text-xs uppercase tracking-widest font-semibold mt-1">Músicos</p>
                        @foreach($followerMusicians as $follower)
                            <a href="{{ route('profile.show', $follower->username) }}"
                               class="flex items-center gap-4 p-3 rounded-xl bg-white/5 border border-white/10 hover:border-brand/40 transition">
                                @if($follower->photo)
                                    <img src="{{ Storage::url($follower->photo) }}"
                                         class="w-10 h-10 rounded-xl object-cover border border-brand/20">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-lg">🎵</div>
                                @endif
                                <div>
                                    <p class="text-cream text-sm font-semibold">{{ $follower->username }}</p>
                                    @if($follower->city)
                                        <p class="text-white/40 text-xs">{{ $follower->city }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    @endif

                    @if($followerBands->isNotEmpty())
                        <p class="text-white/30 text-xs uppercase tracking-widest font-semibold mt-3">Bandas</p>
                        @foreach($followerBands as $band)
                            <a href="{{ route('profile.show', $band->username) }}"
                               class="flex items-center gap-4 p-3 rounded-xl bg-white/5 border border-white/10 hover:border-brand/40 transition">
                                @if($band->photo)
                                    <img src="{{ Storage::url($band->photo) }}"
                                         class="w-10 h-10 rounded-xl object-cover border border-brand/20">
                                @else
                                    <div class="w-10 h-10 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-lg">🎵</div>
                                @endif
                                <div>
                                    <p class="text-cream text-sm font-semibold">{{ $band->username }}</p>
                                    @if($band->city)
                                        <p class="text-white/40 text-xs">{{ $band->city }}</p>
                                    @endif
                                </div>
                            </a>
                        @endforeach
                    @endif
                </div>
            @endif
        </div>
    @endif
@endauth
{{-- Anuncios de la banda --}}
@if($user->account_type === 'band')
    @php $bandAds = $user->ads()->latest()->get(); @endphp
    <div style="background:var(--mid); border-radius:16px; padding:1.5rem; border:1px solid rgba(255,193,147,.15); margin-top:1.5rem;">
        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
            <h2 style="font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; color:var(--beige);">
                Anuncios ({{ $bandAds->count() }})
            </h2>
            @auth
                @if(auth()->id() === $user->id)
                    <a href="{{ route('ads.create') }}"
                       style="padding:.3rem .9rem; background:var(--red); color:#fff; border-radius:8px; font-size:.78rem; font-weight:600; text-decoration:none; transition:background .2s;"
                       onmouseover="this.style.background='var(--salmon)'" onmouseout="this.style.background='var(--red)'">
                        + Nuevo
                    </a>
                @endif
            @endauth
        </div>
        @if($bandAds->isEmpty())
            <p style="color:rgba(255,237,206,.3); font-size:.85rem;">No hay anuncios publicados todavía.</p>
        @else
            <div style="display:flex; flex-direction:column; gap:.75rem; max-height:320px; overflow-y:auto; padding-right:.25rem;">
                @foreach($bandAds as $ad)
                    <a href="{{ route('ads.show', $ad) }}"
                       style="display:block; padding:1rem 1.25rem; background:rgba(255,255,255,.04); border-radius:12px; border:1px solid rgba(255,193,147,.1); text-decoration:none; transition:border-color .2s;"
                       onmouseover="this.style.borderColor='rgba(255,55,55,.35)'" onmouseout="this.style.borderColor='rgba(255,193,147,.1)'">
                        <p style="font-family:'Playfair Display',serif; font-weight:700; color:var(--beige); font-size:.95rem; margin-bottom:.35rem;">{{ $ad->title }}</p>
                        <p style="color:rgba(255,237,206,.45); font-size:.82rem; line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $ad->body }}</p>
                        <p style="color:var(--muted); font-size:.72rem; margin-top:.5rem;">{{ $ad->created_at->diffForHumans() }}</p>
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endif
    </main>
</x-app-layout>