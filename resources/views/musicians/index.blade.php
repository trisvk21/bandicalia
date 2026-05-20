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

    .hero-strip h1 span {
        color: var(--orange);
    }

    .hero-strip p {
        color: var(--muted);
        margin-top: .5rem;
        font-size: .95rem;
    }

    /* ── FILTER CARD ── */
    .filter-wrap {
        padding: 0 3rem;
        transform: translateY(-1.5rem);
    }

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
    .filter-input:focus {
        outline: none;
        border-color: var(--orange);
    }
    select.filter-input option {
        background: var(--mid);
        color: var(--beige);
    }

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
    .btn-search:hover {
        background: var(--salmon);
        transform: translateY(-1px);
    }

    /* ── MAIN ── */
    .content-wrap {
        padding: 0 3rem 3rem;
        max-width: 1280px;
        margin: 0 auto;
        width: 100%;
    }

    @media (max-width: 900px) {
        .content-wrap { padding: 0 1.5rem 2rem; }
    }

    .results-label {
        font-size: .85rem;
        color: var(--muted);
        margin-bottom: 1.5rem;
        font-weight: 500;
        letter-spacing: .03em;
        text-transform: uppercase;
    }

    /* ── GRID: 3 columnas ── */
    .musician-grid {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 1.5rem;
    }

    @media (max-width: 1024px) {
        .musician-grid { grid-template-columns: repeat(2, 1fr); }
    }
    @media (max-width: 640px) {
        .musician-grid { grid-template-columns: 1fr; }
    }

    /* ── CARD ── */
    .musician-card {
        background: #fff8f0;
        border-radius: 18px;
        padding: 1.5rem;
        text-decoration: none;
        color: var(--text);
        display: flex;
        flex-direction: column;
        gap: .9rem;
        border: 1.5px solid rgba(255,193,147,.35);
        transition: transform .2s, box-shadow .2s, border-color .2s;
        position: relative;
        overflow: hidden;
    }

    .musician-card::before {
        content: '';
        position: absolute;
        top: 0; left: 0; right: 0;
        height: 3px;
        background: linear-gradient(90deg, var(--orange), var(--salmon));
        opacity: 0;
        transition: opacity .2s;
    }

    .musician-card:hover {
        transform: translateY(-4px);
        box-shadow: 0 12px 36px rgba(255,55,55,.12);
        border-color: var(--salmon);
    }
    .musician-card:hover::before { opacity: 1; }

    .card-header {
        display: flex;
        align-items: center;
        gap: 1rem;
    }

    .avatar {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        object-fit: cover;
        border: 2px solid var(--orange);
        flex-shrink: 0;
    }

    .avatar-placeholder {
        width: 56px;
        height: 56px;
        border-radius: 50%;
        background: linear-gradient(135deg, var(--orange), var(--red));
        display: flex;
        align-items: center;
        justify-content: center;
        font-family: 'Playfair Display', serif;
        font-size: 1.4rem;
        font-weight: 700;
        color: #fff;
        flex-shrink: 0;
    }

    .card-name {
        font-weight: 700;
        font-size: 1rem;
        color: var(--dark);
        line-height: 1.2;
    }

    .card-username {
        font-size: .82rem;
        color: var(--muted);
        margin-top: .1rem;
    }

    .card-city {
        font-size: .83rem;
        color: var(--muted);
        display: flex;
        align-items: center;
        gap: .3rem;
    }

    .tag-row {
        display: flex;
        flex-wrap: wrap;
        gap: .4rem;
    }

    .tag {
        font-size: .75rem;
        font-weight: 600;
        padding: .25rem .7rem;
        border-radius: 999px;
    }

    .tag-genre {
        background: rgba(255,131,131,.15);
        color: #c0392b;
        border: 1px solid rgba(255,131,131,.3);
    }

    .tag-instrument {
        background: rgba(255,193,147,.2);
        color: #8b4513;
        border: 1px solid rgba(255,193,147,.4);
    }

    .card-status {
        font-size: .78rem;
        font-weight: 600;
        margin-top: auto;
        padding: .3rem .75rem;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: .35rem;
        align-self: flex-start;
    }

    .status-in-band {
        background: rgba(34,197,94,.12);
        color: #16a34a;
        border: 1px solid rgba(34,197,94,.25);
    }

    .status-looking {
        background: rgba(255,193,147,.2);
        color: #c05200;
        border: 1px solid rgba(255,193,147,.45);
    }

    /* ── EMPTY STATE ── */
    .empty-state {
        text-align: center;
        padding: 5rem 1rem;
        color: var(--muted);
    }

    .empty-state .emoji { font-size: 3.5rem; margin-bottom: 1rem; }
    .empty-state p { font-size: 1.1rem; }

    /* ── PAGINATION ── */
    .pagination-wrap {
        margin-top: 3rem;
        display: flex;
        justify-content: center;
    }
</style>

    <!-- Hero -->
    <div class="hero-strip">
        <h1>Encuentra tu próximo<br><span>compañero de banda</span></h1>
        <p>Conecta con músicos de toda España</p>
    </div>

    <!-- Filtros -->
    <div class="filter-wrap">
        <form method="GET" action="{{ route('home') }}" class="filter-card">
            <input
                type="text"
                name="search"
                value="{{ request('search') }}"
                placeholder="Nombre o usuario..."
                class="filter-input"
            >
            <input
                type="text"
                name="city"
                value="{{ request('city') }}"
                placeholder="Ciudad..."
                class="filter-input"
            >
            <select name="genre" class="filter-input">
                <option value="">Todos los géneros</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>
                        {{ $genre->name }}
                    </option>
                @endforeach
            </select>
            <select name="instrument" class="filter-input">
                <option value="">Todos los instrumentos</option>
                @foreach($instruments as $instrument)
                    <option value="{{ $instrument->id }}" {{ request('instrument') == $instrument->id ? 'selected' : '' }}>
                        {{ $instrument->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn-search">Buscar →</button>
        </form>
    </div>

    <!-- Resultados -->
    <div class="content-wrap">
        @if($musicians->isEmpty())
            <div class="empty-state">
                <div class="emoji">🎵</div>
                <p>No se encontraron músicos con esos filtros.</p>
            </div>
        @else
            <p class="results-label">{{ $musicians->total() }} músicos encontrados</p>

            <div class="musician-grid">
                @foreach($musicians as $musician)
                    <a href="{{ route('profile.show', $musician->username) }}" class="musician-card">

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
                                <p class="card-username">@{{ $musician->username }}</p>
                            </div>
                        </div>

                        @if($musician->city)
                            <p class="card-city">📍 {{ $musician->city }}</p>
                        @endif

                        @if($musician->genres->isNotEmpty())
                            <div class="tag-row">
                                @foreach($musician->genres->take(3) as $genre)
                                    <span class="tag tag-genre">{{ $genre->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        @if($musician->instruments->isNotEmpty())
                            <div class="tag-row">
                                @foreach($musician->instruments->take(3) as $instrument)
                                    <span class="tag tag-instrument">🎸 {{ $instrument->name }}</span>
                                @endforeach
                            </div>
                        @endif

                        <span class="card-status {{ $musician->has_band ? 'status-in-band' : 'status-looking' }}">
                            {{ $musician->has_band ? '✅ En banda' : '🔍 Buscando banda' }}
                        </span>

                    </a>
                @endforeach
            </div>

            <div class="pagination-wrap">
                {{ $musicians->withQueryString()->links() }}
            </div>
        @endif
    </div>

</x-app-layout>