<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bandicalia — Mi perfil</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-950 text-white min-h-screen flex flex-col">

    <!-- Navbar -->
    <nav class="flex justify-between items-center px-8 py-5 bg-gray-900 border-b border-gray-800">
        <a href="{{ route('home') }}" class="text-2xl font-bold text-brand-red">BANDICALIA</a>
        <div class="flex gap-4 items-center">
            <a href="{{ route('profile.edit') }}" class="text-indigo-400 font-semibold">Mi perfil</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="px-4 py-2 rounded-lg border border-gray-600 hover:border-red-400 hover:text-red-400 transition">
                    Cerrar sesión
                </button>
            </form>
        </div>
    </nav>

    <main class="flex-1 px-8 py-10 max-w-4xl mx-auto w-full">

        <h1 class="text-3xl font-bold mb-8">Editar mi perfil</h1>

        @if(session('status') === 'profile-updated')
            <div class="bg-green-800 text-green-200 px-4 py-3 rounded-lg mb-6">
                ✅ Perfil actualizado correctamente.
            </div>
        @endif

        <form method="POST" action="{{ route('profile.update') }}" enctype="multipart/form-data" class="flex flex-col gap-8">
            @csrf
            @method('PATCH')
            <input type="hidden" name="name" value="{{ $user->name }}">
            <!-- Información básica -->
            <div class="bg-gray-900 rounded-2xl p-6 flex flex-col gap-4">
                <h2 class="text-xl font-semibold text-indigo-400">Información básica</h2>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Nombre de usuario *</label>
                        <input type="text" name="username" value="{{ old('username', $user->username) }}"
                            class="w-full bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('username') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Nombre completo</label>
                        <input type="text" name="full_name" value="{{ old('full_name', $user->full_name) }}"
                            class="w-full bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Email *</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}"
                            class="w-full bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                        @error('email') <p class="text-red-400 text-sm mt-1">{{ $message }}</p> @enderror
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Ciudad</label>
                        <input type="text" name="city" value="{{ old('city', $user->city) }}"
                            class="w-full bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Edad</label>
                        <input type="number" name="age" value="{{ old('age', $user->age) }}" min="14" max="100"
                            class="w-full bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                    </div>
                    <div>
                        <label class="text-sm text-gray-400 mb-1 block">Nivel general (1-5)</label>
                        <select name="general_level" class="w-full bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                            @for($i = 1; $i <= 5; $i++)
                                <option value="{{ $i }}" {{ old('general_level', $user->general_level) == $i ? 'selected' : '' }}>
                                    {{ $i }} — {{ ['', 'Principiante', 'Básico', 'Intermedio', 'Avanzado', 'Profesional'][$i] }}
                                </option>
                            @endfor
                        </select>
                    </div>
                </div>

                <div>
                    <label class="text-sm text-gray-400 mb-1 block">Biografía</label>
                    <textarea name="bio" rows="3"
                        class="w-full bg-gray-800 rounded-lg px-4 py-2 text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">{{ old('bio', $user->bio) }}</textarea>
                </div>

                <div class="flex items-center gap-3">
                    <input type="checkbox" name="has_band" id="has_band" value="1" {{ $user->has_band ? 'checked' : '' }}
                        class="w-4 h-4 accent-indigo-500">
                    <label for="has_band" class="text-gray-300">Actualmente estoy en una banda</label>
                </div>

                <div>
                    <label class="text-sm text-gray-400 mb-1 block">Foto de perfil</label>
                    @if($user->photo)
                        <img src="{{ Storage::url($user->photo) }}" class="w-20 h-20 rounded-full object-cover mb-2">
                    @endif
                    <input type="file" name="photo" accept="image/*"
                        class="text-gray-300 text-sm">
                </div>
            </div>

            <!-- Géneros -->
            <div class="bg-gray-900 rounded-2xl p-6 flex flex-col gap-4">
                <h2 class="text-xl font-semibold text-indigo-400">Géneros musicales</h2>
                <div class="grid grid-cols-2 sm:grid-cols-3 md:grid-cols-4 gap-3">
                    @foreach($genres as $genre)
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="checkbox" name="genres[]" value="{{ $genre->id }}"
                                {{ $user->genres->contains($genre->id) ? 'checked' : '' }}
                                class="w-4 h-4 accent-indigo-500">
                            <span class="text-gray-300 text-sm">{{ $genre->name }}</span>
                        </label>
                    @endforeach
                </div>
            </div>

            <!-- Instrumentos -->
            <div class="bg-gray-900 rounded-2xl p-6 flex flex-col gap-4">
                <h2 class="text-xl font-semibold text-indigo-400">Instrumentos</h2>
                <p class="text-gray-400 text-sm">Selecciona tus instrumentos y asigna tu nivel del 1 (principiante) al 5 (profesional).</p>
                <div class="flex flex-col gap-3">
                    @foreach($instruments as $instrument)
                        @php
                            $pivot = $user->instruments->find($instrument->id);
                            $checked = $pivot !== null;
                            $level = $pivot ? $pivot->pivot->level : 1;
                        @endphp
                        <div class="flex items-center gap-4">
                            <input type="checkbox" name="instrument_ids[]" value="{{ $instrument->id }}"
                                id="inst_{{ $instrument->id }}" {{ $checked ? 'checked' : '' }}
                                class="w-4 h-4 accent-indigo-500">
                            <label for="inst_{{ $instrument->id }}" class="text-gray-300 text-sm w-44">{{ $instrument->name }}</label>
                            <select name="instruments[{{ $instrument->id }}]"
                                class="bg-gray-800 rounded-lg px-3 py-1 text-sm text-white focus:outline-none focus:ring-2 focus:ring-indigo-500">
                                @for($i = 1; $i <= 5; $i++)
                                    <option value="{{ $i }}" {{ $level == $i ? 'selected' : '' }}>Nivel {{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    @endforeach
                </div>
            </div>

            <button type="submit" class="bg-indigo-500 hover:bg-indigo-600 rounded-xl px-8 py-3 font-semibold text-lg transition">
                Guardar cambios
            </button>
        </form>
    </main>

    <footer class="text-center text-gray-600 py-6 text-sm">
        © 2026 Bandicalia — TFG
    </footer>

</body>
</html>