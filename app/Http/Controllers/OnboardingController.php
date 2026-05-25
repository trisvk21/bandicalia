<?php

namespace App\Http\Controllers;

use App\Models\Genre;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class OnboardingController extends Controller
{
    public function show(Request $request): View
    {
        $user        = $request->user();
        $genres      = Genre::orderBy('name')->get();
        $instruments = Instrument::orderBy('name')->get();

        if ($user->account_type === 'band') {
            return view('onboarding.band', compact('user', 'genres'));
        }

        return view('onboarding.musician', compact('user', 'genres', 'instruments'));
    }

    public function store(Request $request): RedirectResponse
    {
        $user = $request->user();

        if ($user->account_type === 'band') {
            $request->validate([
                'city'           => ['nullable', 'string', 'max:255'],
                'bio'            => ['nullable', 'string', 'max:1000'],
                'soundcloud_url' => ['nullable', 'url', 'max:255'],
                'spotify_url'    => ['nullable', 'url', 'max:255'],
                'genres'         => ['nullable', 'array'],
                'genres.*'       => ['exists:genres,id'],
            ]);

            $user->update([
                'city'           => $request->city,
                'bio'            => $request->bio,
                'soundcloud_url' => $request->soundcloud_url,
                'spotify_url'    => $request->spotify_url,
            ]);

            $user->genres()->sync($request->input('genres', []));

        } else {
            $request->validate([
                'city'          => ['nullable', 'string', 'max:255'],
                'age'           => ['nullable', 'integer', 'min:13', 'max:100'],
                'general_level' => ['nullable', 'integer', 'min:1', 'max:5'],
                'bio'           => ['nullable', 'string', 'max:1000'],
                'has_band'      => ['nullable', 'boolean'],
                'soundcloud_url'=> ['nullable', 'url', 'max:255'],
                'spotify_url'   => ['nullable', 'url', 'max:255'],
                'genres'        => ['nullable', 'array'],
                'genres.*'      => ['exists:genres,id'],
                'instruments'   => ['nullable', 'array'],
                'instruments.*' => ['exists:instruments,id'],
            ]);

            $user->update([
                'city'           => $request->city,
                'age'            => $request->age,
                'general_level'  => $request->general_level,
                'bio'            => $request->bio,
                'has_band'       => $request->boolean('has_band'),
                'soundcloud_url' => $request->soundcloud_url,
                'spotify_url'    => $request->spotify_url,
            ]);

            $user->genres()->sync($request->input('genres', []));

            // Sincronizar instrumentos con nivel
            $instrumentsData = [];
            foreach ($request->input('instruments', []) as $instrumentId) {
                $instrumentsData[$instrumentId] = [
                    'level' => $request->input("instrument_level_{$instrumentId}", 1),
                ];
            }
            $user->instruments()->sync($instrumentsData);
        }

        return redirect()->route('home');
    }
}