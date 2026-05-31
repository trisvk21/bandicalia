<x-app-layout>
    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-10">

        <div class="flex items-center justify-between mb-8">
            <h1 style="font-family:'Playfair Display',serif; font-size:2rem; font-weight:900; color:var(--beige);">
                Anuncios de bandas
            </h1>
            @auth
                @if(auth()->user()->account_type === 'band')
                    <a href="{{ route('ads.create') }}"
                       style="padding:.5rem 1.25rem; background:var(--red); color:#fff; border-radius:10px; font-size:.85rem; font-weight:600; text-decoration:none; transition:background .2s;"
                       onmouseover="this.style.background='var(--salmon)'" onmouseout="this.style.background='var(--red)'">
                        + Publicar anuncio
                    </a>
                @endif
            @endauth
        </div>

        @if($ads->isEmpty())
            <div style="text-align:center; padding:5rem 1rem; color:var(--muted);">
                <div style="font-size:3rem; margin-bottom:1rem;">📢</div>
                <p style="font-size:1.1rem;">No hay anuncios publicados todavía.</p>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:1.25rem;">
                @foreach($ads as $ad)
                    <a href="{{ route('ads.show', $ad) }}"
                       style="background:var(--mid); border-radius:20px; padding:1.5rem; border:1px solid {{ auth()->id() === $ad->user_id ? 'rgba(255,55,55,.4)' : 'rgba(255,193,147,.15)' }}; text-decoration:none; display:block; transition:border-color .2s, transform .2s;"
                       onmouseover="this.style.borderColor='rgba(255,55,55,.4)'; this.style.transform='translateY(-2px)'"
                       onmouseout="this.style.borderColor='{{ auth()->id() === $ad->user_id ? 'rgba(255,55,55,.4)' : 'rgba(255,193,147,.15)' }}'; this.style.transform=''">

                        @if(auth()->id() === $ad->user_id)
                            <span style="display:inline-block; font-size:.72rem; font-weight:600; padding:.2rem .65rem; border-radius:999px; background:rgba(255,55,55,.1); color:var(--red); border:1px solid rgba(255,55,55,.2); margin-bottom:.75rem;">
                                Tu anuncio
                            </span>
                        @endif

                        <h2 style="font-family:'Playfair Display',serif; font-size:1.2rem; font-weight:700; color:var(--beige); margin-bottom:.5rem;">
                            {{ $ad->title }}
                        </h2>
                        <p style="color:rgba(255,237,206,.55); font-size:.88rem; line-height:1.6; display:-webkit-box; -webkit-line-clamp:3; -webkit-box-orient:vertical; overflow:hidden;">
                            {{ $ad->body }}
                        </p>

                        <div style="display:flex; align-items:center; justify-content:space-between; margin-top:1.25rem; padding-top:1rem; border-top:1px solid rgba(255,193,147,.1);">
                            <div style="display:flex; align-items:center; gap:.75rem;">
                                @if($ad->user->photo)
                                    <img src="{{ Storage::url($ad->user->photo) }}"
                                         style="width:32px; height:32px; border-radius:8px; object-fit:cover; border:1px solid rgba(255,55,55,.2);">
                                @else
                                    <div style="width:32px; height:32px; border-radius:8px; background:linear-gradient(135deg,var(--red),var(--salmon)); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-size:.85rem; font-weight:700; color:#fff;">
                                        {{ strtoupper(substr($ad->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span style="font-size:.85rem; color:rgba(255,237,206,.6);">{{ $ad->user->username }}</span>
                                @if($ad->user->city)
                                    <span style="font-size:.78rem; color:var(--muted);">· {{ $ad->user->city }}</span>
                                @endif
                            </div>
                            <span style="font-size:.75rem; color:var(--muted);">{{ $ad->created_at->diffForHumans() }}</span>
                        </div>

                    </a>
                @endforeach
            </div>

            <div style="margin-top:2.5rem; display:flex; justify-content:center;">
                {{ $ads->links() }}
            </div>
        @endif

    </main>
</x-app-layout>