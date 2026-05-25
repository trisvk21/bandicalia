<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdController extends Controller
{
    /**
     * Mostrar formulario para crear anuncio.
     */
    public function create(): View
    {
        return view('ads.create');
    }

    /**
     * Guardar anuncio nuevo.
     */
    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'title' => ['required', 'string', 'max:100'],
            'body'  => ['required', 'string', 'max:1000'],
        ]);

        $request->user()->ads()->create([
            'title' => $request->input('title'),
            'body'  => $request->input('body'),
        ]);

        return redirect()->route('profile.edit')->with('status', 'ad-created');
    }

    /**
     * Eliminar anuncio.
     */
    public function destroy(Ad $ad): RedirectResponse
    {
        abort_if($ad->user_id !== auth()->id(), 403);

        $ad->delete();

        return redirect()->route('profile.edit')->with('status', 'ad-deleted');
    }
}