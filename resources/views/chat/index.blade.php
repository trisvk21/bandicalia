<x-app-layout>
    <main class="max-w-3xl mx-auto px-6 py-10 w-full">

        <h1 style="font-family:'Playfair Display',serif; font-size:1.8rem; font-weight:900; color:var(--beige); margin-bottom:1.5rem;">Mensajes</h1>

        @if($conversations->isEmpty())
            <div style="background:var(--mid); border-radius:16px; padding:3rem; text-align:center; border:1px solid rgba(255,193,147,.15); color:var(--muted);">
                <svg xmlns="http://www.w3.org/2000/svg" width="40" height="40" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2" style="margin:0 auto 1rem; opacity:.3; display:block;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
                </svg>
                <p style="font-size:1rem;">No tienes conversaciones aún.</p>
                <p style="font-size:.85rem; margin-top:.4rem;">Sigue a otros músicos para poder escribirles.</p>
            </div>
        @else
            <div style="display:flex; flex-direction:column; gap:.75rem;">
                @foreach($conversations as $person)
                    <a href="{{ route('chat.show', $person) }}"
                       style="background:var(--mid); border-radius:14px; padding:1rem 1.25rem; border:1px solid rgba(255,193,147,.15); display:flex; align-items:center; gap:1rem; text-decoration:none; transition:border-color .2s;"
                       onmouseover="this.style.borderColor='var(--salmon)'" onmouseout="this.style.borderColor='rgba(255,193,147,.15)'">
                        @if($person->photo)
                            <img src="{{ Storage::url($person->photo) }}" style="width:46px; height:46px; border-radius:10px; object-fit:cover; border:2px solid rgba(255,55,55,.3); flex-shrink:0;">
                        @else
                            <div style="width:46px; height:46px; border-radius:10px; background:linear-gradient(135deg,var(--orange),var(--red)); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-weight:700; color:#fff; flex-shrink:0;">
                                {{ strtoupper(substr($person->name, 0, 1)) }}
                            </div>
                        @endif
                        <div style="flex:1;">
                            <p style="font-weight:600; color:var(--beige); font-size:.95rem;">{{ $person->username }}</p>
                            @if($person->city)<p style="color:var(--muted); font-size:.78rem;">{{ $person->city }}</p>@endif
                        </div>
                        <span style="color:var(--muted); font-size:.85rem;">→</span>
                    </a>
                @endforeach
            </div>
        @endif

    </main>
</x-app-layout>