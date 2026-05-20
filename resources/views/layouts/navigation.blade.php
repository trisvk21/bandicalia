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
        .bandi-nav-links { display: none; }
        .bandi-hamburger { display: block; }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<nav class="bandi-nav" x-data="{ open: false }">
    <div class="bandi-nav-inner">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="bandi-logo">BANDICALIA</a>

        <!-- Desktop links -->
        <div class="bandi-nav-links">
            <a href="{{ route('home') }}" class="bandi-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">
                Músicos
            </a>
            <a href="{{ route('profile.edit') }}" class="bandi-nav-link {{ request()->routeIs('profile.edit') ? 'active' : '' }}">
                Mi perfil
            </a>

            <div class="bandi-nav-divider"></div>

            <div class="bandi-user">
                <div class="bandi-user-avatar">
                    {{ strtoupper(substr(Auth::user()->name, 0, 1)) }}
                </div>
                {{ Auth::user()->name }}
            </div>

            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="bandi-btn-logout">Salir</button>
            </form>
        </div>

        <!-- Hamburger (mobile) -->
        <button class="bandi-hamburger" @click="open = !open" aria-label="Menú">
            <svg width="24" height="24" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path x-show="!open" stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16"/>
                <path x-show="open" stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"/>
            </svg>
        </button>
    </div>

    <!-- Mobile menu -->
    <div class="bandi-mobile-menu" :class="{ 'open': open }">
        <a href="{{ route('home') }}" class="bandi-nav-link">Músicos</a>
        <a href="{{ route('profile.edit') }}" class="bandi-nav-link">Mi perfil</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bandi-btn-logout">Cerrar sesión</button>
        </form>
    </div>
</nav>