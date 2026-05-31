<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Models\Message;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ChatController extends Controller
{
    private function canChat($me, $user): bool
    {
        return $me->following()
            ->wherePivot('status', 'accepted')
            ->where('users.id', $user->id)
            ->exists()
        ||
        $me->followers()
            ->wherePivot('status', 'accepted')
            ->where('users.id', $user->id)
            ->exists()
        ||
        \App\Models\Message::where(function($q) use ($me, $user) {
            $q->where('sender_id', $me->id)->where('receiver_id', $user->id);
        })->orWhere(function($q) use ($me, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $me->id);
        })->exists();
    }

    public function index()
    {
        $me = Auth::user();

        $userIds = Message::where('sender_id', $me->id)
            ->orWhere('receiver_id', $me->id)
            ->get()
            ->map(function ($msg) use ($me) {
                return $msg->sender_id === $me->id ? $msg->receiver_id : $msg->sender_id;
            })
            ->unique()
            ->values();

        $conversations = User::whereIn('id', $userIds)->get();

        return view('chat.index', compact('conversations'));
    }

    public function show(User $user)
    {
        $me = Auth::user();

        if (!$this->canChat($me, $user)) {
            abort(403);
        }

        $messages = Message::where(function ($q) use ($me, $user) {
            $q->where('sender_id', $me->id)->where('receiver_id', $user->id);
        })->orWhere(function ($q) use ($me, $user) {
            $q->where('sender_id', $user->id)->where('receiver_id', $me->id);
        })->orderBy('created_at')->get();

        Message::where('sender_id', $user->id)
            ->where('receiver_id', $me->id)
            ->where('read', false)
            ->update(['read' => true]);

        return view('chat.show', compact('user', 'messages'));
    }

    public function send(Request $request, User $user)
    {
        $me = Auth::user();

        if (!$this->canChat($me, $user)) {
            abort(403);
        }

        $request->validate(['body' => 'required|string|max:1000']);

        $message = Message::create([
            'sender_id'   => $me->id,
            'receiver_id' => $user->id,
            'body'        => $request->body,
        ]);

        $message->load('sender');
        broadcast(new MessageSent($message))->toOthers();

        return response()->json([
            'id'         => $message->id,
            'body'       => $message->body,
            'sender_id'  => $message->sender_id,
            'sender'     => $message->sender->username,
            'created_at' => $message->created_at->format('H:i'),
        ]);
    }
}