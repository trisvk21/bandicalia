<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use App\Models\Genre;
use App\Models\Instrument;

class ProfileController extends Controller
{
    // Vista que MUESTRA los datos del perfil
    public function show()
    {
        $user = Auth::user();
        $user->load('genres', 'instruments');
        return view('profile.show', compact('user'));
    }

    // Vista de edición con el formulario
    public function edit()
    {
        $user = Auth::user();
        $user->load('genres', 'instruments');
        $genres = Genre::orderBy('name')->get();
        $instruments = Instrument::orderBy('name')->get();
        return view('profile.edit', compact('user', 'genres', 'instruments'));
    }

    // Guarda los cambios y redirige al perfil
    public function update(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'username'      => 'required|string|max:255|unique:users,username,' . $user->id,
            'full_name'     => 'nullable|string|max:255',
            'email'         => 'required|email|unique:users,email,' . $user->id,
            'city'          => 'nullable|string|max:255',
            'age'           => 'nullable|integer|min:14|max:100',
            'general_level' => 'nullable|integer|between:1,5',
            'bio'           => 'nullable|string',
            'photo'         => 'nullable|image|max:2048',
        ]);

        // Foto de perfil
        if ($request->hasFile('photo')) {
            if ($user->photo) Storage::delete($user->photo);
            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        $user->update($request->only([
            'username', 'full_name', 'email',
            'city', 'age', 'general_level', 'bio'
        ]));

        $user->has_band = $request->boolean('has_band');
        $user->save();

        // Géneros
        $user->genres()->sync($request->input('genres', []));

        // Instrumentos con nivel
        $instrumentsSync = [];
        foreach ($request->input('instrument_ids', []) as $id) {
            $instrumentsSync[$id] = ['level' => $request->input("instruments.$id", 1)];
        }
        $user->instruments()->sync($instrumentsSync);

        return redirect()->route('profile.show')
            ->with('status', 'profile-updated');
    }
}