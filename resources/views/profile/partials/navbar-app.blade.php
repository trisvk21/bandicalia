<nav class="flex justify-between items-center px-8 py-5 bg-dark border-b border-brand/20">
    <a href="{{ route('home') }}" class="font-serif text-2xl font-extrabold text-brand tracking-tight">BANDICALIA</a>
    <div class="flex gap-4 items-center">
        <a href="{{ route('profile.edit') }}" class="text-gray-300 hover:text-white transition">Mi perfil</a>
        <form method="POST" action="{{ route('logout') }}">
            @csrf
            <button type="submit" class="px-4 py-2 rounded-lg border border-gray-600 hover:border-red-400 hover:text-red-400 transition">
                Cerrar sesión
            </button>
        </form>
    </div>
</nav>