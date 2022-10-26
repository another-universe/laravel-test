<?php

declare(strict_types=1);

namespace App\Kernel\Notifications\Channels;

use Illuminate\Notifications\Notification;

final class ViberChannel
{
    /**
     * Send the given notification.
     */
    public function send(object $notifiable, Notification $notification): void
    {
        $message = $notification->toViber();
        $recipient = $notifiable->routeNotificationFor('viber', $notification);
    }
}
