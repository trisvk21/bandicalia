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
    max-height: 380px;
    display: flex;
    flex-direction: column;
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
        .bandi-nav-links { display: none; }
        .bandi-hamburger { display: block; }
    }
</style>

<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@700;900&family=DM+Sans:wght@300;400;500;600&display=swap" rel="stylesheet">

<nav class="bandi-nav" x-data="{ open: false, notif: false }">
    <div class="bandi-nav-inner">
        <!-- Logo -->
        <a href="{{ route('home') }}" class="bandi-logo">BANDICALIA</a>

        <!-- Desktop links -->
        <div class="bandi-nav-links">
            <a href="{{ route('ads.index') }}" class="bandi-nav-link {{ request()->routeIs('ads.index') ? 'active' : '' }}">
                Anuncios
            </a>
            <a href="{{ route('musicos') }}" class="bandi-nav-link {{ request()->routeIs('musicos') ? 'active' : '' }}">
                Músicos
            </a>

            <a href="{{ route('bandas') }}" class="bandi-nav-link {{ request()->routeIs('bandas') ? 'active' : '' }}">
                Bandas
            </a>

            <a href="{{ route('profile.show', Auth::user()->username) }}" class="bandi-nav-link {{ request()->routeIs('profile.show') ? 'active' : '' }}">
                Mi perfil
            </a>

            <div class="bandi-nav-divider"></div>

            <!-- Campana de notificaciones -->
<div style="position: relative;">
    <button class="notif-btn" @click="notif = !notif" @click.outside="notif = false">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
        </svg>
        @php $unreadNotifs = auth()->user()->unreadNotifications->count(); @endphp
        @if($unreadNotifs > 0)
            <span style="position:absolute; top:2px; right:2px; width:8px; height:8px; background:var(--red); border-radius:50%; border:2px solid var(--dark);"></span>
        @endif
    </button>

    <!-- Dropdown -->
    <div class="notif-dropdown" x-show="notif" x-transition style="display:none;">
        <div class="notif-header">Notificaciones</div>
        @php $notifications = auth()->user()->notifications()->latest()->take(10)->get(); @endphp
        @if($notifications->isEmpty())
            <div class="notif-empty">
                <svg xmlns="http://www.w3.org/2000/svg" width="36" height="36" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M14.857 17.082a23.848 23.848 0 005.454-1.31A8.967 8.967 0 0118 9.75v-.7V9A6 6 0 006 9v.75a8.967 8.967 0 01-2.312 6.022c1.733.64 3.56 1.085 5.455 1.31m5.714 0a24.255 24.255 0 01-5.714 0m5.714 0a3 3 0 11-5.714 0" />
                </svg>
                Sin notificaciones por ahora
            </div>
        @else
        <div style="overflow-y:auto; flex:1;">
            @foreach($notifications as $notification)
    <div style="display:flex; align-items:center; gap:.75rem; padding:.85rem 1.25rem; border-bottom:1px solid rgba(255,193,147,.08);
                {{ $notification->read_at ? '' : 'background:rgba(255,55,55,.05);' }}">
        @if($notification->data['follower_photo'])
            <img src="{{ Storage::url($notification->data['follower_photo']) }}"
                 style="width:36px; height:36px; border-radius:8px; object-fit:cover; flex-shrink:0; border:1.5px solid rgba(255,55,55,.3);">
        @else
            <div style="width:36px; height:36px; border-radius:8px; background:linear-gradient(135deg,var(--orange),var(--red)); display:flex; align-items:center; justify-content:center; font-family:'Playfair Display',serif; font-weight:700; color:#fff; flex-shrink:0; font-size:.9rem;">
                {{ strtoupper(substr($notification->data['follower_username'], 0, 1)) }}
            </div>
        @endif
        <div style="flex:1;">
            <p style="color:var(--beige); font-size:.85rem; font-weight:600;">{{ $notification->data['follower_username'] }}</p>
            <p style="color:var(--muted); font-size:.78rem; margin-bottom:.5rem;">te ha enviado una solicitud de seguimiento</p>
            @php $follower = \App\Models\User::find($notification->data['follower_id']); @endphp
            @if($follower)
                <div style="display:flex; gap:.5rem;">
                    <form method="POST" action="{{ route('follow.accept', $follower) }}">
                        @csrf
                        <button style="padding:.25rem .75rem; background:var(--red); color:#fff; border:none; border-radius:6px; font-size:.75rem; font-weight:600; cursor:pointer; transition:background .2s;"
                                onmouseover="this.style.background='var(--salmon)'" onmouseout="this.style.background='var(--red)'">
                            Aceptar
                        </button>
                    </form>
                    <form method="POST" action="{{ route('follow.reject', $follower) }}">
                        @csrf
                        <button style="padding:.25rem .75rem; background:transparent; color:var(--muted); border:1px solid rgba(255,193,147,.3); border-radius:6px; font-size:.75rem; font-weight:600; cursor:pointer; transition:all .2s;"
                                onmouseover="this.style.borderColor='var(--salmon)';this.style.color='var(--salmon)'" onmouseout="this.style.borderColor='rgba(255,193,147,.3)';this.style.color='var(--muted)'">
                            Rechazar
                        </button>
                    </form>
                </div>
            @endif
            <p style="color:var(--muted); font-size:.72rem; margin-top:.35rem; opacity:.6;">{{ $notification->created_at->diffForHumans() }}</p>
        </div>
    </div>
@endforeach
</div>
            <a href="#" onclick="markAllRead(event)"
               style="display:block; text-align:center; padding:.75rem; color:var(--muted); font-size:.78rem; text-decoration:none; border-top:1px solid rgba(255,193,147,.08);"
               onmouseover="this.style.color='var(--orange)'" onmouseout="this.style.color='var(--muted)'">
                Marcar todas como leídas
            </a>
        @endif
    </div>
</div>

            <!-- Icono de chat -->
<div style="position: relative;">
    <a href="{{ route('chat.index') }}" class="notif-btn" style="text-decoration:none;" title="Mensajes">
        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="M2.25 12.76c0 1.6 1.123 2.994 2.707 3.227 1.087.16 2.185.283 3.293.369V21l4.076-4.076a1.526 1.526 0 011.037-.443 48.282 48.282 0 005.68-.494c1.584-.233 2.707-1.626 2.707-3.228V6.741c0-1.602-1.123-2.995-2.707-3.228A48.394 48.394 0 0012 3c-2.392 0-4.744.175-7.043.513C3.373 3.746 2.25 5.14 2.25 6.741v6.018z" />
        </svg>
        @php
            $unreadCount = \App\Models\Message::where('receiver_id', auth()->id())
                ->where('read', false)
                ->count();
        @endphp
        @if($unreadCount > 0)
            <span style="position:absolute; top:2px; right:2px; width:8px; height:8px; background:var(--red); border-radius:50%; border:2px solid var(--dark);"></span>
        @endif
    </a>
</div>

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
        <a href="{{ route('musicos') }}" class="bandi-nav-link">Músicos</a>
        <a href="{{ route('bandas') }}" class="bandi-nav-link">Bandas</a>
        <a href="{{ route('profile.show', Auth::user()->username) }}" class="bandi-nav-link">Mi perfil</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="bandi-btn-logout">Cerrar sesión</button>
        </form>
    </div>
</nav>