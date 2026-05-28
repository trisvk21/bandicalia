<x-app-layout>
<style>
    /* ── HERO ── */
    .hero-strip {
        background: var(--mid);
        padding: 2.5rem 3rem 2rem;
        border-bottom: 1px solid rgba(255,193,147,.15);
    }
    .hero-strip h1 {
        font-family: 'Playfair Display', serif;
        font-size: clamp(2rem, 4vw, 3.2rem);
        font-weight: 900;
        color: var(--beige);
        line-height: 1.1;
    }
    .hero-strip h1 span { color: var(--orange); }
    .hero-strip p { color: var(--muted); margin-top: .5rem; font-size: .95rem; }

    /* ── FILTROS ── */
    .filter-wrap { padding: 0 3rem; transform: translateY(-1.5rem); }
    .filter-card {
        background: var(--dark);
        border-radius: 16px;
        padding: 1.25rem 1.75rem;
        display: grid;
        grid-template-columns: 1fr 1fr 1fr 1fr auto;
        gap: 1rem;
        align-items: center;
        border: 1px solid rgba(255,131,131,.15);
        box-shadow: 0 8px 32px rgba(0,0,0,.25);
    }
    @media (max-width: 900px) {
        .filter-card { grid-template-columns: 1fr 1fr; }
        .filter-wrap { padding: 0 1.5rem; }
    }
    .filter-input {
        background: var(--mid);
        border: 1.5px solid rgba(255,193,147,.2);
        border-radius: 10px;
        padding: .6rem 1rem;
        color: var(--beige);
        font-family: 'DM Sans', sans-serif;
        font-size: .9rem;
        transition: border-color .2s;
        width: 100%;
    }
    .filter-input::placeholder { color: var(--muted); }
    .filter-input:focus { outline: none; border-color: var(--orange); }
    select.filter-input option { background: var(--mid); color: var(--beige); }

    .btn-search {
        padding: .65rem 1.75rem;
        background: var(--red);
        color: #fff;
        border: none;
        border-radius: 10px;
        font-family: 'DM Sans', sans-serif;
        font-weight: 700;
        font-size: .9rem;
        cursor: pointer;
        transition: background .2s, transform .1s;
        white-space: nowrap;
    }
    .btn-search:hover { background: var(--salmon); transform: translateY(-1px); }

    /* ── CONTENIDO ── */
    .content-wrap {
        padding: 0 3rem 3rem;
        max-width: 1280px;
        margin: 0 auto;
        width: 100%;
    }
    @media (max-width: 900px) { .content-wrap { padding: 0 1.5rem 2rem; } }

    .results-label {
        font-size: .8rem;
        color: var(--muted);
        margin-bottom: 1.5rem;
        font-weight: 600;
        letter-spacing: .08em;
        text-transform: uppercase;
    }

    /* ── GRID ── */
    .musician-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.25rem;
    }
    @media (max-width: 1024px) { .musician-grid { grid-template-columns: repeat(2, 1fr); } }
    @media (max-width: 640px)  { .musician-grid { grid-template-columns: 1fr; } }

    /* ── CARD ── */
    .musician-card {
        background: #fff8f0;
        border-radius: 20px;
        text-decoration: none;
        color: var(--text);
        display: flex;
        flex-direction: column;
        border: 1.5px solid rgba(255,193,147,.3);
        transition: transform .2s, box-shadow .2s, border-color .2s;
        overflow: hidden;
    }
    .musician-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 16px 40px rgba(255,55,55,.1);
        border-color: var(--salmon);
    }

    /* Franja superior de color */
    .card-top-bar {
        height: 4px;
        background: linear-gradient(90deg, var(--orange), var(--salmon));
    }

    .card-body {
        padding: 1.25rem 1.25rem 1rem;
        display: flex;
        flex-direction: column;
        gap: .85rem;
        flex: 1;
    }

    /* Header con avatar */
    .card-header {
        display: flex;
        align-items: center;
        gap: .85rem;
    }

    .avatar {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        object-fit: cover;
        flex-shrink: 0;
        border: 2px solid rgba(255,193,147,.4);
    }

    .avatar-placeholder {
        width: 52px;
        height: 52px;
        border-radius: 14px;
        background: linear-gradient(135deg, var(--orange), var(--red));
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 1.3rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .card-name {
        font-weight: 700;
        font-size: .95rem;
        color: var(--dark);
        line-height: 1.2;
    }
    .card-username {
        font-size: .78rem;
        color: var(--muted);
        margin-top: .15rem;
        font-weight: 500;
    }

    /* Ciudad */
    .card-city {
        font-size: .8rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: .4rem;
        font-weight: 500;
    }
    .card-city svg { flex-shrink: 0; opacity: .6; }

    /* Tags */
    .tag-section { display: flex; flex-direction: column; gap: .4rem; }
    .tag-label {
        font-size: .68rem;
        font-weight: 700;
        letter-spacing: .07em;
        text-transform: uppercase;
        color: var(--muted);
    }
    .tag-row { display: flex; flex-wrap: wrap; gap: .35rem; }

    .tag {
        font-size: .72rem;
        font-weight: 600;
        padding: .2rem .65rem;
        border-radius: 999px;
    }
    .tag-genre {
        background: rgba(255,55,55,.08);
        color: #b92b2b;
        border: 1px solid rgba(255,55,55,.2);
    }
    .tag-instrument {
        background: rgba(255,193,147,.18);
        color: #7a3b10;
        border: 1px solid rgba(255,193,147,.35);
    }

    /* Footer de la card */
    .card-footer {
        padding: .75rem 1.25rem;
        border-top: 1px solid rgba(255,193,147,.2);
        display: flex;
        align-items: center;
        justify-content: space-between;
    }

    .card-status {
        font-size: .75rem;
        font-weight: 700;
        padding: .25rem .7rem;
        border-radius: 6px;
        display: inline-flex;
        align-items: center;
        gap: .4rem;
        letter-spacing: .02em;
    }
    .status-in-band {
        background: rgba(34,197,94,.1);
        color: #15803d;
        border: 1px solid rgba(34,197,94,.2);
    }
    .status-looking {
        background: rgba(255,193,147,.15);
        color: #9a3a00;
        border: 1px solid rgba(255,193,147,.35);
    }

    .card-arrow {
        color: var(--salmon);
        opacity: 0;
        transition: opacity .2s, transform .2s;
        font-size: 1rem;
    }
    .musician-card:hover .card-arrow {
        opacity: 1;
        transform: translateX(3px);
    }

    /* ── EMPTY ── */
    .empty-state { text-align: center; padding: 5rem 1rem; color: var(--muted); }
    .empty-state p { font-size: 1.1rem; margin-top: 1rem; }

    /* ── PAGINATION ── */
    .pagination-wrap { margin-top: 3rem; display: flex; justify-content: center; }
</style>

    <!-- Hero -->
    <div class="hero-strip">
        <h1>Encuentra tu próximo<br><span>compañero de banda</span></h1>
        <p>Conecta con músicos de toda España</p>
    </div>

    <!-- Filtros -->
    <div class="filter-wrap">
        <form method="GET" action="{{ route('home') }}" class="filter-card">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o usuario..." class="filter-input">
            <input type="text" name="city" value="{{ request('city') }}" placeholder="Ciudad..." class="filter-input">
            <select name="genre" class="filter-input">
                <option value="">Todos los géneros</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
            <select name="instrument" class="filter-input">
                <option value="">Todos los instrumentos</option>
                @foreach($instruments as $instrument)
                    <option value="{{ $instrument->id }}" {{ request('instrument') == $instrument->id ? 'selected' : '' }}>{{ $instrument->name }}</option>
                @endforeach
            </select>
            <button type="submit" class="btn-search">Buscar →</button>
        </form>
    </div>

    <!-- Resultados -->
    <div class="content-wrap">
        @if($musicians->isEmpty())
            <div class="empty-state">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" style="margin: 0 auto; opacity: .4;">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <p>No se encontraron músicos con esos filtros.</p>
            </div>
        @else
            <p class="results-label">{{ $musicians->total() }} músicos encontrados</p>

            <div class="musician-grid">
                @foreach($musicians as $musician)
                    <a href="{{ route('profile.show', $musician->username) }}" class="musician-card">

                        <div class="card-top-bar"></div>

                        <div class="card-body">
                            <!-- Header -->
                            <div class="card-header">
                                @if($musician->photo)
                                    <img src="{{ Storage::url($musician->photo) }}" class="avatar" alt="{{ $musician->name }}">
                                @else
                                    <div class="avatar-placeholder">
                                        {{ strtoupper(substr($musician->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="card-name">{{ $musician->full_name ?? $musician->name }}</p>
                                    <p class="card-username">{{ '@' . $musician->username }}</p>
                                </div>
                            </div>

                            <!-- Ciudad -->
                            @if($musician->city)
                                <p class="card-city">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    {{ $musician->city }}
                                </p>
                            @endif

                            <!-- Géneros -->
                            @if($musician->genres->isNotEmpty())
                                <div class="tag-section">
                                    <span class="tag-label">Géneros</span>
                                    <div class="tag-row">
                                        @foreach($musician->genres->take(3) as $genre)
                                            <span class="tag tag-genre">{{ $genre->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            <!-- Instrumentos -->
                            @if($musician->instruments->isNotEmpty())
                                <div class="tag-section">
                                    <span class="tag-label">Instrumentos</span>
                                    <div class="tag-row">
                                        @foreach($musician->instruments->take(3) as $instrument)
                                            <span class="tag tag-instrument">{{ $instrument->name }}</span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <!-- Footer -->
                        <div class="card-footer">
                            <span class="card-status {{ $musician->has_band ? 'status-in-band' : 'status-looking' }}">
                                @if($musician->has_band)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    En banda
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    Busca banda
                                @endif
                            </span>
                            <span class="card-arrow">→</span>
                        </div>

                    </a>
                @endforeach
            </div>

            <div class="pagination-wrap">
                {{ $musicians->withQueryString()->links() }}
            </div>
        @endif
    </div>

</x-app-layout>