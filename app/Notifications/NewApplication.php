<?php

namespace App\Notifications;

use App\Models\Application;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewApplication extends Notification
{
    use Queueable;

    public function __construct(public Application $application) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $musician = $this->application->user;
        $ad = $this->application->ad;

        return [
            'ad_id'             => $ad->id,
            'ad_title'          => $ad->title,
            'musician_id'       => $musician->id,
            'musician_username' => $musician->username,
            'musician_photo'    => $musician->photo,
        ];
    }
}