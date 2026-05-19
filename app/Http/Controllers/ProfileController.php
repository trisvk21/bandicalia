<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProfileUpdateRequest;
use App\Models\Genre;
use App\Models\Instrument;
use App\Models\BandHistory;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user'        => $request->user()->load('genres', 'instruments', 'bandHistories'),
            'genres'      => Genre::orderBy('name')->get(),
            'instruments' => Instrument::orderBy('name')->get(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $user = $request->user();

        $user->fill($request->safe()->except(['genres', 'instruments', 'instrument_ids', 'photo']));

        if ($user->isDirty('email')) {
            $user->email_verified_at = null;
        }

        // Subida de foto
        if ($request->hasFile('photo')) {
            if ($user->photo) {
                Storage::disk('public')->delete($user->photo);
            }
            $user->photo = $request->file('photo')->store('photos', 'public');
        }

        $user->save();

        // Sincronizar géneros
        $user->genres()->sync($request->input('genres', []));

        // Sincronizar instrumentos con nivel (solo los que tienen checkbox marcado)
        $instruments = [];
        foreach ($request->input('instrument_ids', []) as $id) {
            $level = $request->input("instruments.$id", 1);
            $instruments[$id] = ['level' => $level];
        }
        $user->instruments()->sync($instruments);

        return Redirect::route('profile.edit')->with('status', 'profile-updated');
    }

    /**
     * Ver el perfil público de un usuario.
     */
    public function show(string $username): View
    {
        $musician = \App\Models\User::where('username', $username)
            ->with('genres', 'instruments', 'bandHistories')
            ->firstOrFail();

        return view('profile.show', compact('musician'));
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}