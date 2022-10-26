<?php

declare(strict_types=1);

namespace App\Notifications\Recipe;

use App\Kernel\Notifications\Messages\TelegramMessage;
use App\Kernel\Notifications\Messages\ViberMessage;
use App\Models\Recipe;
use Illuminate\Notifications\AnonymousNotifiable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Messages\SimpleMessage;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Str;

final class ShareRecipeNotification extends Notification
{
    /**
     * Create a new notification instance.
     */
    public function __construct(
        private string $sender,
        private Recipe $recipe,
        private string $url,
    ) {
    }

    /**
     * Get the notification's delivery channels.
     */
    public function via(AnonymousNotifiable $notifiable): array
    {
        return \array_keys($notifiable->routes);
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(): MailMessage
    {
        return $this->buildMessage(new MailMessage());
    }

    /**
     * Get the telegram representation of the notification.
     */
    public function toTelegram(): TelegramMessage
    {
        return $this->buildMessage(new TelegramMessage());
    }

    /**
     * Get the viber representation of the notification.
     */
    public function toViber(): ViberMessage
    {
        return $this->buildMessage(new ViberMessage());
    }

    /**
     * Build message.
     */
    private function buildMessage(SimpleMessage $message): SimpleMessage
    {
        $message
            ->greeting(\__('recipe/share_notification.greeting'))
            ->line(\__('recipe/share_notification.text', [
                'user' => $this->sender,
                'recipe' => $this->recipe->getTitle(),
            ]))
            ->action(\__('recipe/share_notification.action_text'), $this->url);

        if ($message instanceof MailMessage) {
            $message
                ->subject(\__('recipe/share_notification.subject', [
                    'recipe' => $this->recipe->getTitle(),
                ]))
                ->from('noreply@'.Str::after(\config('mail.from.address'), '@'));
        }

        return $message;
    }
}
