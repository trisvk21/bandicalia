<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Registro músico</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-darker font-sans flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-8 py-5 border-b border-brand/20">
        <a href="{{ route('landing') }}" class="font-serif text-2xl font-extrabold text-brand tracking-tight">
            BANDICALIA
        </a>
        <a href="{{ route('login') }}" class="text-white/60 hover:text-white text-sm transition">
            ¿Ya tienes cuenta? <span class="text-brand font-semibold">Inicia sesión</span>
        </a>
    </nav>

    <!-- Formulario -->
    <div class="flex-1 flex items-center justify-center px-4 py-12">
        <div class="w-full max-w-md">

            <div class="mb-8 text-center">
                <h1 class="font-serif text-3xl font-extrabold text-cream mb-2">Crea tu perfil de músico</h1>
                <p class="text-white/50 text-sm">Rellena los datos básicos. Podrás completar tu perfil después.</p>
            </div>

            <form method="POST" action="{{ route('register.musician.store') }}" class="space-y-5">
                @csrf

                <!-- Nombre -->
                <div>
                    <label for="name" class="block text-sm font-medium text-white/70 mb-1">Nombre completo</label>
                    <input id="name" type="text" name="name" value="{{ old('name') }}" required autofocus
                        class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    @error('name')
                        <p class="mt-1 text-sm text-coral">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Username -->
                <div>
                    <label for="username" class="block text-sm font-medium text-white/70 mb-1">Nombre de usuario</label>
                    <input id="username" type="text" name="username" value="{{ old('username') }}" required
                        class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    @error('username')
                        <p class="mt-1 text-sm text-coral">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email -->
                <div>
                    <label for="email" class="block text-sm font-medium text-white/70 mb-1">Correo electrónico</label>
                    <input id="email" type="email" name="email" value="{{ old('email') }}" required
                        class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    @error('email')
                        <p class="mt-1 text-sm text-coral">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Contraseña -->
                <div>
                    <label for="password" class="block text-sm font-medium text-white/70 mb-1">Contraseña</label>
                    <input id="password" type="password" name="password" required
                        class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                    @error('password')
                        <p class="mt-1 text-sm text-coral">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirmar contraseña -->
                <div>
                    <label for="password_confirmation" class="block text-sm font-medium text-white/70 mb-1">Confirmar contraseña</label>
                    <input id="password_confirmation" type="password" name="password_confirmation" required
                        class="w-full px-4 py-3 rounded-xl bg-dark border border-white/10 text-cream placeholder-white/30 focus:outline-none focus:border-brand focus:ring-1 focus:ring-brand transition" />
                </div>

                <button type="submit"
                    class="w-full py-3 bg-brand hover:bg-coral text-white font-semibold rounded-xl transition text-base mt-2">
                    Crear cuenta como músico
                </button>

                <p class="text-center text-white/40 text-sm">
                    ¿Te has equivocado?
                    <a href="{{ route('register') }}" class="text-brand hover:text-coral transition">Volver a elegir tipo de cuenta</a>
                </p>
            </form>

        </div>
    </div>

</body>
</html>