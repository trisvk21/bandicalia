<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Solicitudes</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans min-h-screen flex flex-col" style="background:#1a0a00;">

    @include('layouts.navigation')

    <main class="flex-1" style="width:100%; display:flex; justify-content:center; padding:2.5rem 1.5rem; box-sizing:border-box;">
    <div style="width:100%; max-width:860px;">

        <a href="{{ route('ads.show', $ad) }}"
           style="display:inline-flex; align-items:center; gap:.4rem; color:#a0704a; font-size:.85rem; text-decoration:none; margin-bottom:1.5rem; transition:color .2s;"
           onmouseover="this.style.color='#FFC193'" onmouseout="this.style.color='#a0704a'">
            ← Volver al anuncio
        </a>

        @if(session('success'))
            <div style="background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.25); color:#16a34a; padding:.85rem 1.25rem; border-radius:12px; font-size:.9rem; margin-bottom:1.5rem;">
                {{ session('success') }}
            </div>
        @endif

        <!-- Cabecera -->
        <div style="background:#2e1500; border-radius:20px; padding:1.75rem 2rem; border:1px solid rgba(255,193,147,.15); margin-bottom:1.5rem;">
            <h1 style="font-family:'Playfair Display',serif; font-size:1.6rem; font-weight:900; color:#FFEDCE; margin-bottom:.35rem;">
                Solicitudes para «{{ $ad->title }}»
            </h1>
            <p style="color:#a0704a; font-size:.88rem;">
                {{ $ad->applications->count() }} solicitud{{ $ad->applications->count() !== 1 ? 'es' : '' }} recibida{{ $ad->applications->count() !== 1 ? 's' : '' }}
            </p>
        </div>

        @if($ad->applications->isEmpty())
            <div style="background:#2e1500; border-radius:20px; padding:3rem 2rem; border:1px solid rgba(255,193,147,.15); text-align:center; color:#a0704a; font-size:.95rem;">
                Aún no hay solicitudes para este anuncio.
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:1.25rem;">
                @foreach($ad->applications as $application)
                    <div style="background:#2e1500; border-radius:20px; padding:1.5rem; border:1px solid rgba(255,193,147,.15);">

                        <!-- Músico -->
                        <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1rem;">
                            <a href="{{ route('profile.show', $application->user->username) }}"
                               style="display:flex; align-items:center; gap:.85rem; text-decoration:none; transition:opacity .2s;"
                               onmouseover="this.style.opacity='.8'" onmouseout="this.style.opacity='1'">
                                @if($application->user->photo)
                                    <img src="{{ Storage::url($application->user->photo) }}"
                                         style="width:44px; height:44px; border-radius:10px; object-fit:cover; border:1px solid rgba(255,55,55,.2);">
                                @else
                                    <div style="width:44px; height:44px; border-radius:10px; background:linear-gradient(135deg,#FFC193,#FF3737); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-size:1.1rem; font-weight:700; color:#fff; flex-shrink:0;">
                                        {{ strtoupper(substr($application->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p style="font-weight:700; color:#FFEDCE; font-size:.95rem;">{{ $application->user->username }}</p>
                                    <p style="font-size:.78rem; color:#a0704a; margin-top:.1rem;">
                                        {{ $application->user->city ?? 'Sin ciudad' }}
                                        @if($application->user->general_level)
                                            · {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$application->user->general_level] }}
                                        @endif
                                        · {{ $application->created_at->diffForHumans() }}
                                    </p>
                                </div>
                            </a>

                            <!-- Estado -->
                            @if($application->status === 'pending')
                                <span style="padding:.3rem .9rem; border-radius:999px; background:rgba(255,193,147,.1); border:1px solid rgba(255,193,147,.3); color:#FFC193; font-size:.78rem; font-weight:600;">
                                    Pendiente
                                </span>
                            @elseif($application->status === 'accepted')
                                <span style="padding:.3rem .9rem; border-radius:999px; background:rgba(34,197,94,.1); border:1px solid rgba(34,197,94,.25); color:#16a34a; font-size:.78rem; font-weight:600;">
                                    Aceptada
                                </span>
                            @else
                                <span style="padding:.3rem .9rem; border-radius:999px; background:rgba(255,55,55,.1); border:1px solid rgba(255,55,55,.2); color:#FF3737; font-size:.78rem; font-weight:600;">
                                    Rechazada
                                </span>
                            @endif
                        </div>

                        <!-- Géneros e instrumentos -->
                        <div style="display:flex; flex-wrap:wrap; gap:.4rem; margin-bottom:1rem;">
                            @foreach($application->user->genres->take(3) as $genre)
                                <span style="font-size:.72rem; font-weight:600; padding:.2rem .65rem; border-radius:999px; background:rgba(255,55,55,.08); color:#b92b2b; border:1px solid rgba(255,55,55,.2);">
                                    {{ $genre->name }}
                                </span>
                            @endforeach
                            @foreach($application->user->instruments->take(3) as $instrument)
                                <span style="font-size:.72rem; font-weight:600; padding:.2rem .65rem; border-radius:999px; background:rgba(255,193,147,.1); color:#a0704a; border:1px solid rgba(255,193,147,.25);">
                                    {{ $instrument->name }}
                                </span>
                            @endforeach
                        </div>

                        <!-- Mensaje -->
                        <div style="background:#1a0a00; border-radius:12px; padding:1rem 1.25rem; margin-bottom:1.25rem; border:1px solid rgba(255,193,147,.08);">
                            <p style="color:rgba(255,237,206,.65); font-size:.88rem; line-height:1.7; white-space:pre-wrap;">{{ $application->message }}</p>
                        </div>

                        <!-- Botones aceptar/rechazar -->
                        @if($application->status === 'pending')
                            <div style="display:flex; gap:.75rem;">
                                <form method="POST" action="{{ route('ads.applications.update', [$ad, $application]) }}" style="flex:1;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="accepted">
                                    <button type="submit"
                                        style="width:100%; padding:.65rem; background:rgba(34,197,94,.15); border:1px solid rgba(34,197,94,.3); color:#16a34a; border-radius:10px; font-family:'DM Sans',sans-serif; font-weight:600; font-size:.88rem; cursor:pointer; transition:background .2s;"
                                        onmouseover="this.style.background='rgba(34,197,94,.25)'" onmouseout="this.style.background='rgba(34,197,94,.15)'">
                                        ✓ Aceptar
                                    </button>
                                </form>
                                <form method="POST" action="{{ route('ads.applications.update', [$ad, $application]) }}" style="flex:1;">
                                    @csrf
                                    @method('PATCH')
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit"
                                        style="width:100%; padding:.65rem; background:rgba(255,55,55,.1); border:1px solid rgba(255,55,55,.2); color:#FF3737; border-radius:10px; font-family:'DM Sans',sans-serif; font-weight:600; font-size:.88rem; cursor:pointer; transition:background .2s;"
                                        onmouseover="this.style.background='rgba(255,55,55,.2)'" onmouseout="this.style.background='rgba(255,55,55,.1)'">
                                        ✕ Rechazar
                                    </button>
                                </form>
                            </div>
                        @endif

                    </div>
                @endforeach
            </div>
        @endif

    </div>
    </main>

    <footer style="text-align:center; padding:1.5rem; font-size:.8rem; color:rgba(255,237,206,.2); background:#1a0a00; border-top:1px solid rgba(255,193,147,.08);">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>