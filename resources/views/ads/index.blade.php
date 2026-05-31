<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Anuncios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans min-h-screen flex flex-col" style="background:var(--dark, #1a0a00);">

    @include('layouts.navigation')

    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-10">

        <div class="flex items-center justify-between mb-8">
            <h1 style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:#FFEDCE;">
                Anuncios de bandas
            </h1>
            @auth
                @if(auth()->user()->account_type === 'band')
                    <a href="{{ route('ads.create') }}"
                       style="padding:.5rem 1.25rem; background:#FF3737; color:#fff; border-radius:10px; font-size:.85rem; font-weight:600; text-decoration:none; transition:background .2s;"
                       onmouseover="this.style.background='#FF8383'" onmouseout="this.style.background='#FF3737'">
                        + Publicar anuncio
                    </a>
                @endif
            @endauth
        </div>

        @if($ads->isEmpty())
            <div style="text-align:center; padding:5rem 1rem; color:#a0704a;">
                <div style="font-size:3rem; margin-bottom:1rem;">📢</div>
                <p style="font-size:1.1rem;">No hay anuncios publicados todavía.</p>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:1.25rem;">
                @foreach($ads as $ad)
    <a href="{{ route('ads.show', $ad) }}"
       style="background:#2e1500; border-radius:20px; padding:1.5rem; border:1px solid {{ auth()->id() === $ad->user_id ? 'rgba(255,55,55,.4)' : 'rgba(255,193,147,.15)' }}; text-decoration:none; display:block; transition:border-color .2s, transform .2s;"
       onmouseover="this.style.borderColor='rgba(255,55,55,.4)'; this.style.transform='translateY(-2px)'"
       onmouseout="this.style.borderColor='{{ auth()->id() === $ad->user_id ? 'rgba(255,55,55,.4)' : 'rgba(255,193,147,.15)' }}'; this.style.transform=''">

        @if(auth()->id() === $ad->user_id)
            <span style="display:inline-block; font-size:.72rem; font-weight:600; padding:.2rem .65rem; border-radius:999px; background:rgba(255,55,55,.1); color:#FF3737; border:1px solid rgba(255,55,55,.2); margin-bottom:.75rem;">
                Tu anuncio
            </span>
        @endif


                        <!-- Título y cuerpo -->
                        <h2 style="font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:#FFEDCE; margin-bottom:.5rem;">
                            {{ $ad->title }}
                        </h2>
                        <p style="color:rgba(255,237,206,.55); font-size:.88rem; line-height:1.6; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">
                            {{ $ad->body }}
                        </p>

                        <!-- Footer de la tarjeta -->
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:1.25rem; padding-top:1rem; border-top:1px solid rgba(255,193,147,.1);">
                            <div style="display:flex; align-items:center; gap:.75rem;">
                                @if($ad->user->photo)
                                    <img src="{{ Storage::url($ad->user->photo) }}"
                                         style="width:32px; height:32px; border-radius:8px; object-fit:cover; border:1px solid rgba(255,55,55,.2);">
                                @else
                                    <div style="width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg,#FF3737,#FF8383); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-size:.85rem; font-weight:700; color:#fff;">
                                        {{ strtoupper(substr($ad->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span style="font-size:.85rem; color:rgba(255,237,206,.6);">{{ $ad->user->username }}</span>
                                @if($ad->user->city)
                                    <span style="font-size:.78rem; color:#a0704a;">· {{ $ad->user->city }}</span>
                                @endif
                            </div>
                            <span style="font-size:.75rem; color:#a0704a;">{{ $ad->created_at->diffForHumans() }}</span>
                        </div>

                    </a>
                @endforeach
            </div>

            <div style="margin-top:2.5rem; display:flex; justify-content:center;">
                {{ $ads->links() }}
            </div>
        @endif

    </main>

    <footer style="text-align:center; padding:1.5rem; font-size:.8rem; color:rgba(255,237,206,.2); background:#1a0a00; border-top:1px solid rgba(255,193,147,.08);">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>