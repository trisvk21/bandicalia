<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Genre;
use App\Models\Instrument;
use App\Models\Ad;
use Illuminate\Http\Request;
use Illuminate\View\View;

class MusicianController extends Controller
{
    public function index(Request $request): View
    {
        $tab = $request->input('tab', 'musicians');

        // Query músicos
        $musiciansQuery = User::with('genres', 'instruments')
            ->whereNotNull('username')
            ->where('account_type', 'musician');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $musiciansQuery->where(function ($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                  ->orWhere('full_name', 'like', "%$search%")
                  ->orWhere('name', 'like', "%$search%");
            });
        }

        if ($request->filled('city')) {
            $musiciansQuery->where('city', 'like', '%' . $request->input('city') . '%');
        }

        if ($request->filled('genre')) {
            $musiciansQuery->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->input('genre'));
            });
        }

        if ($request->filled('instrument')) {
            $musiciansQuery->whereHas('instruments', function ($q) use ($request) {
                $q->where('instruments.id', $request->input('instrument'));
            });
        }

        $musicians = $musiciansQuery->paginate(12, ['*'], 'musicians_page');

        // Query bandas
        $bandsQuery = User::with('genres', 'ads')
            ->whereNotNull('username')
            ->where('account_type', 'band');

        if ($request->filled('search')) {
            $search = $request->input('search');
            $bandsQuery->where(function ($q) use ($search) {
                $q->where('username', 'like', "%$search%")
                  ->orWhere('full_name', 'like', "%$search%")
                  ->orWhere('name', 'like', "%$search%");
            });
        }

        if ($request->filled('city')) {
            $bandsQuery->where('city', 'like', '%' . $request->input('city') . '%');
        }

        if ($request->filled('genre')) {
            $bandsQuery->whereHas('genres', function ($q) use ($request) {
                $q->where('genres.id', $request->input('genre'));
            });
        }

        $bands = $bandsQuery->paginate(12, ['*'], 'bands_page');

        $genres      = Genre::orderBy('name')->get();
        $instruments = Instrument::orderBy('name')->get();

        return view('musicians.index', compact('musicians', 'bands', 'genres', 'instruments', 'tab'));
    }
}