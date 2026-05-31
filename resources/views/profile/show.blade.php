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
                        <div style="display:flex; gap:.75rem; margin-top:1.25rem; flex-wrap:wrap;">
                            @if($user->soundcloud_url)
                                <a href="{{ $user->soundcloud_url }}" target="_blank"
                                    style="display:inline-flex; align-items:center; gap:.6rem; padding:.65rem 1.25rem; border-radius:12px; background:#ff5500; color:#fff; font-size:.88rem; font-weight:600; text-decoration:none; transition:all .2s; box-shadow:0 4px 12px rgba(255,85,0,.3);"
                                    onmouseover="this.style.background='#ff7733';this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.background='#ff5500';this.style.transform=''">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M1.175 12.225c-.051 0-.094.046-.101.1l-.233 2.154.233 2.105c.007.058.05.098.101.098.05 0 .09-.04.099-.098l.255-2.105-.27-2.154c-.009-.06-.05-.1-.1-.1m-.899.828c-.06 0-.091.037-.104.094L0 14.479l.172 1.308c.013.06.045.094.104.094s.09-.04.104-.1l.195-1.308-.195-1.332c-.014-.057-.045-.09-.105-.09m1.81-.7c-.07 0-.12.05-.127.12l-.214 2.006.214 1.922c.007.07.057.12.127.12.068 0 .117-.05.124-.12l.244-1.922-.244-2.006c-.007-.07-.056-.12-.124-.12m.896-.21c-.08 0-.14.063-.145.143l-.197 2.216.197 2.07c.005.08.065.14.145.14s.14-.06.146-.14l.224-2.07-.224-2.216c-.006-.08-.066-.143-.146-.143m.907-.13c-.09 0-.16.07-.166.163l-.18 2.346.18 2.19c.006.09.076.16.166.16.09 0 .16-.07.166-.16l.205-2.19-.205-2.346c-.006-.093-.076-.163-.166-.163m.91-.07c-.1 0-.178.08-.184.18l-.163 2.416.163 2.3c.006.1.084.18.184.18s.178-.08.184-.18l.185-2.3-.185-2.416c-.006-.1-.084-.18-.184-.18m.916-.04c-.11 0-.197.09-.2.2l-.148 2.456.148 2.4c.003.11.09.2.2.2.11 0 .196-.09.2-.2l.167-2.4-.167-2.456c-.004-.11-.09-.2-.2-.2m.92.01c-.12 0-.213.095-.216.216l-.132 2.446.132 2.49c.003.12.096.216.216.216.12 0 .213-.096.217-.216l.15-2.49-.15-2.446c-.004-.12-.097-.216-.217-.216m.927.07c-.13 0-.232.104-.234.234l-.116 2.376.116 2.56c.002.13.104.234.234.234.13 0 .232-.104.235-.234l.132-2.56-.132-2.376c-.003-.13-.105-.234-.235-.234m3.977-1.763c-.267 0-.52.055-.75.153C9.616 8.265 8.78 7.2 7.68 7.2c-.31 0-.6.08-.856.216-.092.05-.117.1-.12.15v7.354c.003.057.05.1.107.107h5.776c.057-.007.104-.05.107-.107.002-.015.003-.03.003-.045V12.6c0-1.314-1.064-2.38-2.377-2.38" />
                                    </svg>
                                    SoundCloud
                                </a>
                            @endif
                            @if($user->spotify_url)
                                <a href="{{ $user->spotify_url }}" target="_blank"
                                    style="display:inline-flex; align-items:center; gap:.6rem; padding:.65rem 1.25rem; border-radius:12px; background:#1db954; color:#fff; font-size:.88rem; font-weight:600; text-decoration:none; transition:all .2s; box-shadow:0 4px 12px rgba(29,185,84,.3);"
                                    onmouseover="this.style.background='#1ed760';this.style.transform='translateY(-2px)'"
                                    onmouseout="this.style.background='#1db954';this.style.transform=''">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="currentColor">
                                        <path
                                            d="M12 0C5.4 0 0 5.4 0 12s5.4 12 12 12 12-5.4 12-12S18.66 0 12 0zm5.521 17.34c-.24.359-.66.48-1.021.24-2.82-1.74-6.36-2.101-10.561-1.141-.418.122-.779-.179-.899-.539-.12-.421.18-.78.54-.9 4.56-1.021 8.52-.6 11.64 1.32.42.18.479.659.301 1.02zm1.44-3.3c-.301.42-.841.6-1.262.3-3.239-1.98-8.159-2.58-11.939-1.38-.479.12-1.02-.12-1.14-.6-.12-.48.12-1.021.6-1.141C9.6 9.9 15 10.561 18.72 12.84c.361.181.54.78.241 1.2zm.12-3.36C15.24 8.4 8.82 8.16 5.16 9.301c-.6.179-1.2-.181-1.38-.721-.18-.601.18-1.2.72-1.381 4.26-1.26 11.28-1.02 15.721 1.621.539.3.719 1.02.419 1.56-.299.421-1.02.599-1.559.3z" />
                                    </svg>
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