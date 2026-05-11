<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Genre;
use App\Models\Instrument;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MusicianController extends Controller
{
    /**
     * Página principal de búsqueda de músicos.
     */
    public function index(Request $request): View
    {
        $query = User::with('genres', 'instruments')
            ->whereNotNull('username');

        // Filtro por usuario o nombre
        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                  ->orWhere('full_name', 'like', "%$search%")
                  ->orWhere('name', 'like', "%$search%");
            });
        }

        // Filtro por ciudad
        if ($request->filled('city')) {
            $query->where('city', 'like', '%' . $request->input('city') . '%');
        }

        // Filtro por género musical
        if ($request->filled('genre')) {
            $query->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->input('genre'));
            });
        }

        // Filtro por instrumento
        if ($request->filled('instrument')) {
            $query->whereHas('instruments', function ($q) use ($request) {
                $q->where('instruments.id', $request->input('instrument'));
            });
        }

        $musicians = $query->paginate(12);
        $genres     = Genre::orderBy('name')->get();
        $instruments = Instrument::orderBy('name')->get();

        return view('musicians.index', compact('musicians', 'genres', 'instruments'));
    }
}