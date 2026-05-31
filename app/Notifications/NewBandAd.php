<?php

namespace App\Notifications;

use App\Models\Ad;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewBandAd extends Notification
{
    use Queueable;

    public Ad $ad;

    public function __construct(Ad $ad)
    {
        $this->ad = $ad;
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        return [
            'ad_id'          => $this->ad->id,
            'ad_title'       => $this->ad->title,
            'band_id'        => $this->ad->user->id,
            'band_username'  => $this->ad->user->username,
            'band_photo'     => $this->ad->user->photo,
        ];
    }
}