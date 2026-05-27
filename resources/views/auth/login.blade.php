<x-guest-layout>
    <x-auth-session-status class="mb-4" :status="session('status')" />

    <h2 class="font-serif text-2xl font-bold text-cream mb-6">Bienvenido de nuevo</h2>

    <form method="POST" action="{{ route('login') }}" class="flex flex-col gap-5">
        @csrf

        <!-- Email -->
        <div class="flex flex-col gap-1">
            <label for="email" class="text-sm font-semibold text-peach">Email</label>
            <input
                id="email"
                type="email"
                name="email"
                value="{{ old('email') }}"
                required autofocus autocomplete="username"
                class="bg-darker border border-peach/20 rounded-xl px-4 py-3 text-cream placeholder-white/20 text-sm focus:outline-none focus:border-peach transition"
                placeholder="tu@email.com"
            >
            @error('email')
                <p class="text-brand text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Password -->
        <div class="flex flex-col gap-1">
            <label for="password" class="text-sm font-semibold text-peach">Contraseña</label>
            <div class="relative">
                <input
                    id="password"
                    type="password"
                    name="password"
                    required autocomplete="current-password"
                    class="w-full bg-darker border border-peach/20 rounded-xl px-4 py-3 pr-11 text-cream placeholder-white/20 text-sm focus:outline-none focus:border-peach transition"
                    placeholder="••••••••"
                >
                <button
                    type="button"
                    onclick="togglePassword()"
                    class="absolute inset-y-0 right-3 flex items-center text-white/30 hover:text-peach transition"
                    tabindex="-1"
                >
                    <svg id="eye-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.477 0 8.268 2.943 9.542 7-1.274 4.057-5.065 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg id="eye-off-icon" xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.477 0-8.268-2.943-9.542-7a9.97 9.97 0 012.189-3.593M6.53 6.53A9.97 9.97 0 0112 5c4.477 0 8.268 2.943 9.542 7a9.97 9.97 0 01-1.357 2.607M6.53 6.53L3 3m3.53 3.53l11.94 11.94" />
                    </svg>
                </button>
            </div>
            @error('password')
                <p class="text-brand text-xs mt-1">{{ $message }}</p>
            @enderror
        </div>

        <!-- Remember + Forgot -->
        <div class="flex items-center justify-between">
            <label class="flex items-center gap-2 cursor-pointer">
                <input type="checkbox" name="remember" class="rounded border-peach/30 bg-darker text-brand focus:ring-coral">
                <span class="text-sm text-white/50">Recuérdame</span>
            </label>
            @if (Route::has('password.request'))
                <a href="{{ route('password.request') }}" class="text-sm text-white/40 hover:text-peach transition">
                    ¿Olvidaste tu contraseña?
                </a>
            @endif
        </div>

        <!-- Submit -->
        <button type="submit" class="w-full bg-brand hover:bg-coral text-white font-bold py-3 rounded-xl transition text-sm">
            Iniciar sesión
        </button>

        <!-- Registro -->
        <p class="text-center text-sm text-white/40 border-t border-white/10 pt-4">
            ¿No tienes cuenta?
            <a href="{{ route('register') }}" class="text-peach font-semibold hover:text-coral transition">
                Regístrate
            </a>
        </p>

    </form>

    <script>
        function togglePassword() {
            const input = document.getElementById('password');
            const eyeIcon = document.getElementById('eye-icon');
            const eyeOffIcon = document.getElementById('eye-off-icon');
            const isHidden = input.type === 'password';
            input.type = isHidden ? 'text' : 'password';
            eyeIcon.classList.toggle('hidden', isHidden);
            eyeOffIcon.classList.toggle('hidden', !isHidden);
        }
    </script>
</x-guest-layout>