<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class ApplicationStatusChanged extends Notification
{
    use Queueable;

    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $ad = $this->application->ad;
        $status = $this->application->status;

        return [
            'ad_id'    => $ad->id,
            'ad_title' => $ad->title,
            'band'     => $ad->user->username,
            'status'   => $status,
            'message'  => $status === 'accepted'
                ? "¡{$ad->user->username} ha aceptado tu solicitud para \"{$ad->title}\"!"
                : "{$ad->user->username} ha rechazado tu solicitud para \"{$ad->title}\".",
        ];
    }
}