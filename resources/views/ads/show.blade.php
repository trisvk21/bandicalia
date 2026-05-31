<x-app-layout>
    <main class="flex-1" style="width:100%; display:flex; justify-content:center; padding:2.5rem 1.5rem; box-sizing:border-box;">
        <div style="width:100%; max-width:760px;">

            <a href="{{ route('ads.index') }}"
                style="display:inline-flex; align-items:center; gap:.4rem; color:var(--muted); font-size:.85rem; text-decoration:none; margin-bottom:1.5rem; transition:color .2s;"
                onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='var(--muted)'">
                ← Volver a anuncios
            </a>

            @if(session('success'))
                <div style="background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.25); color:#16a34a; padding:.85rem 1.25rem; border-radius:12px; font-size:.9rem; margin-bottom:1.5rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div style="background:rgba(255,55,55,.1); border:1px solid rgba(255,55,55,.25); color:var(--red); padding:.85rem 1.25rem; border-radius:12px; font-size:.9rem; margin-bottom:1.5rem;">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Contenido del anuncio -->
            <div style="background:var(--mid); border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15); margin-bottom:1.5rem;">
                <h1 style="font-family:'Playfair Display',serif; font-size:1.9rem; font-weight:900; color:var(--beige); margin-bottom:1rem;">
                    {{ $ad->title }}
                </h1>
                <p style="color:rgba(255,237,206,.7); font-size:.95rem; line-height:1.75;">
                    {{ $ad->body }}
                </p>
            </div>

            <!-- Info de la banda -->
            <a href="{{ route('profile.show', $ad->user->username) }}"
                style="background:var(--mid); border-radius:20px; padding:1.5rem; border:1px solid rgba(255,193,147,.15); margin-bottom:1.5rem; display:flex; align-items:center; gap:1.25rem; text-decoration:none; transition:border-color .2s;"
                onmouseover="this.style.borderColor='var(--orange)'"
                onmouseout="this.style.borderColor='rgba(255,193,147,.15)'">
                @if($ad->user->photo)
                    <img src="{{ Storage::url($ad->user->photo) }}"
                         style="width:52px; height:52px; border-radius:12px; object-fit:cover; border:2px solid rgba(255,55,55,.3); flex-shrink:0;">
                @else
                    <div style="width:52px; height:52px; border-radius:12px; background:linear-gradient(135deg,var(--orange),var(--red)); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:#fff; flex-shrink:0;">
                        {{ strtoupper(substr($ad->user->name, 0, 1)) }}
                    </div>
                @endif
                <div style="flex:1;">
                    <p style="font-weight:700; color:var(--beige); font-size:1rem;">{{ $ad->user->username }}</p>
                    <div style="font-size:.82rem; color:var(--muted); margin-top:.2rem;">
                        {{ $ad->user->city ?? 'Sin ubicación' }} · Publicado {{ $ad->created_at->diffForHumans() }}
                    </div>
                    @if($ad->user->genres->isNotEmpty())
                        <div style="display:flex; flex-wrap:wrap; gap:.4rem; margin-top:.6rem;">
                            @foreach($ad->user->genres->take(4) as $genre)
                                <span style="font-size:.75rem; font-weight:600; padding:.25rem .7rem; border-radius:999px; background:rgba(255,131,131,.15); color:#c0392b; border:1px solid rgba(255,131,131,.3);">
                                    {{ $genre->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" style="color:var(--muted); flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            <!-- Formulario de solicitud -->
            @auth
                @if(auth()->id() === $ad->user_id)
                    <div style="background:var(--mid); border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15); text-align:center;">
                        <p style="color:var(--muted); font-size:.9rem; margin-bottom:1rem;">Este es tu anuncio.</p>
                        <a href="{{ route('ads.applications', $ad) }}"
                            style="display:inline-block; padding:.7rem 1.75rem; background:var(--red); color:#fff; border-radius:10px; font-weight:600; font-size:.9rem; text-decoration:none; transition:background .2s;"
                            onmouseover="this.style.background='var(--salmon)'" onmouseout="this.style.background='var(--red)'">
                            Ver solicitudes ({{ $ad->applications->count() }})
                        </a>
                    </div>
                @elseif($alreadyApplied)
                    <div style="background:var(--mid); border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15);">
                        <div style="text-align:center; padding:1.5rem; color:var(--muted); font-size:.9rem; border:1.5px dashed rgba(255,193,147,.2); border-radius:12px;">
                            ✅ Ya has enviado una solicitud para este anuncio. La banda recibirá tu mensaje pronto.
                        </div>
                    </div>
                @else
                    <div style="background:var(--mid); border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15);">
                        <h2 style="font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:var(--beige); margin-bottom:1rem;">
                            Enviar solicitud a la banda
                        </h2>
                        <form method="POST" action="{{ route('ads.apply', $ad) }}">
                            @csrf
                            <textarea name="message"
                                style="width:100%; background:var(--dark); border:1.5px solid rgba(255,193,147,.2); border-radius:12px; padding:.85rem 1rem; color:var(--beige); font-family:'DM Sans',sans-serif; font-size:.9rem; resize:vertical; min-height:120px; box-sizing:border-box; transition:border-color .2s;"
                                placeholder="Preséntate, cuéntales qué instrumento tocas, tu experiencia y por qué encajarías en la banda..."
                                onfocus="this.style.borderColor='var(--red)'"
                                onblur="this.style.borderColor='rgba(255,193,147,.2)'"></textarea>
                            @error('message')
                                <p style="color:var(--red); font-size:.82rem; margin-top:.4rem;">{{ $message }}</p>
                            @enderror
                            <button type="submit"
                                style="margin-top:1rem; padding:.75rem 2rem; background:var(--red); color:#fff; border:none; border-radius:10px; font-family:'DM Sans',sans-serif; font-weight:700; font-size:.95rem; cursor:pointer; width:100%; transition:background .2s;"
                                onmouseover="this.style.background='var(--salmon)'" onmouseout="this.style.background='var(--red)'">
                                Enviar solicitud →
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <div style="background:var(--mid); border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15); text-align:center; font-size:.9rem;">
                    <a href="{{ route('login') }}" style="color:var(--orange);">Inicia sesión</a>
                    <span style="color:var(--muted);"> para enviar una solicitud a esta banda.</span>
                </div>
            @endauth

        </div>
    </main>
</x-app-layout>