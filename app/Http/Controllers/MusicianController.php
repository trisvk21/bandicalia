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
        $user = auth()->user()->load('genres');
        $userGenreIds = $user->genres->pluck('id')->toArray();
        $userCity = $user->city;

        // ── Anuncios: primero los de tu ciudad, luego el resto ──
        $ads = Ad::with(['user', 'user.genres'])
            ->whereHas('user', fn($q) => $q->where('account_type', 'band'))
            ->latest()
            ->take(20)
            ->get()
            ->sortByDesc(function ($ad) use ($userCity) {
                return $userCity && strtolower($ad->user->city ?? '') === strtolower($userCity) ? 1 : 0;
            })
            ->take(10)
            ->values();

        // ── Músicos: primero tu ciudad, luego por géneros en común ──
        $featuredMusicians = User::with('genres', 'instruments')
            ->whereNotNull('username')
            ->where('account_type', 'musician')
            ->where('id', '!=', $user->id)
            ->get()
            ->sortByDesc(function ($m) use ($userCity, $userGenreIds) {
                $sameCity = $userCity && strtolower($m->city ?? '') === strtolower($userCity) ? 1000 : 0;
                $commonGenres = count(array_intersect($m->genres->pluck('id')->toArray(), $userGenreIds));
                return $sameCity + $commonGenres;
            })
            ->take(10)
            ->values();

        // ── Bandas: primero tu ciudad, luego por géneros en común ──
        $featuredBands = User::with('genres', 'ads')
            ->whereNotNull('username')
            ->where('account_type', 'band')
            ->where('id', '!=', $user->id)
            ->get()
            ->sortByDesc(function ($b) use ($userCity, $userGenreIds) {
                $sameCity = $userCity && strtolower($b->city ?? '') === strtolower($userCity) ? 1000 : 0;
                $commonGenres = count(array_intersect($b->genres->pluck('id')->toArray(), $userGenreIds));
                return $sameCity + $commonGenres;
            })
            ->take(10)
            ->values();

        // ── Buscador con filtros ──
        $tab = $request->input('tab', 'musicians');

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

        return view('musicians.index', compact(
            'ads', 'featuredMusicians', 'featuredBands',
            'musicians', 'bands',
            'genres', 'instruments', 'tab', 'user'
        ));
    }
}