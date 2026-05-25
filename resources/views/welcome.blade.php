<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Encuentra tu banda</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <style>
        .fade-in {
            opacity: 0;
            transform: translateY(24px);
            transition: opacity 0.6s ease, transform 0.6s ease;
        }
        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }
        .fade-in-delay-1 { transition-delay: 0.1s; }
        .fade-in-delay-2 { transition-delay: 0.25s; }
        .fade-in-delay-3 { transition-delay: 0.4s; }
    </style>
</head>
<body class="bg-cream text-text min-h-screen flex flex-col font-sans">

    <nav class="flex justify-between items-center px-8 py-5 bg-dark border-b border-brand/20">
        <span class="font-serif text-2xl font-extrabold text-brand tracking-tight">BANDICALIA</span>
        <div class="flex gap-4">
            <a href="{{ route('login') }}" class="px-4 py-2 rounded-lg border border-cream text-cream hover:bg-cream hover:text-dark transition">
                Iniciar sesión
            </a>
            <a href="{{ route('register') }}" class="px-4 py-2 rounded-lg bg-brand hover:bg-coral text-white transition font-semibold">
                Registrarse
            </a>
        </div>
    </nav>

    <main class="flex-1 flex flex-col items-center justify-center text-center px-6 py-20 bg-darker">
        <h1 class="fade-in font-serif text-5xl font-extrabold mb-6 leading-tight text-cream">
            Encuentra a los músicos<br>que necesitas
        </h1>
        <p class="fade-in fade-in-delay-1 text-white/70 text-xl max-w-xl mb-10">
            Bandicalia es la plataforma para conectar músicos. Crea tu perfil, muestra tus instrumentos y géneros favoritos, y forma tu banda ideal.
        </p>
        <div class="fade-in fade-in-delay-2 flex gap-4">
            <a href="{{ route('register') }}" class="px-8 py-3 bg-brand hover:bg-coral rounded-xl text-lg font-semibold transition text-white">
                Empieza gratis
            </a>
            <a href="{{ route('login') }}" class="px-8 py-3 border border-white/30 hover:border-peach text-cream rounded-xl text-lg font-semibold transition">
                Ya tengo cuenta
            </a>
        </div>
    </main>

    <section class="grid grid-cols-1 md:grid-cols-3 gap-8 px-12 py-16 bg-dark">
        <div class="fade-in fade-in-delay-1 text-center p-8 flex flex-col items-center">
            <div class="mb-6">
                <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="8" y="8" width="56" height="56" rx="16" fill="#FF3737" opacity="0.12"/>
                    <circle cx="36" cy="30" r="12" fill="#FF3737" opacity="0.9"/>
                    <rect x="20" y="48" width="32" height="6" rx="3" fill="#FF3737" opacity="0.6"/>
                </svg>
            </div>
            <h3 class="font-serif text-xl font-bold mb-3 text-brand">Tu perfil musical</h3>
            <p class="text-white/75 text-base">Añade tus instrumentos con tu nivel, géneros favoritos y tu historial de bandas.</p>
        </div>
        <div class="fade-in fade-in-delay-2 text-center p-8 flex flex-col items-center">
            <div class="mb-6">
                <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="8" y="8" width="56" height="56" rx="16" fill="#FF8383" opacity="0.12"/>
                    <circle cx="33" cy="33" r="13" stroke="#FF8383" stroke-width="5" fill="none"/>
                    <rect x="43" y="43" width="16" height="6" rx="3" fill="#FF8383" transform="rotate(45 43 43)"/>
                </svg>
            </div>
            <h3 class="font-serif text-xl font-bold mb-3 text-brand">Busca músicos</h3>
            <p class="text-white/75 text-base">Filtra por instrumento, género musical o ciudad y encuentra al músico perfecto.</p>
        </div>
        <div class="fade-in fade-in-delay-3 text-center p-8 flex flex-col items-center">
            <div class="mb-6">
                <svg width="72" height="72" viewBox="0 0 72 72" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <rect x="8" y="8" width="56" height="56" rx="16" fill="#FFC193" opacity="0.12"/>
                    <circle cx="24" cy="36" r="10" fill="#FFC193" opacity="0.9"/>
                    <circle cx="48" cy="36" r="10" fill="#FF8383" opacity="0.9"/>
                    <ellipse cx="36" cy="36" rx="8" ry="10" fill="#FF3737" opacity="0.85"/>
                </svg>
            </div>
            <h3 class="font-serif text-xl font-bold mb-3 text-brand">Conecta y toca</h3>
            <p class="text-white/75 text-base">Contacta con otros músicos y empieza a construir tu banda.</p>
        </div>
    </section>

    <section class="px-12 py-16 bg-cream">
        <h2 class="fade-in font-serif text-3xl font-extrabold text-center text-dark mb-12">¿Cómo funciona?</h2>
        <div class="max-w-4xl mx-auto flex flex-col md:flex-row items-start gap-8 md:gap-0">

            <div class="fade-in fade-in-delay-1 flex flex-col items-center text-center flex-1 px-6">
                <div class="w-12 h-12 rounded-full bg-brand text-white text-xl font-bold flex items-center justify-center mb-4">1</div>
                <h3 class="text-lg font-bold text-dark mb-2">Regístrate</h3>
                <p class="text-text text-sm">Crea tu cuenta en segundos. Solo necesitas un email y un nombre de usuario.</p>
            </div>

            <div class="hidden md:flex items-center self-start mt-5 text-peach text-3xl font-light select-none">›</div>

            <div class="fade-in fade-in-delay-2 flex flex-col items-center text-center flex-1 px-6">
                <div class="w-12 h-12 rounded-full bg-coral text-white text-xl font-bold flex items-center justify-center mb-4">2</div>
                <h3 class="text-lg font-bold text-dark mb-2">Crea tu perfil</h3>
                <p class="text-text text-sm">Añade tus instrumentos, niveles, géneros favoritos y cuéntanos si buscas banda.</p>
            </div>

            <div class="hidden md:flex items-center self-start mt-5 text-peach text-3xl font-light select-none">›</div>

            <div class="fade-in fade-in-delay-3 flex flex-col items-center text-center flex-1 px-6">
                <div class="w-12 h-12 rounded-full bg-peach text-white text-xl font-bold flex items-center justify-center mb-4">3</div>
                <h3 class="text-lg font-bold text-dark mb-2">Encuentra tu banda</h3>
                <p class="text-text text-sm">Busca músicos por ciudad, instrumento o género y contacta con quien encaje contigo.</p>
            </div>

        </div>
    </section>

    <footer class="text-center text-white/40 py-6 text-sm bg-dark border-t border-peach/30">
        © 2026 Bandicalia — TFG
    </footer>

    <script>
        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                    observer.unobserve(entry.target);
                }
            });
        }, { threshold: 0.15 });

        document.querySelectorAll('.fade-in').forEach(el => observer.observe(el));
    </script>

</body>
</html>