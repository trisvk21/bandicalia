<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Notifications\NewFollower;

class FollowController extends Controller
{
    // Enviar solicitud de seguimiento
    public function send(User $user)
{
    $me = Auth::user();

    if ($me->id === $user->id) {
        return back();
    }

    if (!$me->isFollowing($user)) {
        $me->following()->attach($user->id, ['status' => 'pending']);
        
        // Notificar al usuario que ha recibido una solicitud
        $user->notify(new NewFollower($me));
    }

    return back()->with('status', 'solicitud-enviada');
}

    // Aceptar solicitud
    public function accept(User $user)
{
    Auth::user()->followers()
        ->updateExistingPivot($user->id, ['status' => 'accepted']);

    // Marcar notificación como leída
    Auth::user()->notifications()
        ->where('data->follower_id', $user->id)
        ->delete();

    return back()->with('status', 'solicitud-aceptada');
}

    // Cancelar solicitud o dejar de seguir
    public function unfollow(User $user)
    {
        Auth::user()->following()->detach($user->id);
        return back();
    }

    // Lista de personas que sigues
    public function following()
    {
        $following = Auth::user()->following()
            ->wherePivot('status', 'accepted')
            ->get();

        return view('follows.following', compact('following'));
    }

    // Lista de solicitudes recibidas pendientes
    public function requests()
    {
        $requests = Auth::user()->followers()
            ->wherePivot('status', 'pending')
            ->get();

        return view('follows.requests', compact('requests'));
    }
    public function reject(User $user)
{
    Auth::user()->followers()->detach($user->id);

    // Marcar notificación como leída
    Auth::user()->notifications()
        ->where('data->follower_id', $user->id)
        ->delete();

    return back();
}
}