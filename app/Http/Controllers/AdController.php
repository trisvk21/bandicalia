<?php

namespace App\Http\Controllers;

use App\Models\Ad;
use App\Models\Application;
use App\Notifications\ApplicationStatusChanged;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use App\Notifications\NewBandAd;

class AdController extends Controller
{
    public function create(): View
    {
        return view('ads.create');
    }

    public function store(Request $request): RedirectResponse
{
    $request->validate([
        'title' => ['required', 'string', 'max:100'],
        'body'  => ['required', 'string', 'max:1000'],
    ]);

    $ad = $request->user()->ads()->create([
        'title' => $request->input('title'),
        'body'  => $request->input('body'),
    ]);

    $ad->load('user');

    // Notificar a todos los seguidores de la banda
    $followers = $request->user()->followers()
        ->wherePivot('status', 'accepted')
        ->get();

    foreach ($followers as $follower) {
        $follower->notify(new NewBandAd($ad));
    }

    return redirect()->route('ads.index')->with('status', 'ad-created');
}

    public function destroy(Ad $ad): RedirectResponse
    {
        abort_if($ad->user_id !== auth()->id(), 403);
        $ad->delete();
        return redirect()->route('profile.edit')->with('status', 'ad-deleted');
    }

    public function index(): View
{
    $me = auth()->user();

    if ($me && $me->account_type === 'band') {
        // Primero los propios, luego el resto
        $ads = Ad::with('user')
            ->whereHas('user', fn($q) => $q->where('account_type', 'band'))
            ->orderByRaw('user_id = ? DESC', [$me->id])
            ->latest()
            ->paginate(10);
    } else {
        $ads = Ad::with('user')
            ->whereHas('user', fn($q) => $q->where('account_type', 'band'))
            ->latest()
            ->paginate(10);
    }

    return view('ads.index', compact('ads'));
}

    public function show(Ad $ad): View
    {
        $ad->load('user.genres', 'applications');

        $alreadyApplied = auth()->check()
            ? $ad->applications->where('user_id', auth()->id())->isNotEmpty()
            : false;

        return view('ads.show', compact('ad', 'alreadyApplied'));
    }

    public function apply(Request $request, Ad $ad): RedirectResponse
    {
        abort_if($ad->user_id === auth()->id(), 403);

        $alreadyApplied = Application::where('ad_id', $ad->id)
            ->where('user_id', auth()->id())
            ->exists();

        if ($alreadyApplied) {
            return back()->with('error', 'Ya has enviado una solicitud para este anuncio.');
        }

        $request->validate([
            'message' => ['required', 'string', 'max:1000'],
        ]);

        Application::create([
            'ad_id'   => $ad->id,
            'user_id' => auth()->id(),
            'message' => $request->input('message'),
        ]);

        return back()->with('success', '¡Solicitud enviada correctamente!');
    }

    public function applications(Ad $ad): View
    {
        abort_if($ad->user_id !== auth()->id(), 403);

        $ad->load('applications.user.genres', 'applications.user.instruments');

        return view('ads.applications', compact('ad'));
    }

    public function updateApplication(Request $request, Ad $ad, Application $application): RedirectResponse
    {
        abort_if($ad->user_id !== auth()->id(), 403);
        abort_if($application->ad_id !== $ad->id, 403);

        $request->validate([
            'status' => ['required', 'in:accepted,rejected'],
        ]);

        $application->update(['status' => $request->status]);

        if ($request->status === 'accepted') {
    $band = auth()->user();
    $musician = $application->user;

    \App\Models\Message::create([
        'sender_id'   => $band->id,
        'receiver_id' => $musician->id,
        'body'        => "¡Hola! Hemos aceptado tu solicitud para el anuncio \"{$ad->title}\". ¡Bienvenido al equipo!",
    ]);

    $application->user->notify(new ApplicationStatusChanged($application));

    return redirect()->route('chat.show', $musician)->with('success', 'Solicitud aceptada.');
}
        // Notificar al músico
        $application->user->notify(new ApplicationStatusChanged($application));

        $msg = $request->status === 'accepted' ? 'Solicitud aceptada.' : 'Solicitud rechazada.';

        return back()->with('success', $msg);
    }
}