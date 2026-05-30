<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — {{ $ad->title }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="font-sans min-h-screen flex flex-col" style="background:#1a0a00;">

    @include('layouts.navigation')

    <main class="flex-1"
        style="width:100%; display:flex; justify-content:center; padding:2.5rem 1.5rem; box-sizing:border-box;">
        <div style="width:100%; max-width:760px;">

            <a href="{{ route('ads.index') }}"
                style="display:inline-flex; align-items:center; gap:.4rem; color:#a0704a; font-size:.85rem; text-decoration:none; margin-bottom:1.5rem; transition:color .2s;"
                onmouseover="this.style.color='#FFC193'" onmouseout="this.style.color='#a0704a'">
                ← Volver a anuncios
            </a>

            @if(session('success'))
                <div
                    style="background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.25); color:#16a34a; padding:.85rem 1.25rem; border-radius:12px; font-size:.9rem; margin-bottom:1.5rem;">
                    {{ session('success') }}
                </div>
            @endif
            @if(session('error'))
                <div
                    style="background:rgba(255,55,55,.1); border:1px solid rgba(255,55,55,.25); color:#FF3737; padding:.85rem 1.25rem; border-radius:12px; font-size:.9rem; margin-bottom:1.5rem;">
                    {{ session('error') }}
                </div>
            @endif

            <!-- Contenido del anuncio -->
            <div
                style="background:#2e1500; border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15); margin-bottom:1.5rem;">
                <h1
                    style="font-family:'Playfair Display',serif; font-size:1.9rem; font-weight:900; color:#FFEDCE; margin-bottom:1rem;">
                    {{ $ad->title }}
                </h1>
                <p style="color:rgba(255,237,206,.7); font-size:.95rem; line-height:1.75;">
                    {{ $ad->body }}
                </p>
            </div>

            <!-- Info de la banda -->
            <a href="{{ route('profile.show', $ad->user->username) }}"
                style="background:#2e1500; border-radius:20px; padding:1.5rem; border:1px solid rgba(255,193,147,.15); margin-bottom:1.5rem; display:flex; align-items:center; gap:1.25rem; text-decoration:none; transition:border-color .2s;"
                onmouseover="this.style.borderColor='#FFC193'"
                onmouseout="this.style.borderColor='rgba(255,193,147,.15)'">
                <div
                    style="width:52px; height:52px; border-radius:12px; background:linear-gradient(135deg,#FFC193,#FF3737); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-size:1.3rem; font-weight:700; color:#fff; flex-shrink:0;">
                    {{ strtoupper(substr($ad->user->name, 0, 1)) }}
                </div>
                <div style="flex:1;">
                    <p style="font-weight:700; color:#FFEDCE; font-size:1rem;">{{ $ad->user->username }}</p>
                    <div style="font-size:.82rem; color:#a0704a; margin-top:.2rem;">
                        {{ $ad->user->city ?? 'Sin ubicación' }} · Publicado {{ $ad->created_at->diffForHumans() }}
                    </div>
                    @if($ad->user->genres->isNotEmpty())
                        <div style="display:flex; flex-wrap:wrap; gap:.4rem; margin-top:.6rem;">
                            @foreach($ad->user->genres->take(4) as $genre)
                                <span
                                    style="font-size:.75rem; font-weight:600; padding:.25rem .7rem; border-radius:999px; background:rgba(255,131,131,.15); color:#c0392b; border:1px solid rgba(255,131,131,.3);">
                                    {{ $genre->name }}
                                </span>
                            @endforeach
                        </div>
                    @endif
                </div>
                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor" stroke-width="2" style="color:#a0704a; flex-shrink:0;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 4.5l7.5 7.5-7.5 7.5" />
                </svg>
            </a>

            <!-- Formulario de solicitud -->
            @auth
                @if(auth()->id() === $ad->user_id)
                    <div
                        style="background:#2e1500; border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15); text-align:center;">
                        <p style="color:#a0704a; font-size:.9rem; margin-bottom:1rem;">Este es tu anuncio.</p>
                        <a href="{{ route('ads.applications', $ad) }}"
                            style="display:inline-block; padding:.7rem 1.75rem; background:#FF3737; color:#fff; border-radius:10px; font-weight:600; font-size:.9rem; text-decoration:none; transition:background .2s;"
                            onmouseover="this.style.background='#FF8383'" onmouseout="this.style.background='#FF3737'">
                            Ver solicitudes ({{ $ad->applications->count() }})
                        </a>
                    </div>
                @elseif($alreadyApplied)
                    <div style="background:#2e1500; border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15);">
                        <div
                            style="text-align:center; padding:1.5rem; color:#a0704a; font-size:.9rem; border:1.5px dashed rgba(255,193,147,.2); border-radius:12px;">
                            ✅ Ya has enviado una solicitud para este anuncio. La banda recibirá tu mensaje pronto.
                        </div>
                    </div>
                @else
                    <div style="background:#2e1500; border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15);">
                        <h2
                            style="font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:#FFEDCE; margin-bottom:1rem;">
                            Enviar solicitud a la banda
                        </h2>
                        <form method="POST" action="{{ route('ads.apply', $ad) }}">
                            @csrf
                            <textarea name="message"
                                style="width:100%; background:#1a0a00; border:1.5px solid rgba(255,193,147,.2); border-radius:12px; padding:.85rem 1rem; color:#FFEDCE; font-family:'DM Sans',sans-serif; font-size:.9rem; resize:vertical; min-height:120px; box-sizing:border-box; transition:border-color .2s;"
                                placeholder="Preséntate, cuéntales qué instrumento tocas, tu experiencia y por qué encajarías en la banda..."
                                onfocus="this.style.borderColor='#FF3737'"
                                onblur="this.style.borderColor='rgba(255,193,147,.2)'"></textarea>
                            @error('message')
                                <p style="color:#FF3737; font-size:.82rem; margin-top:.4rem;">{{ $message }}</p>
                            @enderror
                            <button type="submit"
                                style="margin-top:1rem; padding:.75rem 2rem; background:#FF3737; color:#fff; border:none; border-radius:10px; font-family:'DM Sans',sans-serif; font-weight:700; font-size:.95rem; cursor:pointer; width:100%; transition:background .2s;"
                                onmouseover="this.style.background='#FF8383'" onmouseout="this.style.background='#FF3737'">
                                Enviar solicitud →
                            </button>
                        </form>
                    </div>
                @endif
            @else
                <div
                    style="background:#2e1500; border-radius:20px; padding:2rem; border:1px solid rgba(255,193,147,.15); text-align:center; font-size:.9rem;">
                    <a href="{{ route('login') }}" style="color:#FFC193;">Inicia sesión</a>
                    <span style="color:#a0704a;"> para enviar una solicitud a esta banda.</span>
                </div>
            @endauth

        </div>
    </main>

    <footer
        style="text-align:center; padding:1.5rem; font-size:.8rem; color:rgba(255,237,206,.2); background:#1a0a00; border-top:1px solid rgba(255,193,147,.08);">
        © 2026 Bandicalia — TFG
    </footer>

</body>

</html>