<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Anuncios</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="icon" type="image/svg+xml" href="/favicon.svg">
</head>
<style>
    :root {
        --beige:  #FFEDCE;
        --orange: #FFC193;
        --salmon: #FF8383;
        --red:    #FF3737;
        --dark:   #1a0a00;
        --mid:    #2e1500;
        --muted:  #a0704a;
    }

    .bandi-nav {
        background: var(--dark);
        border-bottom: 2px solid var(--red);
        position: sticky;
        top: 0;
        z-index: 100;
        font-family: 'DM Sans', sans-serif;
    }

    .bandi-nav-inner {
        max-width: 1280px;
        margin: 0 auto;
        padding: 0 2rem;
        display: flex;
        justify-content: space-between;
        align-items: center;
        height: 64px;
    }

    .bandi-logo {
        font-family: 'Playfair Display', serif;
        font-size: 1.6rem;
        font-weight: 900;
        color: var(--orange);
        text-decoration: none;
        letter-spacing: -0.02em;
        transition: color .2s;
    }
    .bandi-logo:hover { color: var(--salmon); }

    .bandi-nav-links {
        display: flex;
        align-items: center;
        gap: 1.5rem;
    }

    .bandi-nav-link {
        color: rgba(255,237,206,.7);
        text-decoration: none;
        font-size: .9rem;
        font-weight: 500;
        transition: color .2s;
    }
    .bandi-nav-link:hover,
    .bandi-nav-link.active { color: var(--orange); }

    .bandi-nav-divider {
        width: 1px;
        height: 18px;
        background: rgba(255,193,147,.2);
    }

    .bandi-user {
        display: flex;
        align-items: center;
        gap: .6rem;
        color: rgba(255,237,206,.85);
        font-size: .88rem;
        font-weight: 500;
    }

    .bandi-user-avatar {
        width: 32px;
        height: 32px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--orange), var(--red));
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: .9rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .bandi-btn-logout {
        padding: .4rem 1rem;
        border-radius: 8px;
        border: 1.5px solid var(--salmon);
        color: var(--salmon);
        background: transparent;
        font-family: 'DM Sans', sans-serif;
        font-size: .82rem;
        font-weight: 600;
        cursor: pointer;
        transition: background .2s, color .2s;
        text-decoration: none;
        display: inline-block;
    }
    .bandi-btn-logout:hover {
        background: var(--salmon);
        color: var(--dark);
    }

    /* Campana */
    .notif-btn {
        position: relative;
        background: none;
        border: none;
        cursor: pointer;
        color: rgba(255,237,206,.7);
        padding: .35rem;
        border-radius: 8px;
        transition: color .2s, background .2s;
        display: flex;
        align-items: center;
        justify-content: center;
    }
    .notif-btn:hover {
        color: var(--orange);
        background: rgba(255,193,147,.08);
    }

    .notif-dropdown {
        position: absolute;
        top: calc(100% + 12px);
        right: 0;
        width: 320px;
        background: var(--mid);
        border: 1px solid rgba(255,131,131,.2);
        border-radius: 14px;
        box-shadow: 0 16px 48px rgba(0,0,0,.4);
        overflow: hidden;
        z-index: 200;
    }

    .notif-header {
        padding: .9rem 1.25rem;
        border-bottom: 1px solid rgba(255,193,147,.1);
        font-family: 'Playfair Display', serif;
        font-size: 1rem;
        font-weight: 700;
        color: var(--beige);
    }

    .notif-empty {
        padding: 2.5rem 1.25rem;
        text-align: center;
        color: var(--muted);
        font-size: .88rem;
    }

    .notif-empty svg {
        margin: 0 auto .75rem;
        display: block;
        opacity: .4;
    }

    /* Mobile */
    .bandi-hamburger {
        display: none;
        background: none;
        border: none;
        cursor: pointer;
        color: var(--beige);
        padding: .25rem;
    }

    .bandi-mobile-menu {
        display: none;
        background: var(--mid);
        border-top: 1px solid rgba(255,131,131,.15);
        padding: 1rem 2rem;
        flex-direction: column;
        gap: .75rem;
    }
    .bandi-mobile-menu.open { display: flex; }

    @media (max-width: 640px) {
        .F { display: none; }
        .bandi-hamburger { display: block; }
    }
</style>
<body class="bg-darker text-white min-h-screen flex flex-col">

    @include('layouts.navigation')  

    <main class="flex-1 max-w-4xl mx-auto w-full px-6 py-10">

        <div class="flex items-center justify-between mb-8">
            <h1 class="font-serif text-3xl font-extrabold text-cream">Anuncios de bandas</h1>
            @auth
                @if(auth()->user()->account_type === 'band')
                    <a href="{{ route('ads.create') }}" class="px-5 py-2 bg-brand hover:bg-coral text-white text-sm font-semibold rounded-xl transition">
                        + Publicar anuncio
                    </a>
                @endif
            @endauth
        </div>

        @if($ads->isEmpty())
            <div class="text-center py-20 text-white/30">
                <div class="text-5xl mb-4">📢</div>
                <p class="text-lg">No hay anuncios publicados todavía.</p>
            </div>
        @else
            <div class="flex flex-col gap-5">
                @foreach($ads as $ad)
                    <div class="bg-dark rounded-2xl p-6 border border-white/10 hover:border-brand/30 transition">
                        <div class="flex items-start justify-between gap-4">
                            <div class="flex-1">
                                <h2 class="font-serif text-xl font-bold text-cream mb-2">{{ $ad->title }}</h2>
                                <p class="text-white/60 text-sm leading-relaxed">{{ $ad->body }}</p>
                            </div>
                        </div>
                        <div class="flex items-center justify-between mt-5 pt-4 border-t border-white/5">
                            <a href="{{ route('profile.show', $ad->user->username) }}" class="flex items-center gap-3 hover:opacity-80 transition">
                                @if($ad->user->photo)
                                    <img src="{{ Storage::url($ad->user->photo) }}" class="w-8 h-8 rounded-xl object-cover border border-brand/20">
                                @else
                                    <div class="w-8 h-8 rounded-xl bg-brand/10 border border-brand/20 flex items-center justify-center text-xs font-bold text-brand">
                                        {{ strtoupper(substr($ad->user->name, 0, 1)) }}
                                    </div>
                                @endif
                                <span class="text-sm text-white/60 hover:text-white transition">{{ $ad->user->username }}</span>
                            </a>
                            <span class="text-xs text-white/30">{{ $ad->created_at->diffForHumans() }}</span>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="mt-10">
                {{ $ads->links() }}
            </div>
        @endif

    </main>

    <footer class="text-center text-gray-600 py-6 text-sm">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>