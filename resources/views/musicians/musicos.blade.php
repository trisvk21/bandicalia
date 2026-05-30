<x-app-layout>

    <!-- Hero -->
    <div class="bg-darker px-12 py-10 border-b border-peach/10">
        <div class="ml-[16%]">
            <h1 class="font-serif font-black text-cream leading-tight text-[clamp(2rem,4vw,3.2rem)]">
                Músicos<br><span class="text-peach">disponibles</span>
            </h1>
            <p class="text-muted mt-2 text-sm">Encuentra músicos de toda España</p>
        </div>
    </div>

    <!-- Filtros -->
    <div class="px-12 -translate-y-6">
        <form method="GET" action="{{ route('musicos') }}"
            class="bg-dark rounded-2xl px-7 py-5 grid grid-cols-1 md:grid-cols-5 gap-4 items-center border border-coral/15 shadow-2xl">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Nombre o usuario..."
                class="bg-darker border border-peach/20 rounded-xl px-4 py-2 text-cream text-sm placeholder:text-muted focus:outline-none focus:border-peach w-full">
            <input type="text" name="city" value="{{ request('city') }}" placeholder="Ciudad..."
                class="bg-darker border border-peach/20 rounded-xl px-4 py-2 text-cream text-sm placeholder:text-muted focus:outline-none focus:border-peach w-full">
            <select name="genre"
                class="bg-darker border border-peach/20 rounded-xl px-4 py-2 text-cream text-sm focus:outline-none focus:border-peach w-full">
                <option value="">Todos los géneros</option>
                @foreach($genres as $genre)
                    <option value="{{ $genre->id }}" {{ request('genre') == $genre->id ? 'selected' : '' }}>{{ $genre->name }}</option>
                @endforeach
            </select>
            <select name="instrument"
                class="bg-darker border border-peach/20 rounded-xl px-4 py-2 text-cream text-sm focus:outline-none focus:border-peach w-full">
                <option value="">Todos los instrumentos</option>
                @foreach($instruments as $instrument)
                    <option value="{{ $instrument->id }}" {{ request('instrument') == $instrument->id ? 'selected' : '' }}>{{ $instrument->name }}</option>
                @endforeach
            </select>
            <button type="submit"
                class="bg-brand hover:bg-coral text-white font-bold text-sm rounded-xl px-7 py-2.5 transition-all hover:-translate-y-px whitespace-nowrap">
                Buscar →
            </button>
        </form>
    </div>

    <!-- Resultados -->
    <div class="px-12 pb-12 max-w-[1280px] mx-auto w-full">

        @if($musicians->isEmpty())
            <div class="text-center py-20 text-muted">
                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5" class="mx-auto opacity-40">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 19V6l12-3v13M9 19c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zm12-3c0 1.105-1.343 2-3 2s-3-.895-3-2 1.343-2 3-2 3 .895 3 2zM9 10l12-3" />
                </svg>
                <p class="text-lg mt-4">No se encontraron músicos con esos filtros.</p>
            </div>
        @else
            <p class="text-xs text-muted font-semibold uppercase tracking-widest mb-6">
                {{ $musicians->total() }} músicos encontrados
            </p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-5">
                @foreach($musicians as $musician)
                    <a href="{{ route('profile.show', $musician->username) }}"
                        class="bg-[#fff8f0] rounded-[20px] flex flex-col border border-peach/30 transition-all duration-200 hover:-translate-y-1 hover:shadow-[0_16px_40px_rgba(255,55,55,0.1)] hover:border-coral overflow-hidden no-underline text-text group">

                        <div class="h-1 bg-gradient-to-r from-peach to-coral"></div>

                        <div class="p-5 flex flex-col gap-3 flex-1">
                            <div class="flex items-center gap-3">
                                @if($musician->photo)
                                    <img src="{{ Storage::url($musician->photo) }}"
                                    style="width:52px;height:52px;border-radius:14px;object-fit:cover;flex-shrink:0;border:2px solid rgba(255,193,147,.4)"
                                    alt="{{ $musician->name }}">
                                @else
                                    <div class="w-13 h-13 rounded-[14px] bg-gradient-to-br from-peach to-brand flex items-center justify-center font-serif text-xl font-bold text-white shrink-0"
                                        style="width:52px;height:52px">
                                        {{ strtoupper(substr($musician->name, 0, 1)) }}
                                    </div>
                                @endif
                                <div>
                                    <p class="font-bold text-[.95rem] text-dark leading-tight">{{ $musician->full_name ?? $musician->name }}</p>
                                    <p class="text-xs text-muted mt-0.5 font-medium">{{ '@' . $musician->username }}</p>
                                </div>
                            </div>

                            @if($musician->city)
                                <p class="text-xs text-muted flex items-center gap-1.5 font-medium">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="13" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round" class="opacity-60 shrink-0">
                                        <path d="M21 10c0 7-9 13-9 13s-9-6-9-13a9 9 0 0 1 18 0z"/><circle cx="12" cy="10" r="3"/>
                                    </svg>
                                    {{ $musician->city }}
                                </p>
                            @endif

                            @if($musician->genres->isNotEmpty())
                                <div class="flex flex-col gap-1">
                                    <span class="text-[.68rem] font-bold uppercase tracking-[.07em] text-muted">Géneros</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($musician->genres->take(3) as $genre)
                                            <span class="text-[.72rem] font-semibold px-2.5 py-0.5 rounded-full bg-brand/8 text-[#b92b2b] border border-brand/20">
                                                {{ $genre->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif

                            @if($musician->instruments->isNotEmpty())
                                <div class="flex flex-col gap-1">
                                    <span class="text-[.68rem] font-bold uppercase tracking-[.07em] text-muted">Instrumentos</span>
                                    <div class="flex flex-wrap gap-1">
                                        @foreach($musician->instruments->take(3) as $instrument)
                                            <span class="text-[.72rem] font-semibold px-2.5 py-0.5 rounded-full bg-peach/18 text-[#7a3b10] border border-peach/35">
                                                {{ $instrument->name }}
                                            </span>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        </div>

                        <div class="px-5 py-3 border-t border-peach/20 flex items-center justify-between">
                            <span class="text-xs font-bold px-2.5 py-1 rounded-md inline-flex items-center gap-1.5 tracking-wide
                                {{ $musician->has_band
                                    ? 'bg-green-500/10 text-green-700 border border-green-500/20'
                                    : 'bg-peach/15 text-[#9a3a00] border border-peach/35' }}">
                                @if($musician->has_band)
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="3" stroke-linecap="round" stroke-linejoin="round"><polyline points="20 6 9 17 4 12"/></svg>
                                    En banda
                                @else
                                    <svg xmlns="http://www.w3.org/2000/svg" width="11" height="11" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"><circle cx="11" cy="11" r="8"/><line x1="21" y1="21" x2="16.65" y2="16.65"/></svg>
                                    Busca banda
                                @endif
                            </span>
                            <span class="text-coral opacity-0 group-hover:opacity-100 group-hover:translate-x-1 transition-all duration-200 text-sm">→</span>
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="mt-12 flex justify-center">
                {{ $musicians->withQueryString()->links() }}
            </div>
        @endif
    </div>

</x-app-layout>