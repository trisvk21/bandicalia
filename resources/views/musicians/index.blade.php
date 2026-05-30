<x-app-layout>

    <!-- Hero -->
    <div style="background:#2e1500; padding:2rem 0; border-bottom:1px solid rgba(255,193,147,.15);">
        <div style="max-width:1280px; margin:0 auto; padding:0 3rem;">
            <h1 style="font-family:'Playfair Display',serif; font-size:clamp(2rem,3.5vw,2.8rem); font-weight:900; color:#FFEDCE; line-height:1.15;">
                Encuentra tu próximo<br><span style="color:#FFC193;">compañero de banda</span>
            </h1>
            <p style="color:#A0704A; margin-top:.4rem; font-size:.9rem;">Conecta con músicos de toda España</p>
        </div>
    </div>

    <div style="padding:2.5rem 0; max-width:1280px; margin:0 auto; display:flex; flex-direction:column; gap:3rem; padding-left:3rem; padding-right:3rem;">

        {{-- ── FILA 1: Anuncios de bandas ── --}}
        <section>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
                <h2 style="font-family:'Playfair Display',serif; font-weight:700; font-size:1.3rem; color:#1A0A00;">Anuncios de bandas</h2>
                <a href="#" style="font-size:.72rem; color:#A0704A; font-weight:600; letter-spacing:.08em; text-transform:uppercase; text-decoration:none;">Ver más →</a>
            </div>
            @if($ads->isEmpty())
                <div style="background:#fff8f0; border:1.5px dashed rgba(255,193,147,.4); border-radius:16px; padding:2rem; text-align:center; color:#A0704A; font-size:.9rem;">
                    No hay anuncios publicados aún.
                </div>
            @else
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem;">
                    @foreach($ads->take(3) as $ad)
                        <a href="{{ route('profile.show', $ad->user->username) }}"
                            style="background:#fff8f0; border:1.5px solid rgba(255,193,147,.3); border-radius:20px; display:flex; flex-direction:column; overflow:hidden; text-decoration:none; color:#3d1f00; transition:transform .2s, box-shadow .2s;"
                            onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(255,55,55,.1)';this.style.borderColor='#FF8383'"
                            onmouseout="this.style.transform='';this.style.boxShadow='';this.style.borderColor='rgba(255,193,147,.3)'">
                            <div style="height:4px; background:linear-gradient(90deg,#FF3737,#FF8383);"></div>
                            <div style="padding:1.4rem; display:flex; flex-direction:column; gap:.75rem; flex:1;">
                                <!-- Banda -->
                                <div style="display:flex; align-items:center; gap:.75rem;">
                                    @if($ad->user->photo)
                                        <img src="{{ Storage::url($ad->user->photo) }}"
                                            style="width:48px;height:48px;border-radius:12px;object-fit:cover;flex-shrink:0;"
                                            alt="{{ $ad->user->name }}">
                                    @else
                                        <div style="width:48px;height:48px;border-radius:12px;flex-shrink:0;background:linear-gradient(135deg,#FF3737,#FF8383);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:700;font-size:1.2rem;color:#fff;">
                                            {{ strtoupper(substr($ad->user->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p style="font-weight:700; font-size:.9rem; color:#1A0A00;">{{ $ad->user->full_name ?? $ad->user->name }}</p>
                                        @if($ad->user->city)
                                            <p style="font-size:.75rem; color:#A0704A;">{{ $ad->user->city }}</p>
                                        @endif
                                    </div>
                                </div>
                                <!-- Título -->
                                <p style="font-weight:700; font-size:1rem; color:#1A0A00; line-height:1.3;">{{ $ad->title }}</p>
                                <!-- Cuerpo -->
                                <p style="font-size:.83rem; color:#A0704A; line-height:1.5; display:-webkit-box; -webkit-line-clamp:4; -webkit-box-orient:vertical; overflow:hidden;">{{ $ad->body }}</p>
                                <!-- Géneros de la banda -->
                                @if($ad->user->genres->isNotEmpty())
                                    <div style="display:flex;flex-wrap:wrap;gap:.35rem;">
                                        @foreach($ad->user->genres->take(3) as $genre)
                                            <span style="font-size:.7rem;font-weight:600;padding:.25rem .65rem;border-radius:999px;background:rgba(255,55,55,.08);color:#b92b2b;border:1px solid rgba(255,55,55,.2);">{{ $genre->name }}</span>
                                        @endforeach
                                    </div>
                                @endif
                            </div>
                            <div style="padding:.75rem 1.4rem; border-top:1px solid rgba(255,193,147,.2);">
                                <p style="font-size:.72rem; color:#A0704A;">{{ $ad->created_at->diffForHumans() }}</p>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- ── FILA 2: Músicos cerca de ti ── --}}
        <section>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
                <h2 style="font-family:'Playfair Display',serif; font-weight:700; font-size:1.3rem; color:#1A0A00;">Músicos cerca de ti</h2>
                <a href="#" style="font-size:.72rem; color:#A0704A; font-weight:600; letter-spacing:.08em; text-transform:uppercase; text-decoration:none;">Ver más →</a>
            </div>
            @if($featuredMusicians->isEmpty())
                <div style="background:#fff8f0; border:1.5px dashed rgba(255,193,147,.4); border-radius:16px; padding:2rem; text-align:center; color:#A0704A; font-size:.9rem;">
                    No hay músicos registrados aún.
                </div>
            @else
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.5rem;">
                    @foreach($featuredMusicians->take(3) as $musician)
                        <a href="{{ route('profile.show', $musician->username) }}"
                            style="background:#fff8f0; border:1.5px solid rgba(255,193,147,.3); border-radius:22px; display:flex; flex-direction:column; overflow:hidden; text-decoration:none; color:#3d1f00; transition:transform .2s, box-shadow .2s;"
                            onmouseover="this.style.transform='translateY(-5px)';this.style.boxShadow='0 16px 40px rgba(255,55,55,.12)';this.style.borderColor='#FF8383'"
                            onmouseout="this.style.transform='';this.style.boxShadow='';this.style.borderColor='rgba(255,193,147,.3)'">
                            <div style="height:5px; background:linear-gradient(90deg,#FFC193,#FF8383);"></div>
                            <div style="padding:1.75rem; display:flex; flex-direction:column; gap:1.1rem; flex:1;">

                                <!-- Header: avatar + nombre + username -->
                                <div style="display:flex; align-items:center; gap:1rem;">
                                    @if($musician->photo)
                                        <img src="{{ Storage::url($musician->photo) }}"
                                            style="width:68px;height:68px;border-radius:16px;object-fit:cover;flex-shrink:0;border:2px solid rgba(255,193,147,.5);"
                                            alt="{{ $musician->name }}">
                                    @else
                                        <div style="width:68px;height:68px;border-radius:16px;flex-shrink:0;background:linear-gradient(135deg,#FFC193,#FF3737);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:700;font-size:1.75rem;color:#fff;">
                                            {{ strtoupper(substr($musician->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p style="font-weight:700; font-size:1.05rem; color:#1A0A00; line-height:1.2;">{{ $musician->full_name ?? $musician->name }}</p>
                                        <p style="font-size:.8rem; color:#A0704A; margin-top:.2rem;">{{ '@'.$musician->username }}</p>
                                        @if($musician->city)
                                            <p style="font-size:.78rem; color:#A0704A; margin-top:.25rem; display:flex; align-items:center; gap:.3rem;">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:.5;flex-shrink:0"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                                {{ $musician->city }}
                                            </p>
                                        @endif
                                    </div>
                                </div>

                                <!-- Píldoras: edad + nivel -->
                                @if($musician->age || $musician->general_level)
                                    <div style="display:flex; gap:.5rem; flex-wrap:wrap;">
                                        @if($musician->age)
                                            <span style="font-size:.78rem; font-weight:600; padding:.3rem .8rem; border-radius:999px; background:rgba(255,193,147,.15); color:#7a3b10; border:1px solid rgba(255,193,147,.3);">
                                                {{ $musician->age }} años
                                            </span>
                                        @endif
                                        @if($musician->general_level)
                                            @php
                                                $levels = [1=>'Principiante',2=>'Básico',3=>'Intermedio',4=>'Avanzado',5=>'Profesional'];
                                                $levelLabel = $levels[$musician->general_level] ?? 'N/D';
                                            @endphp
                                            <span style="font-size:.78rem; font-weight:600; padding:.3rem .8rem; border-radius:999px; background:rgba(255,55,55,.07); color:#b92b2b; border:1px solid rgba(255,55,55,.18);">
                                                {{ $levelLabel }}
                                            </span>
                                        @endif
                                    </div>
                                @endif

                                <!-- Bio -->
                                @if($musician->bio)
                                    <p style="font-size:.83rem; color:#6b3f1a; line-height:1.55; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $musician->bio }}</p>
                                @endif

                                <!-- Géneros -->
                                @if($musician->genres->isNotEmpty())
                                    <div>
                                        <p style="font-size:.68rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#A0704A; margin-bottom:.4rem;">Géneros</p>
                                        <div style="display:flex;flex-wrap:wrap;gap:.4rem;">
                                            @foreach($musician->genres->take(4) as $genre)
                                                <span style="font-size:.74rem;font-weight:600;padding:.28rem .7rem;border-radius:999px;background:rgba(255,55,55,.08);color:#b92b2b;border:1px solid rgba(255,55,55,.2);">{{ $genre->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                                <!-- Instrumentos -->
                                @if($musician->instruments->isNotEmpty())
                                    <div>
                                        <p style="font-size:.68rem; font-weight:700; letter-spacing:.08em; text-transform:uppercase; color:#A0704A; margin-bottom:.4rem;">Instrumentos</p>
                                        <div style="display:flex;flex-wrap:wrap;gap:.4rem;">
                                            @foreach($musician->instruments->take(4) as $instrument)
                                                <span style="font-size:.74rem;font-weight:600;padding:.28rem .7rem;border-radius:999px;background:rgba(255,193,147,.2);color:#7a3b10;border:1px solid rgba(255,193,147,.38);">{{ $instrument->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif

                            </div>

                            <!-- Footer: estado banda -->
                            <div style="padding:1rem 1.75rem; border-top:1px solid rgba(255,193,147,.25); display:flex; align-items:center; justify-content:space-between;">
                                @if($musician->has_band)
                                    <span style="font-size:.8rem;font-weight:700;padding:.4rem 1rem;border-radius:10px;display:inline-flex;align-items:center;gap:.5rem;background:rgba(34,197,94,.1);color:#15803d;border:1px solid rgba(34,197,94,.25);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                        Ya tiene banda
                                    </span>
                                @else
                                    <span style="font-size:.8rem;font-weight:700;padding:.4rem 1rem;border-radius:10px;display:inline-flex;align-items:center;gap:.5rem;background:rgba(255,55,55,.1);color:#c0392b;border:1px solid rgba(255,55,55,.2);">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                        Busca banda
                                    </span>
                                @endif
                                <span style="font-size:.8rem; color:#A0704A; opacity:.6;">→</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- ── FILA 3: Bandas cerca de ti ── --}}
        <section>
            <div style="display:flex; align-items:center; justify-content:space-between; margin-bottom:1.25rem;">
                <h2 style="font-family:'Playfair Display',serif; font-weight:700; font-size:1.3rem; color:#1A0A00;">Bandas cerca de ti</h2>
                <a href="#" style="font-size:.72rem; color:#A0704A; font-weight:600; letter-spacing:.08em; text-transform:uppercase; text-decoration:none;">Ver más →</a>
            </div>
            @if($featuredBands->isEmpty())
                <div style="background:#fff8f0; border:1.5px dashed rgba(255,193,147,.4); border-radius:16px; padding:2rem; text-align:center; color:#A0704A; font-size:.9rem;">
                    No hay bandas registradas aún.
                </div>
            @else
                <div style="display:grid; grid-template-columns:repeat(3,1fr); gap:1.25rem;">
                    @foreach($featuredBands->take(3) as $band)
                        <a href="{{ route('profile.show', $band->username) }}"
                            style="background:#fff8f0; border:1.5px solid rgba(255,193,147,.3); border-radius:20px; display:flex; flex-direction:column; overflow:hidden; text-decoration:none; color:#3d1f00; transition:transform .2s, box-shadow .2s;"
                            onmouseover="this.style.transform='translateY(-4px)';this.style.boxShadow='0 12px 32px rgba(255,55,55,.1)';this.style.borderColor='#FF8383'"
                            onmouseout="this.style.transform='';this.style.boxShadow='';this.style.borderColor='rgba(255,193,147,.3)'">
                            <div style="height:4px; background:linear-gradient(90deg,#FF3737,#FF8383);"></div>
                            <div style="padding:1.4rem; display:flex; flex-direction:column; gap:.85rem; flex:1;">
                                <!-- Header -->
                                <div style="display:flex; align-items:center; gap:.85rem;">
                                    @if($band->photo)
                                        <img src="{{ Storage::url($band->photo) }}"
                                            style="width:56px;height:56px;border-radius:14px;object-fit:cover;flex-shrink:0;border:2px solid rgba(255,193,147,.4);"
                                            alt="{{ $band->name }}">
                                    @else
                                        <div style="width:56px;height:56px;border-radius:14px;flex-shrink:0;background:linear-gradient(135deg,#FF3737,#FF8383);display:flex;align-items:center;justify-content:center;font-family:'Playfair Display',serif;font-weight:700;font-size:1.4rem;color:#fff;">
                                            {{ strtoupper(substr($band->name, 0, 1)) }}
                                        </div>
                                    @endif
                                    <div>
                                        <p style="font-weight:700; font-size:1rem; color:#1A0A00; line-height:1.2;">{{ $band->full_name ?? $band->name }}</p>
                                        <p style="font-size:.78rem; color:#A0704A; margin-top:.15rem;">{{ '@'.$band->username }}</p>
                                    </div>
                                </div>
                                <!-- Ciudad -->
                                @if($band->city)
                                    <p style="font-size:.82rem; color:#A0704A; display:flex; align-items:center; gap:.4rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" style="opacity:.6;flex-shrink:0"><path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/></svg>
                                        {{ $band->city }}
                                    </p>
                                @endif
                                <!-- Bio -->
                                @if($band->bio)
                                    <p style="font-size:.82rem; color:#A0704A; line-height:1.5; display:-webkit-box; -webkit-line-clamp:2; -webkit-box-orient:vertical; overflow:hidden;">{{ $band->bio }}</p>
                                @endif
                                <!-- Géneros -->
                                @if($band->genres->isNotEmpty())
                                    <div>
                                        <p style="font-size:.68rem; font-weight:700; letter-spacing:.07em; text-transform:uppercase; color:#A0704A; margin-bottom:.35rem;">Géneros</p>
                                        <div style="display:flex;flex-wrap:wrap;gap:.35rem;">
                                            @foreach($band->genres->take(3) as $genre)
                                                <span style="font-size:.72rem;font-weight:600;padding:.25rem .65rem;border-radius:999px;background:rgba(255,55,55,.08);color:#b92b2b;border:1px solid rgba(255,55,55,.2);">{{ $genre->name }}</span>
                                            @endforeach
                                        </div>
                                    </div>
                                @endif
                                <!-- Anuncios activos -->
                                @if($band->ads->isNotEmpty())
                                    <div style="display:flex;align-items:center;gap:.4rem;">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" style="color:#FF3737;flex-shrink:0"><path d="M14 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V8z"/><polyline points="14 2 14 8 20 8"/></svg>
                                        <p style="font-size:.78rem;color:#b92b2b;font-weight:600;">{{ $band->ads->count() }} anuncio(s) activo(s)</p>
                                    </div>
                                @endif
                            </div>
                            <div style="padding:.85rem 1.4rem; border-top:1px solid rgba(255,193,147,.2);">
                                <span style="font-size:.75rem;font-weight:700;padding:.3rem .8rem;border-radius:8px;background:rgba(255,193,147,.15);color:#9a3a00;border:1px solid rgba(255,193,147,.35);">Banda</span>
                            </div>
                        </a>
                    @endforeach
                </div>
            @endif
        </section>

    </div>

</x-app-layout>